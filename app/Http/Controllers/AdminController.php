<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Categoria;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $admin;
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        $categorias = Admin::allCategoria();
        return view('admin.categorias.index', compact('categorias'));
    }

    public function addCategoria()
    {
        $categorias = $this->admin->allCategoria();
        $ultimoIdCategoria = $categorias->max('categoria_id');

        return view('admin.categorias.add-categoria', compact('ultimoIdCategoria'));
    }

    public function saveCategoria(Request $request)
    {
        // Validação dos dados, se necessário
        $request->validate([
            'categoria_id' => 'nullable|integer',
            'nome' => 'required|string',
            'secao' => 'required|in:1,2,',
            'ativo' => 'required|in:0,1,',
        ]);

        // Criação da categoria
        Admin::addCategoria($request->all());

        return redirect()->route('admin.categorias.index');
    }

    public function editCategoria(int $id)
    {
        $categoria = $this->admin->findCategoria($id);
        return view('admin.categorias.edit-categoria', compact('categoria'));
    }

    public function updateCategoria(int $id, Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|string',
            'nome' => 'required|string',
            'secao' => 'required|in:1,2',
            'ativo' => 'required|in:0,1,',
        ]);

        $formData = [
            'categoria_id' => $request->input('categoria_id'),
            'nome' => $request->input('nome'),
            'secao' => $request->input('secao'),
            'ativo' => $request->input('ativo'),
        ];

        $this->admin->updateCategoria($id, $formData);
        return redirect()->route('admin.categorias.index');
    }

    public function confirmDeleteCategoria(int $id)
    {
        $categoria = $this->admin->findCategoria($id);
        return view('admin.categorias.confirmDelete', compact('categoria'));
    }

    public function destroyCategoria(int $id)
    {
        $this->admin->deleteCategoria($id);
        return redirect()->route('admin.categorias.index');
    }
}
