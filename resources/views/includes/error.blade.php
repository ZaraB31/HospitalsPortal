@csrf

@if ($errors->any())
    <div class="error" id="errorAlert" style="display:block;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif