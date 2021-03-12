{{-- @dd(1) --}}
<form action="">
    


    <div class="form-group row">
        <div class="col-md-2 col-form-label">
            {{__('main.product')}}
        </div>
    <div class="row">
        <div class="col-md">
                <select
                wire:model="product.id"
    
                    class="form-control   {{ $errors->has('product') ? 'is-invalid':""}}    ">
                    <option label="Label"></option>
                    @foreach ($product_vars as $product_var)
                    <option
                    value="{{$product_var->id  }}" {{ ($action == 'edit') && $product->products == 'Individual' ? 'selected' : '' }}>{{ $product_var->name }}</option>
             
    
                    @endforeach
                          </select>
    
            @if($errors->has('product'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('product')}}
                </div>
            @endif
        </div>
        <div class="form-group mr-2">
    
            <input class="form-control "  wire:model="{{ 'product.quantity' }}" type="numeric"  placeholder="quantity"  />
    
        </div>
        <div class="form-group">
    
            <input  class="form-control price "  wire:model="{{ 'product.price' }}" type="numeric"  placeholder="price"  />
    
        </div>
       
    </div>
     </div>
     
     <div class="form-group row">
         @foreach($products as $i => $prod)
        <div class="col-md-2 col-form-label">
            {{__('main.products')}}
        </div>
    
        <div class="col-md">
                <div class="row">
                <div class="col-md">
                        <select
                        wire:model="{{ 'products' . '.' . $i . '.' . 'id' }}"
    
                            class="form-control kt_select2_products  {{ $errors->has('products') ? 'is-invalid':""}}    ">
                            <option label="Label"></option>
                            @foreach ($product_vars as $product_var)
                            <option
                            value="{{$product_var->id  }}" {{ ($action == 'edit') && $prod->products == 'Individual' ? 'selected' : '' }}>{{ $product_var->name }}</option>
                     
    
                            @endforeach
                                  </select>
    
                    @if($errors->has('products'))
                        <div class="alert alert-danger w-100 m-0" role="alert">
                            {{$errors->first('products')}}
                        </div>
                    @endif
                </div>
                <div class="form-group mr-2">
    
                    <input class="form-control "  wire:model="{{ 'products' . '.' . $i . '.' . 'quantity' }}" type="numeric"  placeholder="quantity"  />
                    {{-- <input class="form-control"   wire:model="{{ 'products' . '.' . $i . '.' . 'price' }}" value="{{ $prodcut[$i]->price }}" type="hidden"  /> --}}
    
                </div>
                <div class="form-group">
    
                    <input  class="form-control price "  wire:model="{{ 'products' . '.' . $i . '.' . 'price' }}" type="numeric"  placeholder="price"  />
                    {{-- <input class="form-control"   wire:model="{{ 'products' . '.' . $i . '.' . 'price' }}" value="{{ $prodcut[$i]->price }}" type="hidden"  /> --}}
    
                </div>
                <div class="col-md-auto">
    
                    <button class="btn btn-sm btn-danger land_phones-delete-button"
                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation();"
                            wire:click="removeProduct({{$i}})">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </div>
        </div>
        
        
        
        
        
      
    </div>
    @endforeach
    <div class="d-flex justify-content-end mt-5">
            
            
        <button class="btn btn-secondary "    wire:click.prevent="addProduct">
            {{__('main.add')}} {{__('main.product')}} 
        </button>
        
    </div>
</div>
    
    

<div class="d-flex justify-content-between mt-5">
    <button class="btn btn-primary " wire:click.prevent="" >
        {{__('main.previous')}} 
    </button>

    <button class="btn btn-secondary "    wire:click.prevent="submit">
        {{__('main.create')}} {{__('main.order')}} 
    </button>
    
</div>
</form>
