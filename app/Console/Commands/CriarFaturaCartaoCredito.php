<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FaturaCartaoCredito;

class CriarFaturaCartaoCredito extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fatura:criar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria uma nova fatura de cartão de crédito';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Cria uma nova instância da classe FaturaCartaoCredito
        $faturaCartaoCredito = new FaturaCartaoCredito();

        // Chama o método criarFatura
        $faturaCartaoCredito->criarFatura();

        // Exibe uma mensagem de sucesso
        $this->info('Fatura de cartão de crédito criada com sucesso.');
    }
}
