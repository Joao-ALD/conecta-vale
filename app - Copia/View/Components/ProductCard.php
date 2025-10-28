<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Product; // Importe o modelo

class ProductCard extends Component
{
    /**
     * O produto a ser exibido.
     */
    public $product;
    public $query; // <-- ADICIONE ESTA LINHA

    /**
     * Create a new component instance.
     */
    // Modifique o construtor para aceitar o $query opcional
    public function __construct(Product $product, $query = null)
    {
        $this->product = $product;
        $this->query = $query; // <-- ADICIONE ESTA LINHA
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-card');
    }
}
