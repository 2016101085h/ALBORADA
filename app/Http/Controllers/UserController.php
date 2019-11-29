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
            $personas = User::join('rols', 'users.rol_id', '=', 'rols.id')
                ->select(
                    'users.id',
                    'users.nombre',
                    'users.apellido',
                    'users.sexo',
                    'users.direccion',
                    'users.dni',
                    'users.fech_nacimiento',
                    'users.num_celular',
                    'users.usuario',
                    'users.password',
                    'users.condicion',
                    'users.rol_id',
                    'users.imagen',
                    'rols.nombre as rol'
                )
                ->orderBy('users.id', 'desc')->paginate(6);
        } else {
            $personas = User::join('rols', 'users.rol_id', '=', 'rols.id')
                ->select(
                    'users.id',
                    'users.nombre',
                    'users.apellido',
                    'users.sexo',
                    'users.direccion',
                    'users.dni',
                    'users.fech_nacimiento',
                    'users.num_celular',
                    'users.usuario',
                    'users.password',
                    'users.condicion',
                    'users.rol_id',
                    'users.imagen',
                    'rols.nombre as rol'
                )
                ->where('users.' . $criterio, 'like', '%' . $buscar . '%')
                ->orderBy('users.id', 'desc')->paginate(5);
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

      
            $user = new user();
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->sexo = $request->sexo;
            $user->fech_nacimiento = $request->fech_nacimiento;
            $user->direccion = $request->direccion;
            $user->num_celular = $request->num_celular;
            $user->dni = $request->dni;
           

          
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->condicion = '1';
            $user->rol_id = $request->rol_id;

            


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

        
      
    }

    public function auth_user() {
        $user = User::findOrFail(\Auth::user()->id);
        return [
            'user_auth' => $user
        ];
    }

    public function update(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

      

            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);



            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->sexo = $request->sexo;
            $user->fech_nacimiento = $request->fech_nacimiento;
            $user->direccion = $request->direccion;
            $user->num_celular = $request->num_celular;
            $user->dni = $request->dni;



            $user->usuario = $request->usuario;
            $user->rol_id=$request->rol_id;
            $user->password = bcrypt($request->password);
            $user->condicion = '1';


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
