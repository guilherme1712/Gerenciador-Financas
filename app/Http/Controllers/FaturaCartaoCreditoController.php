<?php

// Em app/Http/Controllers/FaturaCartaoCreditoController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FaturaCartaoCredito;

class FaturaCartaoCreditoController extends Controller
{
    private $faturaCartaoCredito;
    public function __construct(FaturaCartaoCredito $faturaCartaoCredito)
    {
        $this->faturaCartaoCredito = $faturaCartaoCredito;
    }
    public function index()
    {
        $faturas = $this->faturaCartaoCredito->getAllFaturas();
        return view('faturas.index', compact('faturas'));
    }

    public function editarFatura($id)
    {
        $fatura = $this->faturaCartaoCredito->obterInformacoesFatura($id);

        return view('faturas.edit', compact('fatura'));
    }

    public function salvarFatura(Request $request, $id)
    {
        // Adicione aqui as validações necessárias
        $this->validate($request, [
            'valor' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $this->faturaCartaoCredito->atualizarFatura($id, $request->input('valor'), $request->input('status'));

        return redirect()->route('faturas.index')->with('success', 'Fatura atualizada com sucesso.');
    }

    public function confirmarDelecao($id)
    {
        $fatura = $this->faturaCartaoCredito->obterInformacoesFatura($id);

        return view('faturas.confirmDelete', compact('fatura'));
    }

    public function deletarFatura(Request $request, $id)
    {
        if ($request->input('del') == 1) {
            $this->faturaCartaoCredito->excluirFatura($id);
            return redirect()->route('faturas.index')->with('success', 'Fatura excluída com sucesso.');
        } else {
            return redirect()->route('faturas.index');
        }
    }

    public function criarManualmente()
    {
        return view('faturas.criarManualmente');
    }

    public function salvarManualmente(Request $request)
    {
        $this->validate($request, [
            'valor' => 'required|decimal',
            'diaVencimento' => 'required|numeric|min:1|max:31',
            'mesReferencia' => 'required|date_format:Y-m',
            'status' => 'required|in:0,1',
        ]);

        $valor = $request->input('valor');
        $diaVencimento = $request->input('diaVencimento');
        $mesReferencia = $request->input('mesReferencia');
        $status = $request->input('status');

        $this->faturaCartaoCredito->salvarManualmente($valor, $diaVencimento, $mesReferencia, $status);

        return redirect()->route('faturas.index')->with('success', 'Fatura manual criada com sucesso!');
    }
}
