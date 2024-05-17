<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    
        {
            try{                
            $productos = Producto::all();
            return response()->json(['productos' => $productos], 200);}
    
            catch(\Exception $e){
                return response()->json (['message' => 'Ha ocurrido un error al obtener el producto ', 'error' => $e-> getMessage()], 500);
            }
    
        }



    public function store(Request $request)
    {
        try {
            
            $validacion = $request->validate([
                'name' => 'required|string',
                'descripcion' => 'required|string',
                'id_categoria' => 'required|numeric',
                'precio' => 'required|numeric'
            ]);

        
            $producto = Producto::create($validacion);

            return response()->json($producto, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ha ocurrido un error al registrar el producto', 'error' => $e->getMessage()], 500);
        }
    }



    public function show(string $id)
    {
        try {
            $producto = Producto::find($id);
            if (!$producto) {
                return response()->json(['error' => 'proceso no encontrado'], 404);
            }
            return response()->json($producto->load('categoria'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ha ocurrido un error al mostrar el producto', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
{
    try {
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(['message' => "Producto no encontrado"], 404);
        }
        
        $validacion = $request->validate([
            'name' => 'required|string',
            'descripcion' => 'required|string',
            'id_categoria' => 'required|numeric',
            'precio' => 'required|numeric'       
        ]);
        // Si la validación es exitosa, actualiza el producto
        $producto->update($request->all());
        return response()->json($producto, 200);

    } catch (\Exception $e) {
        return response()->json(['message' => 'Ha ocurrido un error al actualizar el producto', 'error' => $e->getMessage()], 500);
    }
}


public function destroy(string $id)
{
    try{
    $producto = Producto::find($id);
    if (!$producto){
        return response()->json(['message'=>"El producto no se encuentra o no existe"],404);
    }
    $producto->delete();
    return response()->json( "producto eliminado", 200);}
    catch (\Exception $e){
        return response()->json(['message'=> 'Ha ocurrido un error al eliminar el producto', 'error'=> $e->getMessage()], 500);
    }
    
}
}
