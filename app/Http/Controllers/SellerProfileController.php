<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\SellerProfile;
use App\Models\Subscription;
use Carbon\Carbon;
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
                // Usa as regras da biblioteca pt-br-validator
                Rule::when($request->document_type == 'cpf', ['cpf']),
                Rule::when($request->document_type == 'cnpj', ['cnpj']),
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
        // Carrega o perfil do vendedor
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
                // Usa as regras da biblioteca pt-br-validator
                Rule::when($request->document_type == 'cpf', ['cpf']),
                Rule::when($request->document_type == 'cnpj', ['cnpj']),
            ],
            'phone' => 'nullable|string|max:20',
        ]);

        // Atualiza o perfil
        $profile->update($validatedData);

        // Redireciona de volta para a página de edição com msg de sucesso
        return redirect()->route('seller.profile.edit')->with('success', 'Perfil de vendedor atualizado com sucesso!');
    }

    public function showPlans()
    {
        $plans = Plan::where('is_active', true)->orderBy('price')->get(); // Apenas planos ativos
        $currentSubscription = Auth::user()->currentSubscription();

        return view('seller.plans.show', compact('plans', 'currentSubscription'));
    }

    public function subscribeToPlan(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $user = Auth::user();

        // --- INÍCIO: Lógica de Pagamento (SIMULAÇÃO) ---
        // TODO: Substituir esta simulação pela integração real com o gateway de pagamento
        $paymentSuccessful = true; // Simula um pagamento bem-sucedido
        // --- FIM: Lógica de Pagamento (SIMULAÇÃO) ---

        if ($paymentSuccessful) {
            // Lógica de expiração (planos pagos duram 1 mês, gratuitos são nulos/permanentes)
            // Ajuste "+1 month" se necessário (ex: +30 days, ou baseado no plano)
            $expiresAt = $plan->price > 0 ? Carbon::now()->addMonth() : null;

            Subscription::updateOrCreate(
                ['user_id' => $user->id], // Chave para encontrar ou criar
                [ // Dados para atualizar ou criar
                    'plan_id' => $plan->id,
                    'expires_at' => $expiresAt,
                ]
            );

            return redirect()->route('seller.plans.show')->with('success', 'Plano atualizado com sucesso!');
        } else {
            // Se o pagamento falhar
            return redirect()->route('seller.plans.show')->with('error', 'Falha no processamento do pagamento. Tente novamente.');
        }
    }
}
