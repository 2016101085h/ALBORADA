<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Nota, Periodo, Aula, Estudiante, Competencia, Curso, Comentario, Maestro, MaestroAula};

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Select Aula
        $aulas = Aula::all();
        //Select Cursos
         $cursos = Curso::all();
        //Select Alumno
        $periodos = Periodo::all();
        $curso_id = $request->curso_id;
        $periodo_id = $request->periodo_id;
        $aula_id = $request->aula_id;
        $estudiantes = Estudiante::where('aula_id', '=', $aula_id)->select('id', 'nombre', 'apellido')->orderBy('apellido', 'asc')->get();
        $competencias = Competencia::where('competencias.curso_id', '=', $curso_id)->orderBy('id','asc')->get();

        $notas = Nota::join('competencias', 'notas.competencia_id', '=', 'competencias.id')->
        join('estudiantes', 'notas.estudiante_id', '=', 'estudiantes.id')->
        join('cursos', 'notas.curso_id', '=', 'cursos.id')->
        join('periodos', 'notas.periodo_id', '=', 'periodos.id')->
        join('aulas', 'notas.aula_id', '=', 'aulas.id')->
        select('notas.estudiante_id','notas.calificacion')->where('notas.curso_id','=',$curso_id)->where('notas.aula_id','=',$aula_id)->where('notas.periodo_id','=',$periodo_id)
        ->orderBy('estudiantes.id','asc')->get();
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
    public function listarPdf(Request $request )
    {
        
        //Select Alumno
        

        $notas = Nota::join('competencias', 'notas.competencia_id', '=', 'competencias.id')->
        join('estudiantes', 'notas.estudiante_id', '=', 'estudiantes.id')->
        join('cursos', 'notas.curso_id', '=', 'cursos.id')->join('periodos', 'notas.periodo_id', '=', 'periodos.id')->
        select('notas.id','competencias.nombre as competencia', 'estudiantes.nombre', 'estudiantes.apellido', 'cursos.nombre as curso',
         'periodos.nombre as periodo', 'notas.calificacion', 'notas.condicion')
            ->where('notas.estudiante_id','=',1)->orWhere('notas.curso_id','=',1)->orderBy('notas.id','asc')->get();
          $cont = Nota::count();
          $pdf = \PDF::loadView('pdf.notaspdf', ['notas' => $notas, 'cont' => $cont]);
          return $pdf->download('notas.pdf');
        //  return['notas'=>$notas];
    }

    /**returm $sdqw, -$wfwefwwrv
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function est_comp(Request $request)
    {
        $select_aula = $request->aula_id;
        $select_curso = $request->curso_id;
        $select_periodo = $request->periodo_id;

        $estudiantes = Estudiante::where('aula_id', '=', $select_aula)->select('id', 'nombre', 'apellido')->orderBy('apellido', 'asc')->get();
        //Select Competencias
        $competencias = Competencia::where('competencias.curso_id', '=', $select_curso)->orderBy('id','asc')->get();
        $cursoSelected = Curso::findOrFail($select_curso);
        $aulaSelected = Aula::findOrFail($select_aula);
        // $mastroSelected = Maestro::findOrFail($select_aula);
        $mastroSelected = MaestroAula::join('maestros','maestro_aulas.maestro_id','=','maestros.id')->select('maestro_aulas.id','maestros.nombre as nombre_maestro','maestros.apellido as apellido_maestro')->where('maestro_aulas.aula_id', '=', $select_aula)->first();
        $periodSelected = Periodo::findOrFail($select_periodo);
        return [
            'competencias' => $competencias,
            'estudiantes' => $estudiantes,
            'cursoSelected' => $cursoSelected,
            'aulaSelected' => $aulaSelected,
            'maestroSelected' => $mastroSelected,
            'periodoSelected' => $periodSelected
        ];
    }

    public function store(Request $request)
    {

        // if(!$request->ajax()) return redirect('/');
        $data = $request->data;
        for ($i = 0; $i < sizeof($request->competencias); $i++) {
            foreach ($data as $d) {
                $nota = new Nota();
                $nota->competencia_id    = $request->competencias[$i]['id'];
                $nota->estudiante_id          = $d['id'];
                $nota->curso_id          = $request->curso_id;
                $nota->periodo_id          = $request->periodo_id;
                $nota->aula_id         =  $request->aula_id;
                $nota->calificacion          = $d['nota']['nota' . $i];
                $nota->condicion         = '1';
                $nota->save();
            }
        }
        foreach ($data as $da) {
            $comentario = new Comentario();        
            $comentario->comentario = $da['comentario'];        
            $comentario->curso_id = $request->curso_id;        
            $comentario->estudiante_id = $da['id'];
            $comentario->periodo_id = $request->periodo_id; 
            $comentario->save();               
        }        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');
        $nota = Nota::findOrFail($request->id);
        $nota->competencia_id          = $request->competencia_id;
        $nota->estudiante_id          = $request->estudiante_id;
        $nota->curso_id          = $request->curso_id;
        $nota->periodo_id          = $request->periodo_id;
        $nota->calificacion          = $request->calificacion;
        $nota->condicion         = '1';
        $nota->save();
    }

    public function desactivar(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');    
        $nota = Nota::findOrFail($request->id);
        $nota->condicion = '0';
        $nota->delete();
    }

    public function activar(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');
        $nota = Nota::findOrFail($request->id);
        $nota->condicion = '1';
        $nota->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function estudiantes(Request $request)
    {
        $aula_id = $request->aula_id;
        $estudiantes = Estudiante::where('aula_id', '=', $aula_id)->get();

        return ['estudiantes' => $estudiantes];
    }
}
