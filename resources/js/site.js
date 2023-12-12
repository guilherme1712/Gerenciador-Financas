const $ = require('jquery');
require('./datatables-config');
window.jQuery = $;

$(document).ready(function() {

    modalDetalhesConta();
    modalDetalhesCredito();
    startDataTable();
    countIndex('contas');
    countIndex('creditos');

});

function countIndex(tipoConta) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajax({
        url: '/APIs/Laravel/Gerenciador-Financas/public/financas/contasCreditosCount',
        type: 'post',
        data: {
            tipoConta: tipoConta,
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        success: function(response) {
            if (response.hasOwnProperty('contasCount')) {
                $('.js-count-contas').text(response.contasCount);
            } else if (response.hasOwnProperty('creditosCount')) {
                $('.js-count-creditos').text(response.creditosCount);
            }
        },
        error: function(error) {
            console.error('Erro na requisição AJAX:', error);
        },
    });
}

function startDataTable() {
    let dataTable = $('#tabelaListadoConta, #tabelaListadoCredito, #tabelaContas, #tabelaCreditos').DataTable({
        dom: 'Blfrtip',
        order: [1, "asc"],
        paging: false,
        // searching: false,
        lengthChange: false,
        info: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-outline-primary py-1 px-2 m-0 js-dataTable-exel" type="button">'+
                            '<i class="fa-regular fa-file-excel"></i>'+
                       '</button>',
                title: $('js-name-page').html(),
            },
            {
                extend: 'print',
                text: '<button class="btn btn-outline-primary py-1 px-2 m-0 js-dataTable-print" type="button">'+
                            '<i class="fa fa-print" aria-hidden="true"></i>'+
                       '</button>',
                title: $('js-name-page').html(),
            },
        ],
        drawCallback: function () {
            $('.dt-button').css({
                'margin': '0',
                'padding': '0',
                'background': 'none',
                'border': 'none',
            });
        }
    }).draw();
}

function modalDetalhesConta() {
    $(document).on('click', '.js-conta-detalhes-conta', function() {
        let contaId = $(this).data('id');
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/APIs/Laravel/Gerenciador-Financas/public/financas/getContaInfo',
            type: 'POST',
            data: {
                contaId: contaId,
                _token: csrfToken,
            },
            success: function(response) {

                $('.modal-title').html('Detalhes da Conta');

                $("#contaIdModal").text(response.contaData[0].id);
                let data = response.contaData[0].data;
                let dataFormatada = formatarData(data);
                $("#modalData").text(dataFormatada);
                $("#modalDescricao").text(response.contaData[0].descricao);
                $("#modalValor").text(response.contaData[0].valor);
                $("#modalRecorrente").text(response.contaData[0].recorrente == 1 ? 'Sim' : 'Não');
                let dataTerminoRecorrente = response.contaData[0].data_termino_recorrente;
                let dataTerminoRecorrenteFormatada = formatarData(dataTerminoRecorrente);
                $("#modalDataTerminoRecorrente").text(dataTerminoRecorrenteFormatada);
                $("#modalStatus").text(response.contaData[0].status == 1 ? 'Pago' : 'Não Pago');
                $("#modalBanco").text(response.contaData[0].nome);
                $("#modalCategoria").text(response.contaData[0].nomeCategoria);

                $("#contaModal").modal('show');
            },
            error: function(error) {
                console.error('Erro na requisição AJAX:', error);
            }
        });
    });
}

function modalDetalhesCredito() {
    $(document).on('click', '.js-conta-detalhes-credito', function() {
        let creditoId = $(this).data('id');
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/APIs/Laravel/Gerenciador-Financas/public/financas/getCreditoInfo',
            type: 'POST',
            data: {
                creditoId: creditoId,
                _token: csrfToken,
            },
            success: function(response) {

                $('.modal-title').html('Detalhes do Crédito');

                $("#contaIdModal").text(response.creditoData[0].id);
                let data = response.creditoData[0].data;
                let dataFormatada = formatarData(data);
                $("#modalData").text(dataFormatada);
                $("#modalDescricao").text(response.creditoData[0].descricao);
                $("#modalValor").text(response.creditoData[0].valor);
                $("#modalRecorrente").text(response.creditoData[0].recorrente == 1 ? 'Sim' : 'Não');
                let dataTerminoRecorrente = response.creditoData[0].data_termino_recorrente;
                let dataTerminoRecorrenteFormatada = formatarData(dataTerminoRecorrente);
                $("#modalDataTerminoRecorrente").text(dataTerminoRecorrenteFormatada);
                $("#modalStatus").text(response.creditoData[0].status == 1 ? 'Creditado' : 'Não Creditado');
                $("#modalBanco").text(response.creditoData[0].nome);
                $("#modalCategoria").text(response.creditoData[0].nomeCategoria);

                $("#contaModal").modal('show');
            },
            error: function(error) {
                console.error('Erro na requisição AJAX:', error);
            }
        });
    });
}

function formatarData(data) {
    let partes = data.split('-');
    return partes[2] + '/' + partes[1] + '/' + partes[0];
}
