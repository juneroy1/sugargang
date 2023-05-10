<?php
namespace App\Services;

use App\Models\Product;
use App\Services\ProductInterface;
use Illuminate\Http\Request;
use Goutte\Client;
use Nesk\Puphpeteer\Puppeteer;
class GetProductsServices implements ProductInterface {

    public function allProducts(Request $request) {
        $perPage = $request->input('per_page', 10); // Get per_page value from request or default to 10

        if ($request->input('search')) {
            $r = $request->input('search');
            $products = Product::where('name', 'like', '%'.$r.'%')->orWhere('sku', 'like', '%'.$r.'%')->paginate($perPage);
        }else{
            $products = Product::paginate($perPage);
        }
       
        return $products;
    }

    public function update(Request $request, $id){
        $product = Product::find($id);

        $product->name = $request->name;
        $product->quantity = $request->quantity;
        $product->ingredients = $request->ingredients;
        $ok = $product->save();
        if ($ok) {
            return response()->json(['result' => $product], 200);
        }
    }

    public function show($id){
        $product = Product::find($id);
        
        // if product ingredients is null or empty then get the data first from the url
        if ($product && !$product->ingredients) {
            $url = $product->url;
            $client = new Client();
            $crawler = $client->request('GET', $url);

            $productDetails = $crawler->filter('.product-block-list')->each(function ($node) {
                // get data in the html
                $ingredients = $node->filter('.rte')->text();
                $quantity = $node->filter('.quantity-selector__value')->attr('value');
                
            return [
                'ingredients' => $ingredients,
                'quantity' => $quantity,
            ];
        });

            // then update product details
            $product->ingredients = $productDetails[0]['ingredients'];
            $product->quantity = $productDetails[0]['quantity'];
            $product->save();
        }


        if ($product) {
            return response()->json(['result' => $product], 200);
        }
    }
}


?>