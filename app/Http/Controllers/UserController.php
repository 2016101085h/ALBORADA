<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Persona;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $personas = User::join('personas', 'users.id', '=', 'personas.id')
                ->join('rols', 'users.rol_id', '=', 'rols.id')
                ->select(
                    'personas.id',
                    'personas.nombre',
                    'personas.apellido',
                    'personas.sexo',
                    'personas.direccion',
                    'personas.dni',
                    'personas.fech_nacimiento',
                    'personas.num_celular',
                    'users.usuario',
                    'users.password',
                    'users.condicion',
                    'users.rol_id',
                    'users.imagen',
                    'rols.nombre as rol'
                )
                ->orderBy('personas.id', 'desc')->paginate(5);
        } else {
            $personas = User::join('personas', 'users.id', '=', 'personas.id')
                ->join('rols', 'users.rol_id', '=', 'rols.id')
                ->select(
                    'personas.id',
                    'personas.nombre',
                    'personas.apellido',
                    'personas.sexo',
                    'personas.fech_nacimiento',
                    'personas.direccion',
                    'personas.dni',
                    'personas.num_celular',
                    'users.usuario',
                    'users.password',
                    'users.condicion',
                    'users.rol_id',
                    'users.imagen',
                    'rols.nombre as rol'
                )
                ->where('personas.' . $criterio, 'like', '%' . $buscar . '%')
                ->orderBy('personas.id', 'desc')->paginate(5);
        }


        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function store(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->sexo = $request->sexo;
            $persona->fech_nacimiento = $request->fech_nacimiento;
            $persona->direccion = $request->direccion;
            $persona->num_celular = $request->num_celular;
            $persona->dni = $request->dni;
            $persona->save();

            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->condicion = '1';
            $user->rol_id = $request->rol_id;

            $user->id = $persona->id;


            $exploded = explode(',', $request->imagen);
            $decoded = base64_decode($exploded[1]);

            if (str_contains($exploded[0], 'jpeg')) {

                $extension = 'jpg';
            } else {

                $extension = 'png';
            }

            $fileName = str_random() . '.' . $extension;

            $path = public_path() . '/img/usuario/' . $fileName;

            file_put_contents($path, $decoded);

            $user->imagen = $fileName;

            //fin registrar imagen

            $user->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();

            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);

            $persona = Persona::findOrFail($user->id);

            $persona->nombre = $request->nombre;
            $persona->apellido = $request->tipo_documento;
            $persona->sexo = $request->sexo;
            $persona->fech_nacimiento = $request->fech_nacimiento;
            $persona->direccion = $request->direccion;
            $persona->num_celular = $request->num_celular;
            $persona->dni = $request->dni;
            $persona->save();


            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->condicion = '1';
            $user->rol_id = $request->rol_id;
            $currentPhoto = $user->imagen;

            if ($request->imagen != $currentPhoto) {

                $exploded = explode(',', $request->imagen);
                $decoded = base64_decode($exploded[1]);

                if (str_contains($exploded[0], 'jpeg')) {

                    $extension = 'jpg';
                } else {

                    $extension = 'png';
                }

                $fileName = str_random() . '.' . $extension;

                $path = public_path() . '/img/usuario/' . $fileName;

                file_put_contents($path, $decoded);

                /*inicio eliminar del servidor*/
                $usuarioImagen = public_path('/img/usuario/') . $currentPhoto;
                if (file_exists($usuarioImagen)) {
                    @unlink($usuarioImagen);
                }

                /*fin eliminar del servidor*/

                $user->imagen = $fileName;
            }
            $user->save();


            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}
