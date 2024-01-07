<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Conta; // Certifique-se de importar o modelo Conta

class Contas extends Mailable
{
    use Queueable, SerializesModels;

    public $contas;

    /**
     * Create a new message instance.
     *
     * @param $contas
     * @return void
     */
    public function __construct($contas)
    {
        $this->contas = $contas;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $filePath = '/mnt/d/area de trabalho/CONTA_CORRENE.xlsx';
        $fileName = 'CONTA_CORRENE.xlsx';
        $subjectSuffix = count($this->contas) === 1 ? '1 conta' : count($this->contas) . ' contas';

        $email = $this->view('emails.contas')
            ->subject('Contas a Pagar - ' . $subjectSuffix)
            ->from('testesmtp17@gmail.com', 'Laravel - ContaCorrente');

        if (file_exists($filePath)) {
            $email->attach($filePath, [
                'as' => $fileName,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }
        return $email;
    }
}
