<!-- Modal -->
<div class="modal fade" id="contaModal" tabindex="-1" role="dialog" aria-labelledby="contaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contaModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <strong>Nome: </strong>
                    <span id="modalDescricao"> </span>
                </p>
                <p>
                    <strong>Data: </strong>
                    <span id="modalData"> </span>
                </p>
                <p>
                    <strong>Valor: </strong>
                    <span id="modalValor"> </span
                    ></p>
                <p>
                    <strong>Recorrente: </strong>
                    <span id="modalRecorrente"> </span>
                </p>
                <p>
                    <strong>Data Término Recorrente: </strong>
                    <span id="modalDataTerminoRecorrente"> </span>
                </p>
                <p>
                    <strong>Status: </strong>
                    <span id="modalStatus"> </span>
                </p>
                <p>
                    <strong>Banco: </strong>
                    <span id="modalBanco"> </span>
                </p>
                <p>
                    <strong>Categoria: </strong>
                    <span id="modalCategoria"> </span>
                </p>

                <input type="hidden" id="contaIdModal" class="contaIdModal">
            </div>
        </div>
    </div>
</div>
