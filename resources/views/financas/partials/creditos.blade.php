<table class="table">
    <thead style="position: sticky; top: 0; opacity: 1; z-index: 3;">
        <tr class="text-primary">
            <th>Data</th>
            <th>Crédito</th>
            <th>Valor</th>
            <th>Recorrente</th>
            <th>Termino Recorrente</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($creditos as $credito)
            <tr>
                <td>{{ $credito->recorrente == 1 ? date('d/m/Y', strtotime($credito->data_termino_recorrente )) : date('d/m/Y', strtotime($credito->data )) }}</td>
                <td>{{ $credito->descricao }}</td>
                <td>R$ {{ number_format($credito->valor, 2, ',', '.') }}</td>
                <td>{{ $credito->recorrente == 1 ? 'Sim' : 'Não' }}</td>
                <td>{{ date('d/m/Y', strtotime($credito->data_termino_recorrente )) }}</td>
                <td>{{ $credito->status == 1 ? 'Creditado' : 'Não Creditado' }}</td>
                <td>
                    <a href="{{ route('financas.editCredito', ['id' => $credito->id]) }}" class="btn-outline-primary">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <a href="{{ route('financas.deleteCredito', ['id' => $credito->id]) }}" class="btn-outline-primary">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                    <a class="js-conta-detalhes-credito" data-id="{{ $credito->id }}" class="btn-outline-primary">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>
                </td>
                <input type="hidden" class="creditoId" id="creditoId" value="{{ $credito->id }}">
            </tr>
        @endforeach
    </tbody>
</table>