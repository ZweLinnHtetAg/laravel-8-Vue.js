<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {  
        // if(request(search)) 
        // {
        //     return Product::where('name','like','%'.request(search).'%')->orderBy('id','DESC')->paginate(10);
        // }
        // else{
        //     return Product::orderBy('id','DESC')->paginate(10);
        // }

        // $products = Product::query();
        // if(request(search)) 
        // {
        //     return $products->where('name','like','%'.request(search).'%')->orderBy('id','DESC')->paginate(10);
        // }
        // else{
        //     return $products->orderBy('id','DESC')->paginate(10);
        // }

        return Product::when(request('search'),function($query){
            $query->where('name','like','%'.request('search').'%');
        })->orderBy('id','DESC')->paginate(10);
        
    }

    public function create()
    {
        //  
    }

    public function store(ProductStoreRequest $request)
    {
      
        // $request->validate([
        //     'name' => 'required|string',
        //     'price' => 'required|numeric',
        // ],[
        //     'name.required' => "အမည်ထည့်သွင်းရန်လိုအပ်ပါသည်",
        //     'price.requires' => "စျေးနှုန်းထည့်သွင်းရန်လိုအပ်ပါသည်"
        // ]);

        // $product  = new Product;
        // $product->name = $request->name;
        // $product->price = $request->price;
        // $product->save();

        // Product::create(['name'=>$request->name,'price'=>$request->price]);

        // product::create($request->only('name','price'));

        $product =  product::create($request->all());

        return $product;
         
    }

    // public function show($id)
    // {
    //     $product = Product::find($id);
    //     return $product;
    // }

    public function show(Product $product)
    {
        return $product;
    }

    public function edit($id)
    {
        //
    }

    // public function update(Request $request, $id)
    // {
    //     $product = Product::find($id);
    //     // $product->name = $request->name;
    //     // $product->price = $request->price;
    //     // $product->save();

    //     $product->update($request->only('name','price'));

    //     return $product;
    // }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->all());
        return $product;
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return $product;

        
    }
}
