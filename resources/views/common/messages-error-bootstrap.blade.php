@if (count($errors) > 0)
    <div class="alert alert-warning">
        <a href="#" class="close">×</a>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif