<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriasController extends Controller
{
    
    public function index()
    {
        $categorias = Categorias::all();
        return response()->json($categorias);
    }

    
    public function store(Request $request)
    {
        $reglas = ['nombre_categoria' => 'required|string|min:1|max:100'];
        $validacion = Validator::make($request->input(),$reglas);
        if($validacion->fails()){
             return response()->json([
                'status' => false,
                'errores' => $validacion->errors()->all()
             ], 400);
        }

        $categoria = new Categorias($request->input());
        $categoria->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Categoria agregada.'
         ], 200);
    }

    
    public function show(Categorias $categoria)
    {
        return response()->json([
            'status' => true,
            'Vista previa de la categoría' => $categoria,
    ]);

    }

    
    public function update(Request $request, Categorias $categoria)
    {
        $reglas = ['nombre_categoria' => 'required|string|min:1|max:100'];
        $validacion = Validator::make($request->input(),$reglas);
        if($validacion->fails()){
             return response()->json([
                'status' => false,
                'errores' => $validacion->errors()->all()
             ], 400);
        }

        $categoria->update($request->input());
        
        return response()->json([
            'status' => true,
            'mensaje' => 'Categoria actualizada.'
         ], 200);
    }

    
    public function destroy(Categorias $categoria)
    {
        $categoria->delete();
        return response()->json([
            'status' => true,
            'mensaje' => 'Categoria eliminada.'
         ], 200);
    }
}
