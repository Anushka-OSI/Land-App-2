@extends('layouts.admin')

@section('title', 'Message')

@section('content')

    <a href="{{ route('admin.messages.index') }}" class="back-link">&larr; Back to Messages</a>

    <div class="message-grid">
        <article class="panel message-panel">
            <div class="message-head">
                <div>
                    <span class="badge badge-type">{{ $message->type_label }}</span>
                    <h2>{{ $message->subject ?: 'Question from ' . $message->name }}</h2>
                </div>
                <span class="badge badge-{{ $message->status }}">{{ $message->status_label }}</span>
            </div>

            <dl class="message-meta">
                <div>
                    <dt>From</dt>
                    <dd>{{ $message->name }}</dd>
                </div>
                <div>
                    <dt>Email</dt>
                    <dd><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd>
                </div>
                @if($message->office)
                    <div>
                        <dt>Office</dt>
                        <dd>{{ $message->office }}</dd>
                    </div>
                @endif
                <div>
                    <dt>Received</dt>
                    <dd>{{ $message->created_at->format('M j, Y g:i A') }}</dd>
                </div>
            </dl>

            <div class="message-body">{{ $message->body }}</div>

            <div class="form-actions">
                <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: ' . ($message->subject ?: 'Your question to the Department of Land Title Settlement')) }}"
                    class="btn btn-primary">Reply by Email</a>
                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="inline"
                    data-confirm="Delete this message? This cannot be undone.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </article>

        <aside class="panel form-panel">
            <h3 class="panel-subtitle">Status & internal note</h3>
            <form method="POST" action="{{ route('admin.messages.update', $message) }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-input">
                        @foreach(\App\Models\Message::STATUSES as $key => $label)
                            <option value="{{ $key }}" @selected(old('status', $message->status) === $key)>{{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="admin_note">Internal note <span class="hint">(only visible to admins)</span></label>
                    <textarea id="admin_note" name="admin_note" rows="6"
                        class="form-input @error('admin_note') is-invalid @enderror">{{ old('admin_note', $message->admin_note) }}</textarea>
                    @error('admin_note') <small class="form-error">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block">Save</button>
            </form>
        </aside>
    </div>

@endsection
