<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Goutte\Client;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // truncate table first
        Product::truncate();

        $allProducts = [];

        for ($i=1; $i <= 5; $i++) {
                # code...
                $url = 'https://sugargang.com/collections/alle-produkte?page='.$i;
                $client = new Client();
                $crawler = $client->request('GET', $url);

                $products = $crawler->filter('.product-item')->each(function ($node) {
                    // get data in the html
                    $title = $node->filter('.product-item__title')->text();
                    $price = $node->filter('.price')->text();
                    $image = $node->filter('img')->attr('data-src');
                    $url = $node->filter('a')->attr('href');

                    // Trim the unwanted parts of the image URL
                    $image = str_replace('_{width}x', '_300x', $image);
                    $image = substr($image, 2);
                    $price  = str_replace('Sonderpreis', '', $price);
                    $price  = str_replace(',', '.', $price);

                    // get SKU
                    $sku = explode("v=", $image);
                    // get link url
                    // do a service or a helper to get tthe ingredients and quantity
                    $urlDetails = 'https://sugargang.com'.$url;
                    
                    
                return [
                    'title' => $title,
                    'price' => $price,
                    'image' => $image,
                    'sku' => $sku[1],
                    'url' => $urlDetails,
                    'quantity' => 1,
                    'ingredients' => '',
                ];
            });
            $insertMany = Product::insert($products);
        
        }
    }
}
