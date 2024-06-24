<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{

    public function index()
    {
        //muestra todos los productos por vistas de 10 por pagina
        $productos = Productos::select('productos.*', 'productos.nombre_producto as producto')->join('categorias', 'categorias.id', '=', 'productos.id_categoria')->paginate(10);
        return response()->json($productos);
    }


    public function store(Request $request)
    {
        //Validaciones
        $reglas = [
            'nombre_producto' => 'required|string|min:1|max:255',
            'descripcion' => 'string',
            'precio' => 'required|numeric',
            'stock' => 'required|numeric',
            'imagen' => 'imagen|string',
            'id_categoria' => 'required|numeric'
        ];

        $validacion = Validator::make($request->input(), $reglas);
        if ($validacion->fails()) {
            return response()->json([
                'status' => false,
                'errores' => $validacion->errors()->all()
            ], 400);
        }


        $producto = new Productos($request->input());

        //con esto se carga una foto los ficheros de public/uploads 
        if ($request->hasFile('imagen')) {
            $producto['imagen'] = $request->file('imagen')->store('uploads', 'public');
        }

        $producto->save();


        return response()->json([
            'status' => true,
            'mensaje' => 'Producto agregado.'
        ], 200);
    }


    public function show(Productos $producto)
    {
        return response()->json([
            'status' => true,
            'Vista previa del producto' => $producto,
        ]);
    }


    public function update(Request $request, Productos $producto)
    {
         //Validaciones
        $reglas = [
            'nombre_producto' => 'required|string|min:1|max:255',
            'descripcion' => 'string',
            'precio' => 'required|numeric',
            'stock' => 'required|numeric',
            'imagen' => 'string',
            'id_categoria' => 'required|numeric'
        ];

        $validacion = Validator::make($request->input(), $reglas);

        if ($validacion->fails()) {
            return response()->json([
                'status' => false,
                'errores' => $validacion->errors()->all()
            ], 400);
        }

        if ($request->hasFile('imagen')) {
            //borra la imagen
            Storage::delete('public/'.$producto->imagen);
            //Y agrega laravel una nueva al directorio
            $producto['imagen'] = $request->file('imagen')->store('uploads', 'public');
        }

        $producto->update($request->input());
        return response()->json([
            'status' => true,
            'mensaje' => 'Producto actualizado.'
        ], 200);
    }



    public function destroy(Productos $producto)
    {
        //si hay imagen, borrala del directorio
        if(Storage::delete('public/'.$producto->imagen)){
            $producto->delete();
            return response()->json([
                'status' => true,
                'mensaje' => 'Producto eliminado.'
            ], 200);
        }  
    }



    public function ProductosPorCategorias()
    {
        //Filtra el numero total de productos por cada categoria
        $productos = Productos::select(DB::raw('count(productos.id) as count,categorias.nombre_categoria'))->rightJoin('categorias', 'categorias.id', '=', 'productos.id_categoria')->groupBy('categorias.nombre_categoria')->get();

        return response()->json($productos);
    }

    public function all()
    {
        //Trae todos los registros de la tb productos
        $productos = Productos::select('productos.*', 'productos.nombre_producto as producto')->join('categorias', 'categorias.id', '=', 'productos.id_categoria')->get();

        return response()->json($productos);
    }
}
