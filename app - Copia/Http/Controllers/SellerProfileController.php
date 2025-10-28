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
        return redirect()->route('products.my')->with('success', 'Perfil de vendedor criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar o perfil de vendedor existente.
     */
    public function edit()
    {
        $user = Auth::user();
        // Carrega o perfil do vendedor (assume que ele existe, pois o middleware CheckSellerProfile protege outras rotas)
        // Se esta rota for acessada por um vendedor SEM perfil (raro), dará erro. Podemos adicionar um check depois.
        $profile = $user->sellerProfile()->firstOrFail(); 
        
        return view('seller.profile.edit', compact('profile'));
    }

    /**
     * Atualiza o perfil de vendedor existente.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->sellerProfile()->firstOrFail();

        $validatedData = $request->validate([
            'store_name' => 'required|string|max:255',
            'document_type' => ['required', Rule::in(['cpf', 'cnpj'])],
            'document_number' => [
                'required',
                'string',
                // Garante que o documento seja único, IGNORANDO o registro atual
                Rule::unique('seller_profiles', 'document_number')->ignore($profile->id), 
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

        // Atualiza o perfil
        $profile->update($validatedData);

        // Redireciona de volta para a página de edição com msg de sucesso
        return redirect()->route('seller.profile.edit')->with('success', 'Perfil de vendedor atualizado com sucesso!');
    }
}