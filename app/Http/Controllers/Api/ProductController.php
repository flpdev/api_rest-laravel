<?php

namespace App\Http\Controllers\Api;

use App\API\ApiError;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Product;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product){

        $this->product = $product;

    }

    public function index(){

        //$data = ['data' => $this->product->paginate(5)];
        // PAGINATE, FUNCIONALIDADE DO LARAVEL QUE PERMITE A PAGINAÇÃO DOS RESULTADOS
                
        return response()->json($this->product->paginate(5));

    }

    public function show(Product $id){

        $data = ['data' => $id];

        return response()->json($data);
    }

    public function store(Request $request){

        try {
            $ProductData = $request->all();
            $this->product->create($ProductData);
        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiError::errorMessage($e->getMessage(),1010));    
            }
            return response()->json(ApiError::errorMessage('Erro ao realizar a operação', 1010));
        }

    }



}
