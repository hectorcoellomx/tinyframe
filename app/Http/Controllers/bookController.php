<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;

class bookController extends Controller
{
    public function book(Request $request){
        
        $filtros = [
        $calificacion = $request->query('calificacion'),
        $avance = $request->query('avance'),
        $categoria = $request->query('categoria'),
        $coleccion = $request->query('coleccionn'),
        $estanteria = $request->query('estanteria'),
        $masLeido = $request->query('mas_leido'),
        $keyword = $request->query('keyword'),
        ];

        $query = book::query();

        foreach($filtros as $clave => $valor){
            if (!empty($valor)){
                switch ($clave){
                    case 'calificacion':
                        $query->where('calificacion', '>=', $valor);
                    break;
                    case 'avance':
                        $query->where('avance', '>=', $valor);
                    break;
                    case 'categoria':
                    $query->whereHas('categoria', function($q) use ($valor) {
                        $q->where('nombre', $valor);
                    });
                    break;
                    case 'coleccion':
                    $query->whereHas('coleccion', function($q) use ($valor) {
                        $q->where('nombre', $valor);
                    });
                    break;
                    case 'estanteria':
                    $query->whereHas('estanteria', function($q) use ($valor) {
                        $q->where('nombre', $valor);
                    });
                    break;
                    case 'mas_leido':
                    $query->orderBy('lecturas', 'desc'); // Ordenar por el campo 'lecturas'
                    break;
                    case 'keyword':
                    $query->where(function($q) use ($valor) {
                        $q->where('titulo', 'like', "%{$valor}%")
                            ->orWhere('descripcion', 'like', "%{$valor}%");
                    });
                    break;
                }
            }
        }
        $libros = $query->get();

        return response()->json($libros);

    }

}
