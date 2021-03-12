<?php

namespace App\Http\Livewire;

use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Http\Controllers\TemplateProductController;
use Livewire\Component;

class TemplateProduct extends Component
{

    public $product = [];
    public $products = [];

    public $template;

    protected $errors;

    protected $listeners = [

    ];

    public function removePhone(int $i)
    {
        unset($this->phones[$i]);

        $this->phones = array_values($this->phones);
    }
    public function removeProduct(int $i)
    {
        unset($this->products[$i]);

        $this->products = array_values($this->products);
    }
    public function addProduct()
    {
        dd(1);
        array_push($this->products, [
            'quantity' => null,
            'price' => null,
            'id' => null,
        ]);
    }

    /**
     * This function will add an empty header value pair
     * causing an extra row to be rendered.
     */

    public function render()
    {

        $product_vars = ProductVariation::all();

        return view('products::template.product._partials._fields', ['action' => 'create', 'errors' => $this->errors, "product_vars" => $product_vars]);
    }

    public function mount($template)
    {
        $this->template = $template;
    }
    public function save()
    {
        dd(1);
        $data = [

            'products' => $this->products,
        ];
        request()->merge($data);
        // dd(request()->all());
        app()->call(TemplateProductController::class . '@store', [
            'template' => $this->template,
        ]);

        return redirect()->route("templates.index");

    }

    // public function selectType($type)
    // {
    //     $this->type = $type;
    // }
    // public function selectProduct($product)
    // {
    //     dd(2);
    //     $this->product = $product;
    // }
}
