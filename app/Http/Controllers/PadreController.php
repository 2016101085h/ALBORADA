<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Padre, Estudiante, Periodo, Competencia, Curso, MaestroAula, Maestro,Aula,Nota};

class PadreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        // $maestros = Maestro::all();
        // return $maestros;
        $aulas = Aula::all();
        $periodos = Periodo::all();
        $cursos = Curso::all();

            $padres = Padre::join('estudiantes', 'padres.estudiante_id', '=', 'estudiantes.id')
                ->select(
                    'padres.id',
                    'padres.estudiante_id',
                    'estudiantes.nombre',
                    'estudiantes.apellido',
                    'estudiantes.dni',
                    
                   
                    'padres.dni',
                    
                  
                    'padres.condicion'
                )
                ->orderBy('padres.id', 'asc')->get();
        
            // $padres = Padre::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'desc')->paginate(2);
        
        return [
            
            'padres'    => $padres,
            'aulas' => $aulas,
            'periodos' => $periodos,
            'cursos' => $cursos,
        ];
    }
    
        
   

    public function seleccionarNota(Request $request){
        //Select Aula
        $aulas = Aula::all();
        //Select Cursos
        $cursos = Curso::all();
        //Select Alumno
        $periodos = Periodo::all();
        $curso_id = $request->curso_id;
        $periodo_id = $request->periodo_id;
        $aula_id = $request->aula_id;
        $estudiante_id=$request->estudiante_id;
        $estudiante_id=$request->estudiante_id;
        $estudiantes = Estudiante::where('id', '=', $estudiante_id)->select('id', 'nombre', 'apellido')->orderBy('apellido', 'asc')->get();
        $competencias = Competencia::where('competencias.curso_id', '=', $curso_id)->orderBy('id', 'asc')->get();

        $notas = Nota::join('competencias', 'notas.competencia_id', '=', 'competencias.id')->join('estudiantes', 'notas.estudiante_id', '=', 'estudiantes.id')->
        join('cursos', 'notas.curso_id', '=', 'cursos.id')->join('periodos', 'notas.periodo_id', '=', 'periodos.id')->
        join('aulas', 'notas.aula_id', '=', 'aulas.id')->select('notas.estudiante_id', 'notas.calificacion')->
        where('notas.curso_id', '=', $curso_id)->where('notas.aula_id', '=', $aula_id)->where('notas.periodo_id', '=', $periodo_id)->where('notas.estudiante_id','=',$estudiante_id)




            ->orderBy('estudiantes.id', 'asc')->get();
        return [
            // 'pagination' => [
            //     'total' => $notas->total(),
            //     'current_page' => $notas->currentPage(),
            //     'per_page' => $notas->perPage(),
            //     'last_page' => $notas->lastPage(),
            //     'from' => $notas->firstItem(),
            //     'to' => $notas->lastItem(),
            // ],
            'notas'    => $notas,
            'periodos' => $periodos,
            'cursos' => $cursos,
            'aulas' => $aulas,
            'estudiantes' => $estudiantes,
            'competencias' => $competencias
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // if(!$request->ajax()) return redirect('/');

    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
