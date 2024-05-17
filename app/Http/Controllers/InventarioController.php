<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use App\Models\Producto;

class InventarioController extends Controller
{
    
    public function index()
    {
        try{                
            $inventarios = Inventario::all();
            return response()->json(['inventarios' => $inventarios], 200);}
    
            catch(\Exception $e){
                return response()->json (['message' => 'Ha ocurrido un error al obtener el inventario ', 'error' => $e-> getMessage()], 500);
            }
    }

    public function store(Request $request)
{
    try {
        $validacion = $request->validate([
            'id_producto' => 'required|numeric',
            'cantidad' => 'required|numeric'
        ]);

        // Verificar si ya existe un registro para el id_producto proporcionado
        $inventarioExistente = Inventario::where('id_producto', $validacion['id_producto'])->first();

        if ($inventarioExistente) {
            // Si el producto ya existe en el inventario, actualiza la cantidad sumando la cantidad proporcionada
            $inventarioExistente->cantidad += $validacion['cantidad'];
            $inventarioExistente->save();
            return response()->json($inventarioExistente, 200);
        } else {
            // Si el producto no existe en el inventario, crea un nuevo registro
            $inventarioNuevo = Inventario::create($validacion);
            return response()->json($inventarioNuevo, 201);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Ha ocurrido un error al registrar el inventario del producto', 'error' => $e->getMessage()], 500);
    }
}


    /*public function store(Request $request)
    {
        try {
            
            $validacion = $request->validate([
                
                'id_producto' => 'required|numeric',
                'cantidad' => 'required|numeric'
            ]);

            $inventario = Inventario::create($validacion);

            return response()->json($inventario, 201);    
        }
         catch (\Exception $e) {
            return response()->json(['message' => 'Ha ocurrido un error al registrar el inventario del producto', 'error' => $e->getMessage()], 500);
        }
    }*/

    public function show(string $id)
    {
        try {
            $inventario = Inventario::find($id);
    
            if (!$inventario) {
                return response()->json(['error' => 'Inventario no encontrado'], 404);
            }
    
            // Intenta obtener el producto directamente
            $producto = Producto::find($inventario->id_producto);
    
            // Ahora, verifica si se encontró el producto
            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }
    
            // Combina los datos del inventario y el producto
            $data = [
                'inventario' => $inventario,
                'producto' => $producto
            ];
    
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ha ocurrido un error al mostrar el inventario del producto', 'error' => $e->getMessage()], 500);
        }
    }
    

   /*public function show(string $id)
{
    try {
        $inventario = Inventario::find($id);
        if (!$inventario) {
            return response()->json(['error' => 'Inventario no encontrado'], 404);
        }
        return response()->json($inventario->load('producto'), 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Ha ocurrido un error al mostrar el inventario del producto', 'error' => $e-> getMessage()], 500);
    }
}*/


    public function update(Request $request, string $id)
    {
        try {
            $inventario = Inventario::find($id);
            if (!$inventario) {
                return response()->json(['message' => "Inventario del producto no encontrado"], 404);
            }
            
            $validacion = $request->validate([
                'id_producto' => 'required|numeric',
                'cantidad' => 'required|numeric'      
            ]);
            // Si la validación es exitosa, actualiza el producto
            $inventario->update($request->all());
            return response()->json($inventario, 200);
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ha ocurrido un error al actualizar el inventario del producto', 'error' => $e->getMessage()], 500);
        }
    }


    public function destroy(string $id)
    {
        try{
            $inventario = Inventario::find($id);
            if (!$inventario){
                return response()->json(['message'=>"El inventario del producto no se encuentra o no existe"],404);
            }
            $inventario->delete();
            return response()->json( "inventario del producto ha sido eliminado", 200);}
            catch (\Exception $e){
                return response()->json(['message'=> 'Ha ocurrido un error al eliminar el invcentario del producto', 'error'=> $e->getMessage()], 500);
            }
    }
}
