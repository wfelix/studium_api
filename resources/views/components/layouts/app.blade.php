<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscreva-se</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-center bg-cover" style="background-image: url('{{ asset('/fundo.png') }}');">
    <div style="display: flex; justify-content: center; align-items: center;">
        {{ $slot }}
    </div>
</body>

</html>
