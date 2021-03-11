<?php

namespace App\Http\Livewire;

use App\Domain\Product\Entities\ProductVariation;
use Livewire\Component;

class step2 extends Component
{

    public $state = [];
    public $product = [];
    public $products = [];

    public function removeProduct(int $i)
    {
        unset($this->products[$i]);

        $this->products = array_values($this->products);
    }
    public function addProduct()
    {
        array_push($this->products, [
            'quantity' => null,
            'price' => null,
            'id' => null,
        ]);
    }

    public function submit()
    {
        $data = [

            'products' => $this->products,
        ];
        $this->validate();
        $this->emit("mergeState", $this->state);

    }

    /**
     * This function will add an empty header value pair
     * causing an extra row to be rendered.
     */

    // public function save()
    // {

    //     request()->merge($data);
    //     // dd(request()->all());
    //     app()->call(TemplateProductController::class . '@store', [
    //         'template' => $this->template,
    //     ]);

    //     return redirect()->route("templates.index");

    // }

    public function render()
    {

        $product_vars = ProductVariation::all();

        return view('orders::order.form.step2', ["action" => "create", "product_vars" => $product_vars]);
    }

}
