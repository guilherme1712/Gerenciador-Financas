<?php

use App\Models\FaturaCartaoCredito;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExpotarController;
use App\Http\Controllers\FinancasController;
use App\Http\Controllers\FaturaCartaoCreditoController;

Route::get("/", function () {
    return view('menu.index');
})->name('home');

Route::get('/menu', function () {
    return view('menu.index');
})->name('menu');

Route::prefix('/financas')->group(function () {
    Route::get('/', [FinancasController::class, 'index'])->name('financas.index');

    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');

    Route::match(['get', 'post'], '/addConta', [FinancasController::class, 'addConta'])->name('financas.addConta');
    Route::match(['get', 'post'], '/editConta/{id}', [FinancasController::class, 'editConta'])->name('financas.editConta');
    Route::match(['get', 'post'],'/deleteConta/{id}', [FinancasController::class, 'deleteConta'])->name('financas.deleteConta');
    Route::post('/confirmDeleteConta/{id}', [FinancasController::class, 'confirmDeleteConta'])->name('financas.confirmDeleteConta');
    Route::match(['get', 'post'], '/saveConta', [FinancasController::class, 'saveConta'])->name('financas.saveConta');
    Route::match(['get', 'post'], '/saveEditConta', [FinancasController::class, 'saveEditConta'])->name('financas.saveEditConta');
    Route::match(['get', 'post'], '/getContaInfo', [FinancasController::class, 'getContaInfo'])->name('financas.getContaInfo');
    Route::match(['get', 'post'], '/contaInfo', [FinancasController::class, 'contaInfo'])->name('financas.contaInfo');

    Route::match(['get', 'post'], '/addCredito', [FinancasController::class, 'addCredito'])->name('financas.addCredito');
    Route::match(['get', 'post'], '/editCredito/{id}', [FinancasController::class, 'editCredito'])->name('financas.editCredito');
    Route::match(['get', 'post'],'/deleteCredito/{id}', [FinancasController::class, 'deleteCredito'])->name('financas.deleteCredito');
    Route::post('/confirmDeleteCredito/{id}', [FinancasController::class, 'confirmDeleteCredito'])->name('financas.confirmDeleteCredito');
    Route::match(['get', 'post'], '/saveCredito', [FinancasController::class, 'saveCredito'])->name('financas.saveCredito');
    Route::match(['get', 'post'], '/saveEditCredito', [FinancasController::class, 'saveEditCredito'])->name('financas.saveEditCredito');
    Route::match(['get', 'post'], '/getCreditoInfo', [FinancasController::class, 'getCreditoInfo'])->name('financas.getCreditoInfo');
    Route::match(['get', 'post'], '/creditoInfo', [FinancasController::class, 'creditoInfo'])->name('financas.creditoInfo');

    Route::match(['get', 'post'], '/buscaListadoContas', [FinancasController::class, 'buscaListadoContas'])->name('financas.buscaListadoContas');
    Route::match(['get', 'post'], '/listadoContas', [FinancasController::class, 'listadoContas'])->name('financas.listadoContas');
    Route::match(['get', 'post'], '/buscaListadoCreditos', [FinancasController::class, 'buscaListadoCreditos'])->name('financas.buscaListadoCreditos');
    Route::match(['get', 'post'], '/listadoCreditos', [FinancasController::class, 'listadoCreditos'])->name('financas.listadoCreditos');

    Route::match(['get', 'post'], '/contasCreditosCount', [FinancasController::class, 'getContasCreditosCount'])->name('financas.contasCreditosCount');

    Route::get('/ajaxGetContas', [FinancasController::class, 'ajaxGetContas'])->name('financas.getContas');
    Route::get('/ajaxGetCreditos', [FinancasController::class, 'ajaxGetCreditos'])->name('financas.getCreditos');
    Route::get('/ajaxGetEmailsRecebidos', [FinancasController::class, 'ajaxGetEmailsRecebidos'])->name('financas.getEmailsRecebidos');

    Route::get('/faturas', [FaturaCartaoCreditoController::class, 'index'])->name('faturas.index');
    Route::get('/fatura/editar/{id}', [FaturaCartaoCreditoController::class, 'editarFatura'])->name('fatura.editar');
    Route::post('/fatura/salvar/{id}', [FaturaCartaoCreditoController::class, 'salvarFatura'])->name('fatura.salvar');
    Route::get('/fatura/deletar/{id}', [FaturaCartaoCreditoController::class, 'confirmarDelecao'])->name('fatura.confirmDelete');
    Route::post('/fatura/deletar/{id}', [FaturaCartaoCreditoController::class, 'deletarFatura'])->name('fatura.deletar');
    Route::get('/fatura/criar-manualmente', [FaturaCartaoCreditoController::class, 'criarManualmente'])->name('fatura.criar-manualmente');
    Route::post('/fatura/salvar-manualmente', [FaturaCartaoCreditoController::class, 'salvarManualmente'])->name('fatura.salvar-manualmente');

    Route::get('/admin/categorias/index', [AdminController::class, 'index'])->name('admin.categorias.index');
    Route::get('/admin/categorias/add', [AdminController::class, 'addCategoria'])->name('admin.categorias.add');
    Route::post('/admin/categorias/save', [AdminController::class, 'saveCategoria'])->name('admin.categorias.save');
    Route::get('/admin/categorias/edit/{id}', [AdminController::class, 'editCategoria'])->name('admin.categorias.edit');
    Route::put('/admin/categorias/update/{id}', [AdminController::class, 'updateCategoria'])->name('admin.categorias.update');
    Route::get('/admin/categorias/delete/{id}', [AdminController::class, 'confirmDeleteCategoria'])->name('admin.categorias.confirmDelete');
    Route::delete('/admin/categorias/destroy/{id}', [AdminController::class, 'destroyCategoria'])->name('admin.categorias.destroy');

    Route::prefix('/emails')->group(function () {
        Route::get('/enviar-email-contas', [EmailController::class, 'enviarEmailContas'])->name('enviarEmailContas');
        Route::get('/receber-emails', [EmailController::class, 'receberEmails'])->name('receberEmails');
        Route::match(['get', 'post'],'/excluir-email', [EmailController::class, 'excluirEmail'])->name('financas.excluirEmail');
        Route::match(['get', 'post'],'/mover-email', [EmailController::class, 'moverEmail'])->name('financas.moverEmail');
        Route::match(['get', 'post'],'/marcar-como-lido', [EmailController::class, 'marcarComoLido'])->name('financas.marcarComoLido');
    });

    Route::prefix('/testes')->group(function () {
        Route::get('/testar-criar-fatura', function () {
            FaturaCartaoCredito::criarFatura();
            return 'Função criarFatura executada com sucesso.';
        })->name('testarCriarFatura');
        Route::get('/testar-envio-email',[FinancasController::class, 'verificarRegistrosEmailContas'])
            ->name('verificarRegistrosEmailContas');
    });

    Route::get('/export-excel', [ExportController::class, 'exportToExcel'])->name('exportToExcel');

});

