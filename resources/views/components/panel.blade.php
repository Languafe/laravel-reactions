@props(['model', 'allowedReactions' => config('reactions.allowed')])
<section>
    <form action="{{ route('reactions.store') }}" method="POST" data-reactions-form>
        @csrf
        <input type="hidden" name="reaction">
        <input type="hidden" name="reactable_id" value="{{ $model->getKey() }}">
        <input type="hidden" name="reactable_type" value="{{ $model::class }}">
        @foreach ($allowedReactions as $reaction)
            <button
                type="button"
                data-reaction="{{ $reaction }}"
                @auth
                    @if ($model->hasReactionFrom(Auth::user(), $reaction)) data-current-user-reaction @endif
                @else
                    disabled
                @endauth
            >
                @isset($model->reactionsKeyed[$reaction])
                {{ $model->reactionsKeyed[$reaction]->count }}
                @endisset
                {{ $reaction }}
            </button>
        @endforeach
    </form>
    <script>
        document.querySelectorAll('form[data-reactions-form]').forEach(form => {
            const handleReactionButtonClick = event => {
                form.querySelector('input[name=reaction]').value = event.target.dataset.reaction;
                form.submit();
            };

            form.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', handleReactionButtonClick);
            });
        });
    </script>
</section>


