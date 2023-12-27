@if ($emailsRecebidos->count() > 0)
    <h2 class="col-12">Últimos E-mails Recebidos</h2>

    <div class="col-12">
        <table class="table">
            <thead style="position: sticky; top: 0; opacity: 1; z-index: 3;" class="">
                <tr class="text-primary">
                    <th>De</th>
                    <th>Assunto</th>
                    <th>Corpo</th>
                    <th>Local</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emailsRecebidos as $email)
                    <tr>
                        <td>{{ $email->getFrom()[0]->mail }}</td>
                        <td>{{ $email->getSubject() }}</td>
                        <td>{{ preg_replace('/\*.*$/s', '', $email->getTextBody()) }}</td>
                        <td>{{ $email->getFolderPath() == 'INBOX' ? 'Caixa de entrada' : $email->getFolderPath() }}</td>
                        <td>
                            <a href="{{ route('financas.excluirEmail',  ['emailId' => strval($email->uid)]) }}" class="btn btn-outline-primary btn-sm" title="Excluir">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <a href="{{ route('financas.moverEmail', ['emailId' => $email->uid]) }}" class="btn btn-outline-primary btn-sm" title="Arquivar">
                                <i class="fa-solid fa-box-archive"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
