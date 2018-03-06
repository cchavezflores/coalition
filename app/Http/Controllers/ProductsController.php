<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Return all products from json file
     * @return mixed
     */
    public function all()
    {
        return Storage::get('products.json');
    }

    /**
     * Stores the products in the json file
     * @param Request $request
     */
    public function store(Request $request)
    {
        Storage::put('products.json', json_encode($request->all()));
    }
}
