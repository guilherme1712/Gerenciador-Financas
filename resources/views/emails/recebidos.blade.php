<!-- resources/views/emails/recebidos.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mails Recebidos</title>
</head>
<body>

    <h2>E-mails Recebidos</h2>

    <ul>
        @foreach($mensagens as $mensagem)
            <li>
                <strong>De:</strong> {{ $mensagem->from }}
                <br>
                <strong>Assunto:</strong> {{ $mensagem->subject }}
                <br>
                <strong>Data:</strong> {{ $mensagem->date->format('Y-m-d H:i:s') }}
                <br>
                <strong>Corpo:</strong> {!! $mensagem->text !!}
            </li>
            <hr>
        @endforeach
    </ul>

</body>
</html>
