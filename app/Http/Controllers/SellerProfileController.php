<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SellerProfileController extends Controller
{
    /**
     * Mostra o formulário para criar o perfil de vendedor.
     */
    public function create()
    {
        // Se o usuário JÁ tem perfil, redireciona para o dashboard normal
        if (Auth::user()->sellerProfile()->exists()) {
            return redirect()->route('dashboard'); 
        }
        return view('seller.profile.create');
    }

    /**
     * Salva o novo perfil de vendedor.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Se já tem perfil, não permite criar outro
        if ($user->sellerProfile()->exists()) {
            abort(403, 'Perfil de vendedor já existente.');
        }

        $validatedData = $request->validate([
            'store_name' => 'required|string|max:255',
            'document_type' => ['required', Rule::in(['cpf', 'cnpj'])],
            'document_number' => [
                'required',
                'string',
                // Garante que o documento seja único na tabela
                Rule::unique('seller_profiles', 'document_number'), 
                // Validação básica de formato (pode ser melhorada com regras customizadas)
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->document_type == 'cpf' && !preg_match('/^\d{11}$/', $value)) {
                        $fail('O CPF deve conter 11 dígitos.');
                    } elseif ($request->document_type == 'cnpj' && !preg_match('/^\d{14}$/', $value)) {
                        $fail('O CNPJ deve conter 14 dígitos.');
                    }
                },
            ],
            'phone' => 'nullable|string|max:20',
        ]);

        // Cria o perfil associado ao usuário logado
        $user->sellerProfile()->create($validatedData);

        // Redireciona para o painel de anúncios (agora ele terá acesso)
        return redirect()->route('seller.products')->with('success', 'Perfil de vendedor criado com sucesso!');
    }
}