@if (session('status'))
    <div class="mb-5 bg-blue-50 border border-blue-100 rounded-md p-4" role="alert">
        {{ session('status') }}
    </div>
@endif
