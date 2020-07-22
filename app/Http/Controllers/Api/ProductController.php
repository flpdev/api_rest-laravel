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

    public function show($id){

        $product = $this->product->find($id);
        if (!$product) return response()->json(ApiError::errorMessage('Produto não encontrado',4040),400);

        $data = ['data' => $id];
        return response()->json($data);
    }

    public function store(Request $request){

        try {
            $productData = $request->all();
            $this->product->create($productData);
            $return = ['data' => ['msg' => 'Produto cadastrado']];
            return response()->json($return, 201);

        } catch (\Exception $e) {
            if(config('app.debug')){
                return response()->json(ApiError::errorMessage($e->getMessage(),1010),500);    
            }
            return response()->json(ApiError::errorMessage('Erro ao realizar a operação', 1010),500);
        }

    }

    public function update(Request $request, $id){
        
        try {
            $productData = $request->all();
            $product = $this->product->find($id);

            $product->update($productData);
            $return = ['data' => ['msg' => 'Produto alterado']];
            return response()->json($return, 201);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(ApiError::errorMessage($e->getMessage(), 1011),500);
            }
            return response()->json(ApiError::errorMessage('Erro ao realizar operação de edição', 1011),500);
        }


    }

                           // Indução de tipo
    public function delete(Product $id){

        try {
            $id->delete();
            return response()->json(['data' => ['msg' => 'Produto: ' . $id->name . ' removido com sucesso']],200);
        } catch (\Throwable $e) {
            if (config('app.debug')) {
                return response()->json(ApiErro::errorMessage($e->getMessage(),1012),500);
            }
            return response()->json(ApiError::errorMessage('Erro ao realizar operação de exclusão',1012),500);
        }


    }



}
