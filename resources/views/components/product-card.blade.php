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

    /**
     * Create a new component instance.
     */
    public function __construct(Product $product) // Peça o produto no construtor
    {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-card');
    }
}