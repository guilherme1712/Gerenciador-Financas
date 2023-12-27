<?php

namespace App\Http\Controllers;

use App\Models\Financa;
use Illuminate\Http\Request;
use App\Http\Requests\ContaRequest;
use App\Http\Requests\CreditoRequest;
use App\Http\Controllers\EmailController;

class FinancasController extends Controller
{
    private $financa;
    public function __construct()
    {
        $this->financa = new Financa();
    }

    public function index()
    {
        $contas = $this->financa->searchBillings();
        $creditos = $this->financa->searchCreditos();

        $totalContas = array_sum(array_column($contas, 'valor'));
        $totalCreditos = array_sum(array_column($creditos, 'valor'));
        $totalMes = ($totalCreditos - $totalContas);

        return view('financas.index', compact('totalContas', 'totalCreditos', 'totalMes'));
    }

    public function ajaxGetContas()
    {
        $contas = $this->financa->searchBillings();
        return view('financas.partials.contas', compact('contas'));
    }

    public function ajaxGetCreditos()
    {
        $creditos = $this->financa->searchCreditos();
        return view('financas.partials.creditos', compact('creditos'));
    }

    public function ajaxGetEmailsRecebidos()
    {
        $emailController = new EmailController();
        $emailsRecebidos = $emailController->receberEmails();
        return view('financas.partials.emails', compact('emailsRecebidos'));
    }

    public function addConta()
    {
        $categoriasContas = $this->financa->getCategorias(1);
        $formatedCategorias = [];

        foreach($categoriasContas as $categoriaConta){
           $formatedCategorias[$categoriaConta->categoria_id] = $categoriaConta->nome;
        }

        $bancos = $this->financa->getBancos();
        $formatedBancos = [];

        foreach($bancos as $banco){
           $formatedBancos[$banco->id_banco] = $banco->nome;
        }

        return view('financas.conta.add-conta', compact('formatedBancos', 'formatedCategorias'));
    }

    public function saveConta(ContaRequest $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();


            if ($data['recorrente'] == 0) {
                $data['recorrente'] = 2;
            }

            // Se recorrente for 1 e data_termino_recorrente estiver definido
            if ($data['recorrente'] == 1 && isset($data['data_termino_recorrente'])) {
                $dates = [];
                $currentDate = new \DateTimeImmutable($data['data']);

                while ($currentDate <= new \DateTimeImmutable($data['data_termino_recorrente'])) {
                    $dates[] = $currentDate->format('Y-m-d');
                    $currentDate = $currentDate->modify('+1 month');
                }

                // Salve uma conta para cada data mensal
                foreach ($dates as $date) {
                    // Atualize a data_termino_recorrente para a data na primeira iteração
                    if (!isset($dataTerminoRecorrente)) {
                        $dataTerminoRecorrente = $date;
                    }

                    // Atualize a data para o mês atual
                    $data['data_termino_recorrente'] = $date;
                    // Defina o status com base na iteração
                    $data['status'] = ($date === reset($dates)) ? $data['status'] : 0;
                    // Salve a conta mensal com os campos adicionais
                    $this->financa->saveConta($data);
                }

                // Restaure a data_termino_recorrente para o valor inicial após o loop
                $data['data_termino_recorrente'] = $dataTerminoRecorrente;
            } else {
                // Se não for recorrente ou data_termino_recorrente não estiver definido, salve a conta única
                $this->financa->saveConta($data);
            }
            return redirect()->route('home');
        }
    }

    public function saveEditConta(ContaRequest $request)
    {
        if ($request->isMethod('post')) {

            $data = $request->input();
            $this->financa->saveConta($data) ;

            return redirect()->route('financas.index');
        }
    }

    public function editConta(int $id)
    {
        if (!$id) {
            return redirect()->route('financas.addConta');
        }

        try {
            $conta = $this->financa->getConta($id);
        } catch (\Exception $e) {
            return redirect()->route('financas.index');
        }

        $categoriasContas = $this->financa->getCategorias(1);
        $formatedCategorias = [];

        foreach($categoriasContas as $categoriaConta){
           $formatedCategorias[$categoriaConta->categoria_id] = $categoriaConta->nome;
        }

        $bancos = $this->financa->getBancos();
        $formatedBancos = [];

        foreach($bancos as $banco){
           $formatedBancos[$banco->id_banco] = $banco->nome;
        }

        return view('financas.conta.edit-conta', compact('conta', 'formatedBancos', 'formatedCategorias'));
    }

    public function deleteConta(int $id)
    {
        $conta = $this->financa->getConta($id);

        if (!$conta) {
            return redirect()->route('financas.index')->with('error', 'Conta não encontrada.');
        }

        return view('financas.conta.delete-conta', compact('conta'));
    }

    public function confirmDeleteConta(int $id)
    {
        $delete = $this->financa->deleteConta($id);

        return redirect()->route('financas.index');
    }

    public function addCredito()
    {
        $categoriasContas = $this->financa->getCategorias(2);
        $formatedCategorias = [];

        foreach($categoriasContas as $categoriaConta){
           $formatedCategorias[$categoriaConta->categoria_id] = $categoriaConta->nome;
        }

        $bancos = $this->financa->getBancos();
        $formatedBancos = [];

        foreach($bancos as $banco){
           $formatedBancos[$banco->id_banco] = $banco->nome;
        }

        return view('financas.credito.add-credito', compact('formatedBancos', 'formatedCategorias'));
    }

    public function saveCredito(CreditoRequest $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            // Se recorrente for 1 e data_termino_recorrente estiver definido
            if ($data['recorrente'] == 1 && isset($data['data_termino_recorrente'])) {
                $dates = [];
                $currentDate = new \DateTimeImmutable($data['data']);

                while ($currentDate <= new \DateTimeImmutable($data['data_termino_recorrente'])) {
                    $dates[] = $currentDate->format('Y-m-d');
                    $currentDate = $currentDate->modify('+1 month');
                }

                // Salve uma conta para cada data mensal
                foreach ($dates as $date) {
                    // Atualize a data_termino_recorrente para a data na primeira iteração
                    if (!isset($dataTerminoRecorrente)) {
                        $dataTerminoRecorrente = $date;
                    }

                    // Atualize a data para o mês atual
                    $data['data_termino_recorrente'] = $date;
                    // Defina o status com base na iteração
                    $data['status'] = ($date === reset($dates)) ? $data['status'] : 0;
                    // Salve a conta mensal com os campos adicionais
                    $this->financa->saveCredito($data);
                }

                // Restaure a data_termino_recorrente para o valor inicial após o loop
                $data['data_termino_recorrente'] = $dataTerminoRecorrente;
            } else {
                // Se não for recorrente ou data_termino_recorrente não estiver definido, salve a conta única
                $this->financa->saveCredito($data);
            }

            return redirect()->route('home');
        }
    }

    public function saveEditCredito(CreditoRequest $request)
    {
        if ($request->isMethod('post')) {

            $data = $request->input();
            $this->financa->saveCredito($data);

            return redirect()->route('financas.index');
        }
    }

    public function editCredito(int $id)
    {
        if (!$id) {
            return redirect()->route('financas.addCredito');
        }

        try {
            $credito = $this->financa->getCredito($id);
        } catch (\Exception $e) {
            return redirect()->route('financas.index');
        }

        $categoriasContas = $this->financa->getCategorias(2);
        $formatedCategorias = [];

        foreach($categoriasContas as $categoriaConta){
           $formatedCategorias[$categoriaConta->categoria_id] = $categoriaConta->nome;
        }

        $bancos = $this->financa->getBancos();
        $formatedBancos = [];

        foreach($bancos as $banco){
           $formatedBancos[$banco->id_banco] = $banco->nome;
        }

        return view('financas.credito.edit-credito', compact('credito', 'formatedBancos', 'formatedCategorias'));
    }

    public function deleteCredito(int $id)
    {
        $credito = $this->financa->getCredito($id);

        if (!$credito) {
            return redirect()->route('financas.index')->with('error', 'Crédito não encontrada.');
        }

        return view('financas.credito.delete-credito', compact('credito'));
    }

    public function confirmDeleteCredito(int $id)
    {
        $delete = $this->financa->deleteCredito($id);

        return redirect()->route('financas.index');
    }

    public function buscaListadoContas()
    {
        $categoriasContas = $this->financa->getCategorias(1);
        $formatedCategorias = [];

        foreach($categoriasContas as $categoriaConta){
           $formatedCategorias[$categoriaConta->categoria_id] = $categoriaConta->nome;
        }

        $bancos = $this->financa->getBancos();
        $formatedBancos = [];

        foreach($bancos as $banco){
           $formatedBancos[$banco->id_banco] = $banco->nome;
        }

        return view('financas.listados.busca-listado-contas', [
            'formatedCategorias' => $formatedCategorias,
            'formatedBancos' => $formatedBancos,
        ]);
    }

    public function listadoContas(Request $request)
    {
        $listadoContas = [];
        $totalContas = 0;

        if ($request->isMethod('post')) {
            $formData = [
                "dataDesde" => $request->input("dataDesde"),
                "dataFim" => $request->input("dataFim"),
                "valor" => $request->input("valor"),
                "recorrente" => $request->input("recorrente"),
                "status" => $request->input("status"),
                "banco" => $request->input("banco"),
                "categoria" => $request->input("categoria"),
            ];

            $listadoContas = $this->financa->getListadoContas($formData);
            $totalContas = array_sum(array_column($listadoContas, 'valor'));
        }

        return view('financas.listados.listado-contas', [
            'listadoContas' => $listadoContas,
            'totalContas' => $totalContas,
        ]);
    }

    public function buscaListadoCreditos()
    {
        $categoriasContas = $this->financa->getCategorias(2);
        $formatedCategorias = [];

        foreach($categoriasContas as $categoriaConta){
           $formatedCategorias[$categoriaConta->categoria_id] = $categoriaConta->nome;
        }

        $bancos = $this->financa->getBancos();
        $formatedBancos = [];

        foreach($bancos as $banco){
           $formatedBancos[$banco->id_banco] = $banco->nome;
        }

        return view('financas.listados.busca-listado-creditos', [
            'formatedCategorias' => $formatedCategorias,
            'formatedBancos' => $formatedBancos,
        ]);
    }

    public function listadoCreditos(Request $request)
    {
        $listadoCreditos = [];
        $totalCreditos = 0;

        if ($request->isMethod('post')) {
            $formData = [
                "dataDesde" => $request->input("dataDesde"),
                "dataFim" => $request->input("dataFim"),
                "valor" => $request->input("valor"),
                "recorrente" => $request->input("recorrente"),
                "status" => $request->input("status"),
                "banco" => $request->input("banco"),
                "categoria" => $request->input("categoria"),
            ];

            $listadoCreditos = $this->financa->getListadoCreditos($formData);
            $totalCreditos = array_sum(array_column($listadoCreditos, 'valor'));
        }

        return view('financas.listados.listado-creditos', [
            'listadoCreditos' => $listadoCreditos,
            'totalCreditos' => $totalCreditos,
        ]);
    }

    public function getCreditoInfo(Request $request)
    {
        $creditoId = $request->input('creditoId');
        $creditoData = $this->financa->searchCreditos($creditoId, true);

        if (!$creditoData) {
            return response()->json(['error' => 'credito não encontrada'], 404);
        }

        $response = ['creditoData' => $creditoData];

        return response()->json($response);
    }

    public function getContaInfo(Request $request)
    {
        $contaId = $request->input('contaId');
        $contaData = $this->financa->searchBillings($contaId, true);

        if (!$contaData) {
            return response()->json(['error' => 'Conta não encontrada'], 404);
        }

        $response = ['contaData' => $contaData];

        return response()->json($response);
    }

    public function contaInfo()
    {
        $contasData = $this->financa->searchContasCreditosData('contas');

        return view('financas.conta.tabela-contas', [
            'contasData' => $contasData,
        ]);
    }

    public function creditoInfo()
    {
        $creditoData = $this->financa->searchContasCreditosData('creditos');

        return view('financas.credito.tabela-creditos', [
            'creditosData' => $creditoData,
        ]);
    }

    public function getContasCreditosCount(Request $request)
    {
        $tipoConta = $request->input('tipoConta');

        if ($request->isMethod('post')) {
            $data = $this->financa->countContasCreditos($tipoConta);
            if ($tipoConta === 'contas') {
                return response()->json(['contasCount' => $data]);
            } elseif ($tipoConta === 'creditos') {
                return response()->json(['creditosCount' => $data]);
            } else {
                return response()->json(['error' => 'Tipo de conta inválido'], 404);
            }
        } else {
            return response()->json(['error' => 'Request não é do tipo post'], 404);
        }
    }

    public function verificarRegistrosEmailContas()
    {
        $dataVencimento = date('Y-m-d', strtotime('+1 day'));
        $registros = $this->financa->obterContasPorVencimentoEStatus($dataVencimento);
        dump($registros, $dataVencimento);

        if ($registros->count() > 0) {
            $emailController = new EmailController();
            $resultadoEnvioEmail = $emailController->enviarEmailContas();

            if (strpos($resultadoEnvioEmail, 'enviado com sucesso') !== false) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
