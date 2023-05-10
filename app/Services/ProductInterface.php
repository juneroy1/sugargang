<?php
namespace App\Services;
use Illuminate\Http\Request;

 interface ProductInterface {
    public function allProducts(Request $request);
    public function update(Request $request, $id);
    public function show($id);
}

?>