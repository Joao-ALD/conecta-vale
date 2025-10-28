<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Plan;

class AdminController extends Controller
{
    /**
     * Mostra o dashboard do administrador com a lista de categorias.
     */
    public function listCategory()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.dashboard', compact('categories'));
    }

    //? Gerenciamento de Categorias
    public function editCategory(Category $category)
    {
        // Esta view usará o layout <x-app-layout>
        return view('admin.categories.edit', compact('category'));
    }
    /** Atualiza uma categoria existente.*/
    public function updateCategory(Request $request, Category $category)
    {
        // 1. Validação (garante que o 'name' é único, exceto para si mesmo)
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id),
            ],
        ]);

        // 2. Atualização
        $category->update([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']), // Atualiza o slug também
        ]);

        // 3. Redirecionar
        return redirect()->route('admin.listCategory')->with('success', 'Categoria atualizada com sucesso!');
    }
    public function storeCategory(Request $request)
    {
        // 1. Validação
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', // Nome deve ser único
        ]);

        // 2. Criação
        Category::create([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']), // Cria o slug automaticamente
        ]);

        // 3. Redirecionar
        return redirect()->route('admin.listCategory')->with('success', 'Categoria criada com sucesso!');
    }
    /** Exclui uma categoria e reatribui produtos órfãos.*/
    public function destroyCategory(Category $category)
    {
        // Não podemos deixar o admin excluir a categoria "Sem Categoria"
        if ($category->slug === 'sem-categoria') {
            return redirect()->route('admin.listCategory')
                ->with('error', 'Não é possível excluir a categoria padrão "Sem Categoria".');
        }

        try {
            // Usamos uma transação para garantir que tudo funcione
            // ou nada seja alterado se der um erro.
            DB::transaction(function () use ($category) {

                // 1. Encontra a categoria "Sem Categoria"
                $defaultCategory = Category::where('slug', 'sem-categoria')->firstOrFail();

                // 2. Encontra os produtos que ficarão "órfãos" (Produtos que SÓ têm esta categoria)
                //    e faz a consulta diretamente no banco de dados.
                $orphans = Product::whereHas('categories', function ($query) use ($category) {
                    $query->where('category_id', $category->id); // O produto deve ter a categoria a ser excluída
                }, '=', 1)->has('categories', '=', 1)->get(); // E o produto deve ter APENAS 1 categoria no total.

                // 3. Reatribui os órfãos
                foreach ($orphans as $product) {
                    $product->categories()->attach($defaultCategory->id);
                }

                // 4. Exclui a categoria
                // Graças ao onDelete('cascade') na migração,
                // todas as ligações em 'category_product' serão excluídas,
                // mas os produtos estarão seguros (e os órfãos agora têm a 'Sem Categoria').
                $category->delete();
            });
        } catch (\Exception $e) {
            // Se algo der errado (ex: 'Sem Categoria' não encontrada)
            return redirect()->route('admin.listCategory')
                ->with('error', 'Ocorreu um erro inesperado ao excluir a categoria: ' . $e->getMessage());
        }

        return redirect()->route('admin.listCategory')->with('success', 'Categoria excluída com sucesso!');
    }

    // ? Gerenciamento de Usuários
    public function listUsers(Request $request)
    {
        // 1. Validação dos filtros
        $validated = $request->validate([
            'role' => ['nullable', 'string', Rule::in(['usuario', 'vendedor', 'admin'])],
            'search' => ['nullable', 'string', 'max:255']
        ]);

        $selectedRole = $validated['role'] ?? null;
        $searchQuery = $validated['search'] ?? null;

        // 2. Query base
        $usersQuery = User::with('sellerProfile')->orderBy('name');

        // 3. Aplica o filtro de busca
        if ($searchQuery) {
            $usersQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', "%{$searchQuery}%")
                    ->orWhere('email', 'like', "%{$searchQuery}%")
                    ->orWhereHas('sellerProfile', function ($q) use ($searchQuery) {
                        $q->where('store_name', 'like', "%{$searchQuery}%");
                    });
            });
        }

        // 4. Aplica o filtro de role
        if ($selectedRole) {
            $usersQuery->where('role', $selectedRole);
        }

        // 5. Paginação
        $users = $usersQuery->paginate(15)->withQueryString();

        // 6. Retorna a view com os dados
        return view('admin.users.index', [
            'users' => $users,
            'selectedRole' => $selectedRole,
            'searchQuery' => $searchQuery // Pass search query back to view
        ]);
    }
    /*Mostra o formulário para editar o nível (role) de um usuário.*/
    public function editUser(User $user)
    {
        // Os níveis (roles) permitidos no sistema
        $roles = ['usuario', 'vendedor', 'admin'];

        return view('admin.users.edit', compact('user', 'roles'));
    }
    /*Atualiza o nível (role) de um usuário.*/
    public function updateUser(Request $request, User $user)
    {
        // Impede que o admin altere a si mesmo por esta tela
        if ($user->id === Auth::id()) {
            abort(403, 'Você não pode alterar seu próprio nível de acesso.');
        }

        $validatedData = $request->validate([
            'role' => ['required', Rule::in(['usuario', 'vendedor', 'admin'])]
        ]);

        $user->update($validatedData);

        // Lógica futura: Se o usuário foi promovido a 'vendedor' e não tem
        // um 'sellerProfile', talvez criar um vazio? Ou redirecionar
        // para uma página que o obrigue a preencher?
        // Por enquanto, apenas mudamos a role.

        return redirect()->route('admin.users.index')->with('success', 'Nível do usuário atualizado com sucesso!');
    }
    /*Exclui um usuário do sistema.*/
    public function destroyUser(User $user)
    {
        // Um admin NUNCA deve poder excluir a si mesmo.
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Você não pode excluir sua própria conta de administrador.');
        }

        // Lógica futura: O que acontece com os produtos do vendedor excluído?
        // Por enquanto, o 'onDelete('cascade')' que definimos em 'products'
        // vai excluir todos os produtos dele. Isso é o esperado.

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuário excluído com sucesso!');
    }


    // ? Gerenciamento de Produtos
    public function destroyProduct(Product $product)
    {
        // 1. Excluir as imagens do disco
        //    (É importante fazer isso ANTES de excluir o produto,
        //     senão perdemos a referência aos arquivos)
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            // O registro da imagem no banco será excluído automaticamente
            // pelo onDelete('cascade') na migration de product_images.
        }

        // 2. Excluir o produto
        //    (Isso também excluirá as ligações em category_product
        //     pelo onDelete('cascade') que definimos lá)
        $product->delete();

        // 3. Redirecionar para a Home (ou para um painel de admin futuro)
        //    com uma mensagem de sucesso.
        return redirect()->route('home')->with('success', 'Anúncio excluído pelo administrador.');
    }

    /**
     * Lista todos os produtos do sistema para moderação.
     */
    public function listProducts(Request $request) // Adicione Request para filtros futuros
    {
        // Busca todos os produtos, mais recentes primeiro, com info do vendedor
        $products = Product::with('seller')
            ->latest()
            ->paginate(20); // Mais produtos por página para admin

        return view('admin.products.index', compact('products'));
    }

    public function listPlans()
    {
        $plans = Plan::orderBy('price')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function createPlan()
    {
        return view('admin.plans.create');
    }

    public function storePlan(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:plans,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'features' => 'nullable|string', // Poderia validar como JSON se usar
            'is_active' => 'boolean',
        ]);
        // Garante que o checkbox 'is_active' tenha valor 0 se não for marcado
        $validatedData['is_active'] = $request->has('is_active');

        Plan::create($validatedData);
        return redirect()->route('admin.plans.index')->with('success', 'Plano criado com sucesso!');
    }

    public function editPlan(Plan    $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function updatePlan(Request $request, Plan $plan)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('plans')->ignore($plan->id)],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $validatedData['is_active'] = $request->has('is_active');

        $plan->update($validatedData);
        return redirect()->route('admin.plans.index')->with('success', 'Plano atualizado com sucesso!');
    }

    public function destroyPlan(Plan $plan)
    {
        // Adicionar lógica de segurança aqui depois (ex: não excluir se houver assinantes)
        try {
            $plan->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.plans.index')->with('error', 'Erro ao excluir plano: ' . $e->getMessage());
        }
        return redirect()->route('admin.plans.index')->with('success', 'Plano excluído com sucesso!');
    }
}