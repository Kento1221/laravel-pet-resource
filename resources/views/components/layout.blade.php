<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Pet resource</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          rel="stylesheet"/>
    <link href="{{ Vite::asset('resources/assets/select2/css/select2.min.css') }}"
          rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <meta name="csrf-token"
          content="{{ csrf_token() }}">
</head>
<body>
<div class="container mt-5">
    @if(!Request::is('/'))
        <div class="container mb-3">
            <a href="{{ route('pet.index') }}"
               class="btn btn-primary"><i class="fa-solid fa-chevron-left me-1"></i> Go to the homepage</a>
        </div>
    @endif
    <div class="alerts">
        <div class="alert alert-success"
             style="display: {{session('status') ? 'block' : 'none'}};">
            @if (session('status'))
                {{ session('status') }}
            @endif
        </div>
        <div class="alert alert-danger"
             style="display: {{$errors->any() ? 'block' : 'none'}};">
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    {{ $slot }}
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ Vite::asset('resources/assets/select2/js/select2.full.min.js') }}"></script>
</body>
</html>
