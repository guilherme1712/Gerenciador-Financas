<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informe Diário</title>
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
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            <h2>Informes Diários</h2>
            <p>Olá,</p>
            <p>Aqui estão os informes diários sobre contas a pagar e créditos:</p>

            <h3>Contas:</h3>
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

            <h3>Créditos:</h3>
            <ul>
                @forelse($creditos as $credito)
                    <li>
                        <strong>Data:</strong> {{ date('d/m/Y', strtotime($credito->data)) }}<br>
                        <strong>Descrição:</strong> {{ $credito->descricao }}<br>
                        <strong>Valor:</strong> R$ {{ number_format($credito->valor, 2, ',', '.') }}
                    </li>
                @empty
                    <li>Nenhum crédito registrado.</li>
                @endforelse
            </ul>
        </div>
    </body>
</html>
