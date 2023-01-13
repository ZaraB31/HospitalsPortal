@csrf

@if ($errors->any())
    <div class="error" id="errorAlert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif