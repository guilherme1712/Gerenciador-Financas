<?php
// app/Http/Controllers/EmailController.php

namespace App\Http\Controllers;

use App\Mail\Contas;
use App\Models\Financa;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailController
{
    public function enviarEmailContas()
    {
        $financaModel = new Financa();
        $dataVencimento = date('Y-m-d', strtotime('+1 day'));
        $contas = $financaModel->obterContasPorVencimentoEStatus($dataVencimento);

        $contasMailable = new Contas($contas);

        $to = 'gdaudt17@gmail.com';
        $subject = $contasMailable->subject;
        $body = $contasMailable->render();

        try {
            Mail::to($to)->send($contasMailable);
            return "E-mail de Contas enviado com sucesso!";
        } catch (\Exception $e) {
            return "Falha ao enviar o e-mail de Contas. Detalhes: " . $e->getMessage();
        }
    }

    public function receberEmails()
    {
        $oClient = Client::account('default');
        $oClient->connect();
        $pastas = $oClient->getFolders();
        $mensagens = collect();

        foreach ($pastas as $pasta) {
            $mensagens = $mensagens->merge($pasta->messages()->all()->get());
        }
        $oClient->disconnect();
        return $mensagens;
    }

    public function excluirEmail(Request $request)
    {
        $emailId = $request->input('emailId');

        if($request->isMethod('post')) {

        }
        try {
            $oClient = Client::account('default');
            $oClient->connect();

            $pastas = $oClient->getFolders();

            $oMessage = null;

            foreach ($pastas as $pasta) {
                $mensagem = $pasta->search()->where('uid', $emailId)->get()->first();
                if ($mensagem) {
                    $oMessage = $mensagem;
                    break;
                }
            }

            if ($oMessage) {
                $oMessage->delete(true);
                $oClient->disconnect();
                return redirect()->route('financas.index');
            } else {
                $oClient->disconnect();
                Log::info("email UID" . $emailId . "não encontrado");
                return redirect()->route('financas.index');
            }
        } catch (\Exception $e) {
            Log::info("email UID" . $emailId . "Detalhes: " . $e->getMessage());
            return redirect()->route('financas.index');
        }
    }

    public function moverEmail(Request $request)
    {
        $emailId = $request->input('emailId');

        try {
            $oClient = Client::account('default');
            $oClient->connect();

            $inbox = $oClient->getFolder('INBOX');
            $arquivadosFolder = $oClient->getFolder('Arquivados');

            if (!$arquivadosFolder) {
                $oClient->disconnect();
                return response()->json(['message' => 'Pasta "arquivados" não encontrada'], 404);
            }
            $messages = $inbox->messages()->all()->get();
            $oMessage = $messages->first(function ($message) use ($emailId) {
                return $message->uid == $emailId;
            });

            if ($oMessage) {
                $oMessage->move($arquivadosFolder->name);
                $oClient->disconnect();
                return redirect()->route('financas.index');
            } else {
                $oClient->disconnect();
                Log::info("email UID" . $emailId . "não encontrado");
                return redirect()->route('financas.index');
            }
        } catch (\Exception $e) {
            Log::info("email UID" . $emailId . "Detalhes: " . $e->getMessage());
            return redirect()->route('financas.index');
        }
    }
}
