<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <title>{{ config('app.name') }}</title>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    @vite(['resources/ts/app.ts', 'resources/css/app.css'])
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
