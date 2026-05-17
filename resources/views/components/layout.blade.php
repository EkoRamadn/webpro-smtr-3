<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Laravel' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 h-dvh w-dvw">

    
    <x-header>
        {{ $title }}
    </x-header>

    

    <main class="h-dvh w-dvw">
        {{ $slot }}
    </main>

</body>
</html>