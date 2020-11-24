@if (session('status'))
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p class="mb-0">{{ session('status') }}</p>
    </div>
@endif

@if (session('message'))
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p class="mb-0">{{ session('message') }}</p>
    </div>
@endif