<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Studium API</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('swagger-ui.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}" sizes="16x16" />
    <style>
        html { box-sizing: border-box; overflow-y: scroll; }
        *, *:before, *:after { box-sizing: inherit; }
        body { margin: 0; background: #fafafa; }
    </style>
</head>
<body>
    <div id="swagger-ui"></div>

    <script src="{{ asset('swagger-ui-bundle.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('swagger-ui-standalone-preset.js') }}" charset="UTF-8"></script>
    <script>
        window.onload = function () {
            const ui = SwaggerUIBundle({
                url: "{{ asset('studium.json') }}",
                dom_id: '#swagger-ui',
                deepLinking: true,
                oauth2RedirectUrl: '{{ url('/') }}',
                persistAuthorization: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout"
            });
            ui.preauthorizeApiKey("show", "MyAuth", "MyApiKey1234")
            window.ui = ui;
        };
    </script>
</body>
</html>
