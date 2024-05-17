<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Categoria;

class CategoriaController extends Controller
{
   
    public function index()
    {
        {
            try{                
            $categorias = Categoria::all();
            return response()->json(['categorias' => $categorias], 200);}
    
            catch(\Exception $e){
                return response()->json (['message' => 'Ha ocurrido un error al obtener las categorias ', 'error' => $e-> getMessage()], 500);
            }    
        }
    }

    
    public function store(Request $request)
    {
        try {
            
            $validacion = $request->validate([
                'name' => 'required|string',
                'descripcion' => 'required|string',
                
            ]);

        
            $categoria = Categoria::create($validacion);

            return response()->json($categoria, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ha ocurrido un error al registrar la categoria', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $categoria = Categoria::find($id);
            if (!$categoria) {
                return response()->json(['error' => 'categoria no encontrada'], 404);
            }
            return response()->json($categoria, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ha ocurrido un error al mostrar la categoria', 'error' => $e->getMessage()], 500);
        }
    }

   
    public function update(Request $request, string $id)
    {
        try {
            $categoria = Categoria::find($id);
            if (!$categoria) {
                return response()->json(['message' => "Categoria no encontrada"], 404);
            }
            
            $validacion = $request->validate([
                'name' => 'required|string',
                'descripcion' => 'required|string',
                    
            ]);
            // Si la validación es exitosa, actualiza el producto
            $categoria->update($request->all());
            return response()->json($categoria, 200);
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ha ocurrido un error al actualizar la categoria', 'error' => $e->getMessage()], 500);
        }
    }

    
    public function destroy(string $id)
    {
        try{
            $categoria = Categoria::find($id);
            if (!$categoria){
                return response()->json(['message'=>"La categoria no se encuentra o no existe"],404);
            }
            $categoria->delete();
            return response()->json( "Categoria eliminada", 200);}
            catch (\Exception $e){
                return response()->json(['message'=> 'Ha ocurrido un error al eliminar la categoria', 'error'=> $e->getMessage()], 500);
            }
    }
}
