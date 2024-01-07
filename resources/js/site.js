const $ = require('jquery');
require('./datatables-config');
window.jQuery = $;

$(document).ready(function() {

    modalDetalhesConta();
    modalDetalhesCredito();
    startDataTable();
    countIndex('contas');
    countIndex('creditos');
    selectDataRecorrente();
    getTablesIndexFinancas();
});

function getTablesIndexFinancas() {
    // Contas
    $.ajax({
        url: "/APIs/Laravel/Gerenciador-Financas/public/financas/ajaxGetContas",
        success: function (data) {
            $('.contas-table').html(data);
        }
    });

    // Créditos
    $.ajax({
        url: "/APIs/Laravel/Gerenciador-Financas/public/financas/ajaxGetCreditos",
        success: function (data) {
            $('.creditos-table').html(data);
        }
    });

    // E-mails
    $.ajax({
        url: "/APIs/Laravel/Gerenciador-Financas/public/financas/ajaxGetEmailsRecebidos",
        success: function (data) {
            $('.emails-table').html(data);
        }
    });
}

function selectDataRecorrente() {
    $('#recorrente').on('change', function () {
        if ($(this).val() === '1') {
            $('#data_termino_recorrente_container').show();
        } else {
            $('#data_termino_recorrente_container').hide();
        }
    });
}

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

                $("#idHidden").text(response.contaData[0].id);
                $("#modalStatus").text(response.contaData[0].status == 1 ? 'Pago' : 'Não Pago');
                $("#modalBanco").text(response.contaData[0].nome);
                $("#modalCategoria").text(response.contaData[0].nomeCategoria);
                $("#modalDescricao").text(response.contaData[0].descricao);
                $("#modalRecorrente").text(response.contaData[0].recorrente == 1 ? 'Sim' : 'Não');

                let dataTerminoRecorrenteFormatada = formatarData(response.contaData[0].data_termino_recorrente);
                if (response.contaData[0].recorrente == 1) {
                    $("#modalDataTerminoRecorrente").text(dataTerminoRecorrenteFormatada);
                    $(".dataTerminoRecorrente-field").show();
                } else {
                    $(".dataTerminoRecorrente-field").hide();
                }

                let dataFormatada = formatarData(response.contaData[0].data);
                $("#modalData").text(dataFormatada);

                let valorFormatado = parseFloat(response.contaData[0].valor).toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                $("#modalValor").text(valorFormatado);
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

                $("#idHidden").text(response.creditoData[0].id);
                $("#modalDescricao").text(response.creditoData[0].descricao);
                $("#modalRecorrente").text(response.creditoData[0].recorrente == 1 ? 'Sim' : 'Não');
                $("#modalStatus").text(response.creditoData[0].status == 1 ? 'Creditado' : 'Não Creditado');
                $("#modalBanco").text(response.creditoData[0].nome);
                $("#modalCategoria").text(response.creditoData[0].nomeCategoria);

                let dataTerminoRecorrenteFormatada = formatarData(response.creditoData[0].data_termino_recorrente);
                if (response.creditoData[0].recorrente == 1) {
                    $("#modalDataTerminoRecorrente").text(dataTerminoRecorrenteFormatada);
                    $(".dataTerminoRecorrente-field").show();
                } else {
                    $(".dataTerminoRecorrente-field").hide();
                }

                let dataFormatada = formatarData(response.creditoData[0].data);
                $("#modalData").text(dataFormatada);

                let valorFormatado = parseFloat(response.creditoData[0].valor).toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                $("#modalValor").text(valorFormatado);
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
