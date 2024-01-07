<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InformeDiario extends Mailable
{
    use Queueable, SerializesModels;

    public $contas;
    public $creditos;

    /**
     * Create a new message instance.
     *
     * @param array|string|null $contas
     * @param array|string|null $creditos
     * @return void
     */
    public function __construct($contas, $creditos)
    {
        $this->contas = $contas;
        $this->creditos = $creditos;
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

        $email = $this->view('emails.informeDiario')
            ->with(['contas' => $this->contas, 'creditos' => $this->creditos])
            ->subject('Informe Diario ContaCorrente')
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
