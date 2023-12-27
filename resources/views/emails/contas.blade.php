<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contas a Pagar</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                text-align: center;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }

            h2 {
                color: #3498db;
                margin-bottom: 20px;
            }

            p {
                color: #555;
                margin-bottom: 10px;
            }

            ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            li {
                border-bottom: 1px solid #ddd;
                padding: 10px 0;
                margin-bottom: 10px;
            }

            strong {
                font-weight: bold;
            }

            .footer {
                margin-top: 20px;
                color: #888;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <h2>Contas a Pagar</h2>
            <p>Olá,</p>
            <p>Segue abaixo a lista de contas a pagar que estão próximas do vencimento:</p>

            <ul>
                @forelse($contas as $conta)
                    <li>
                        <strong>Data de Vencimento:</strong> {{ date('d/m/Y', strtotime($conta->vencimento)) }}<br>
                        <strong>Conta:</strong> {{ $conta->descricao }}<br>
                        <strong>Valor:</strong> R$ {{ number_format($conta->valor, 2, ',', '.') }}
                    </li>
                @empty
                    <li>Nenhuma conta a pagar próxima do vencimento.</li>
                @endforelse
            </ul>

            <p>Fique atento aos prazos!</p>
        </div>
    </body>
</html>
