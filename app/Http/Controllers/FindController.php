<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FindController extends Controller
{
    /**
     * Show the Find Land page. The search runs in the browser (JavaScript),
     * which sends a GET request to the search() endpoint below.
     */
    public function index()
    {
        return view('find');
    }

    /**
     * GET /find/search?map_no=..&block_no=..&sheet_no=..&lot_no=..[&file_no=..]
     *
     * Calls the eTitle API:
     *   {base_url}/get-form14-get-record/{map}/{block}/{sheetno}/{lotno}
     * and returns its JSON unchanged:
     *   found:     {"message":[{...record...}],"states":200}
     *   not found: {"message":"Data Not found..","states":500}
     *
     * The eTitle API cannot search by file number, so an optional file_no only keeps
     * the records whose file number (file_no, or file_code) matches what was typed.
     */
    public function search(Request $request): JsonResponse
    {
        $rule = ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9\-]+$/'];

        $validated = $request->validate([
            'map_no'   => $rule,
            'block_no' => $rule,
            'sheet_no' => $rule,
            'lot_no'   => $rule,
            'file_no'  => ['nullable', 'string', 'max:100', 'regex:/^[\pL\pN\/\-\.\s()]+$/u'],
        ], [
            'map_no.required'   => __('Please enter the Map Number.'),
            'block_no.required' => __('Please enter the Block Number.'),
            'sheet_no.required' => __('Please enter the Sheet Number.'),
            'lot_no.required'   => __('Please enter the Lot Number.'),
            'file_no.regex'     => __('The File No can only contain letters, numbers, / - . and spaces.'),
            '*.regex'           => __('Only letters, numbers and hyphens are allowed.'),
        ]);

        $path = 'get-form14-get-record/' . implode('/', array_map(
            fn ($value) => rawurlencode(trim($value)),
            [$validated['map_no'], $validated['block_no'], $validated['sheet_no'], $validated['lot_no']]
        ));

        $response = $this->proxy($path);

        return filled($validated['file_no'] ?? null)
            ? $this->onlyFileNo($response, $validated['file_no'])
            : $response;
    }

    /** Keep only the records whose file number matches (ignoring upper/lower case and spaces). */
    private function onlyFileNo(JsonResponse $response, string $fileNo): JsonResponse
    {
        $json = $response->getData(true);

        if (!is_array($json) || (int) ($json['states'] ?? 0) !== 200 || !is_array($json['message'] ?? null)) {
            return $response; // not found / error – pass it on unchanged
        }

        $normalise = fn ($value) => preg_replace('/\s+/u', '', mb_strtolower(trim((string) $value)));
        $wanted = $normalise($fileNo);

        $records = array_is_list($json['message']) ? $json['message'] : [$json['message']];
        $matching = array_values(array_filter($records, fn ($record) => is_array($record) && (
            $normalise($record['file_no'] ?? '') === $wanted || $normalise($record['file_code'] ?? '') === $wanted
        )));

        if ($matching === []) {
            return response()->json([
                'states'  => 500,
                'message' => 'Data Not found..',
                'reason'  => 'file_no',
            ]);
        }

        return response()->json(['message' => $matching, 'states' => 200]);
    }

    /**
     * GET /find/search-nic?nic=..
     *
     * Calls the eTitle "search by NIC" API (path set by ETITLE_NIC_PATH in .env)
     * and returns its JSON unchanged.
     */
    public function searchByNic(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nic' => ['required', 'string', 'regex:/^([0-9]{9}[vVxX]|[0-9]{12})$/'],
        ], [
            'nic.required' => __('Please enter your NIC number.'),
            'nic.regex'    => __('Enter a valid NIC (e.g. 851234567V or 198512345678).'),
        ]);

        $nicPath = config('services.etitle.nic_path');

        if (!$nicPath) {
            return response()->json([
                'states'  => 501,
                'message' => __('Search by NIC is not available yet. Please search using the Map, Block, Sheet and Lot numbers.'),
            ], 501);
        }

        $path = str_replace('{nic}', rawurlencode(strtoupper($validated['nic'])), ltrim($nicPath, '/'));

        return $this->proxy($path);
    }

    /**
     * Call {base_url}/{path} on the eTitle API and return its JSON.
     *   found:     {"message":[{...record...}],"states":200}
     *   not found: {"message":"Data Not found..","states":500}
     */
    private function proxy(string $path): JsonResponse
    {
        $baseUrl = rtrim(config('services.etitle.base_url'), '/');
        $url = $baseUrl . '/' . $path;

        try {
            $response = $this->callApi($url, $baseUrl);
        } catch (ConnectionException $e) {
            Log::warning('eTitle API unreachable', ['url' => $url, 'error' => $e->getMessage()]);

            return response()->json([
                'states'  => 503,
                'message' => __('Unable to reach the land records service. Please try again later.'),
            ], 503);
        }

        $json = $response->json();

        if (!is_array($json)) {
            Log::warning('eTitle API returned non-JSON', ['url' => $url, 'status' => $response->status()]);

            return response()->json([
                'states'  => 502,
                'message' => __('The land records service returned an unexpected response.'),
            ], 502);
        }

        return response()->json($json);
    }

    /**
     * Call the API normally; if the connection fails and a fallback IP is configured,
     * retry while forcing the host name to resolve to that IP. Some networks' DNS
     * returns an internal address (10.250.1.139) that is unreachable from outside.
     */
    private function callApi(string $url, string $baseUrl): Response
    {
        $timeout = (int) config('services.etitle.timeout', 20);
        $fallbackIp = config('services.etitle.fallback_ip');

        $request = fn (array $curlOptions = []) => Http::acceptJson()
            ->connectTimeout($fallbackIp ? 5 : $timeout)
            ->timeout($timeout)
            ->withOptions(['curl' => $curlOptions])
            ->get($url);

        try {
            return $request();
        } catch (ConnectionException $e) {
            if (!$fallbackIp) {
                throw $e;
            }

            $host = parse_url($baseUrl, PHP_URL_HOST);
            $port = parse_url($baseUrl, PHP_URL_PORT)
                ?: (parse_url($baseUrl, PHP_URL_SCHEME) === 'https' ? 443 : 80);

            Log::info('eTitle API: retrying via fallback IP', ['host' => $host, 'ip' => $fallbackIp]);

            return $request([CURLOPT_RESOLVE => ["{$host}:{$port}:{$fallbackIp}"]]);
        }
    }
}
