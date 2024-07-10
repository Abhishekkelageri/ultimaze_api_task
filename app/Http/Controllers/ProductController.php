<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\cart;


class ProductController extends Controller
{
    public function list() 
    {
        $products = Product::all();
        $cartItems = cart::with('product')->get();
        // dd($cartItems);

        $total = $cartItems -> sum(fn($item) => $item -> product -> product_price * $item -> quantity);

        return view('Product.list',compact('products','cartItems','total'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        
        if($product){
            $cartItem = cart::where('product_id',$product->id)->first();
            // dd($cartItem);  
            if($cartItem){
                $cartItem->quantity += 1;
                $cartItem-> save();
            }else{
                cart::create(['product_id' => $product->id , 'quantity' => 1]);
            }
            return response()->json(['success' => true , 'message' => "product added to cart"]);
        }

        return response()->json(['success' => false , 'message' => "product not found"]);
    }
    
    public function remove(Request $request)
    {
        $cart = cart::find($request->product_id);
        if($cart){
            $cart->delete();
            return response()->json(['success' => true, 'message' => 'removed']);
        }
        else{
            return response()->json(["success" => false, "message" => 'not found']);
        }
    }

    public function listProducts()
    {
        $products = product::all();

        $cart = cart::with('product')->get();

        return view('index',compact('products','cart'));
    }

    public function addCart(Request $request)
    {
        $product  = product::find($request->id);
        
        if($product){
            $cartItems = cart::where('product_id', $product->id)->first();

            if($cartItems){
                $cartItems->quantity += 1;
                $cartItems -> save();
            } else{
                cart::create(['product_id' => $product -> id , 'quantity' => 1]);
            }
            return response()->json(['success' => true , 'message' => 'added']);
        }
        return response()-> json(['success' => false , 'message' => 'not found']);
    }

    public function delete(Request $request)
    {
        $data = cart::find($request->id);

        if($data){
            $data->delete();
            return response()->json(["success" => true , "message" => 'deleted']);
        }
            return response()->json(["success" => false, "message" => 'not found']);
    }
}
