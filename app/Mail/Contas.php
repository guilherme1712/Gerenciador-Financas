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

    public $contas;  // Adicione esta propriedade para armazenar as contas

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
        $subjectSuffix = count($this->contas) === 1 ? '1 conta' : count($this->contas) . ' contas';

        return $this->view('emails.contas')
            ->subject('Contas a Pagar - ' . $subjectSuffix)
            ->from('testesmtp17@gmail.com', 'Laravel - ContaCrrente');
    }
}
