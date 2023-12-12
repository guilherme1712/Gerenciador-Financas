<?php

use App\Http\Controllers\AdminController;
use App\Models\FaturaCartaoCredito;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\FinancasController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CartaoCreditoController;
use App\Http\Controllers\FaturaCartaoCreditoController;

// Route::get('/', function () {
//     return view('welcome');
// });

//ROTA ADMIN
Route::get('/financas/admin', function () {
    return view('admin.index');
})->name('admin.index');

Route::get("/", function () {
    return view('menu.index');
})->name('home');
Route::get('/menu', function () {
    return view('menu.index');
})->name('menu');


Route::get('/financas', [FinancasController::class, 'index'])->name('financas.index');

Route::match(['get', 'post'], '/financas/addConta', [FinancasController::class, 'addConta'])->name('financas.addConta');
Route::match(['get', 'post'], '/financas/editConta/{id}', [FinancasController::class, 'editConta'])->name('financas.editConta');
Route::match(['get', 'post'],'/financas/deleteConta/{id}', [FinancasController::class, 'deleteConta'])->name('financas.deleteConta');
Route::post('/financas/confirmDeleteConta/{id}', [FinancasController::class, 'confirmDeleteConta'])->name('financas.confirmDeleteConta');
Route::match(['get', 'post'], '/financas/saveConta', [FinancasController::class, 'saveConta'])->name('financas.saveConta');
Route::match(['get', 'post'], '/financas/saveEditConta', [FinancasController::class, 'saveEditConta'])->name('financas.saveEditConta');
Route::match(['get', 'post'], '/financas/getContaInfo', [FinancasController::class, 'getContaInfo'])->name('financas.getContaInfo');
Route::match(['get', 'post'], '/financas/contaInfo', [FinancasController::class, 'contaInfo'])->name('financas.contaInfo');

Route::match(['get', 'post'], '/financas/addCredito', [FinancasController::class, 'addCredito'])->name('financas.addCredito');
Route::match(['get', 'post'], '/financas/editCredito/{id}', [FinancasController::class, 'editCredito'])->name('financas.editCredito');
Route::match(['get', 'post'],'/financas/deleteCredito/{id}', [FinancasController::class, 'deleteCredito'])->name('financas.deleteCredito');
Route::post('/financas/confirmDeleteCredito/{id}', [FinancasController::class, 'confirmDeleteCredito'])->name('financas.confirmDeleteCredito');
Route::match(['get', 'post'], '/financas/saveCredito', [FinancasController::class, 'saveCredito'])->name('financas.saveCredito');
Route::match(['get', 'post'], '/financas/saveEditCredito', [FinancasController::class, 'saveEditCredito'])->name('financas.saveEditCredito');
Route::match(['get', 'post'], '/financas/getCreditoInfo', [FinancasController::class, 'getCreditoInfo'])->name('financas.getCreditoInfo');
Route::match(['get', 'post'], '/financas/creditoInfo', [FinancasController::class, 'creditoInfo'])->name('financas.creditoInfo');

Route::match(['get', 'post'], '/financas/buscaListadoContas', [FinancasController::class, 'buscaListadoContas'])->name('financas.buscaListadoContas');
Route::match(['get', 'post'], '/financas/listadoContas', [FinancasController::class, 'listadoContas'])->name('financas.listadoContas');
Route::match(['get', 'post'], '/financas/buscaListadoCreditos', [FinancasController::class, 'buscaListadoCreditos'])->name('financas.buscaListadoCreditos');
Route::match(['get', 'post'], '/financas/listadoCreditos', [FinancasController::class, 'listadoCreditos'])->name('financas.listadoCreditos');

Route::match(['get', 'post'], '/financas/contasCreditosCount', [FinancasController::class, 'getContasCreditosCount'])->name('financas.contasCreditosCount');

// ROTAS CATÃO DE CRÉDITO
Route::get('/financas/faturas', [FaturaCartaoCreditoController::class, 'index'])->name('faturas.index');
Route::get('/financas/fatura/editar/{id}', [FaturaCartaoCreditoController::class, 'editarFatura'])->name('fatura.editar');
Route::post('/financas/fatura/salvar/{id}', [FaturaCartaoCreditoController::class, 'salvarFatura'])->name('fatura.salvar');
Route::get('/financas/fatura/deletar/{id}', [FaturaCartaoCreditoController::class, 'confirmarDelecao'])->name('fatura.confirmDelete');
Route::post('/financas/fatura/deletar/{id}', [FaturaCartaoCreditoController::class, 'deletarFatura'])->name('fatura.deletar');
Route::get('/financas/fatura/criar-manualmente', [FaturaCartaoCreditoController::class, 'criarManualmente'])->name('fatura.criar-manualmente');
Route::post('/financas/fatura/salvar-manualmente', [FaturaCartaoCreditoController::class, 'salvarManualmente'])->name('fatura.salvar-manualmente');

//ROTAS CATEGORIAS
Route::get('/financas/admin/categorias/index', [AdminController::class, 'index'])->name('admin.categorias.index');
Route::get('/financas/admin/categorias/add', [AdminController::class, 'addCategoria'])->name('admin.categorias.add');
Route::post('/financas/admin/categorias/save', [AdminController::class, 'saveCategoria'])->name('admin.categorias.save');
Route::get('/financas/admin/categorias/edit/{id}', [AdminController::class, 'editCategoria'])->name('admin.categorias.edit');
Route::put('/financas/admin/categorias/update/{id}', [AdminController::class, 'updateCategoria'])->name('admin.categorias.update');
Route::get('/financas/admin/categorias/delete/{id}', [AdminController::class, 'confirmDeleteCategoria'])->name('admin.categorias.confirmDelete');
Route::delete('/financas/admin/categorias/destroy/{id}', [AdminController::class, 'destroyCategoria'])->name('admin.categorias.destroy');


















//TESTES
Route::get('/testar-criar-fatura', function () {
    FaturaCartaoCredito::criarFatura();
    return 'Função criarFatura executada com sucesso.';
});