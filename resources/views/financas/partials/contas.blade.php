<table class="table">
    <thead style="position: sticky; top: 0; opacity: 1; z-index: 3;" class="thead-primary">
        <tr class="text-primary bg-primary">
            <th>Data</th>
            <th>Conta</th>
            <th>Valor</th>
            <th>Recorrente</th>
            <th>Termino Recorrente</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contas as $conta)
            <tr>
                <td>{{ date('d/m/Y', strtotime($conta->vencimento )) }}</td>
                <td>
                    <a>{{ $conta->descricao }}</a >
                </td>
                <td class="col-md-auto">R$ {{ number_format($conta->valor, 2, ',', '.') }}</td>
                <td>{{ $conta->recorrente == 1 ? 'Sim' : 'Não' }}</td>
                <td>{{ date('d/m/Y', strtotime($conta->data_termino_recorrente )) }}</td>
                <td>{{ $conta->status == 1 ? 'Pago' : 'Não Pago' }}</td>
                <td>
                    <a href="{{ route('financas.editConta', ['id' => $conta->id]) }}" class="btn-outline-primary">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <a href="{{ route('financas.deleteConta', ['id' => $conta->id]) }}" class="btn-outline-primary">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                    <a class="js-conta-detalhes-conta" data-id="{{ $conta->id }}" class="btn-outline-primary">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>
                </td>

                <input type="hidden" class="contaId" id="contaId" value="{{ $conta->id }}">
            </tr>
        @endforeach
    </tbody>
</table>