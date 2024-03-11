<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .pdf {
                position: fixed;
                left: 30px;
                bottom: 145px;
            }
        </style>
    </head>
    <body>
        <div class="pdf">
            <img src="data:image/png;base64,{{ $qrcode }}" style="border: 2px solid white;">
        </div>
    </body>
</html>
