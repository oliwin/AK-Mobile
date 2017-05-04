@if(Session::has('message'))
    <div class="alert alert-success">
        <a href="#" class="close">×</a>
        {{ Session::get('message') }}
    </div>
@endif