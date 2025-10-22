<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Mostra o dashboard do administrador.
     */
    public function dashboard()
    {
        // Aqui você pode adicionar lógica para buscar estatísticas, etc.
        // Por enquanto, vamos apenas retornar uma view.
        return view('admin.dashboard'); // Você precisará criar esta view em: resources/views/admin/dashboard.blade.php
    }
}