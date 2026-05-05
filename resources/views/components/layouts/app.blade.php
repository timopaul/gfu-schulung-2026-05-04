<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFU Event Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- style: Ensure x-cloak (Alpine.js) works before JS loads -->
    <style>[x-cloak] { display: none !important; }</style>
    @livewireStyles
</head>
<body class="bg-gray-100 p-4 md:p-12">
    <div class="max-w-7xl mx-auto">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
