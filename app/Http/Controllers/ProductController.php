<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Goutte\Client;
use Nesk\Puphpeteer\Puppeteer;

use App\Services\GetProductsServices;

class ProductController extends Controller
{
    
    private $productService;

    public function __construct(GetProductsServices $productService)
    {
        // initialized a service of products e.g saving, retrieving, updating getting all products
        $this->productService = $productService;
    }
    public function show($id){
        return $this->productService->show($id);
    }
    public function update(Request $request, $id){
        return $this->productService->update($request, $id);
    }
    public function allProducts(Request $request){
        return $this->productService->allProducts($request);
    }

    public function store(Request $request){
        // for testing api only   
        $allProducts = Product::all();
        return response()->json(['results'=> $allProducts, 'status' => 'ok'], 200);
        
    }

   
}
