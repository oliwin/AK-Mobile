@if(Session::has('success'))
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get('success') }}
    </div>
@endif