<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        $roles = Role::all();
        return view('usuarios.index', [
            'usuarios' => $usuarios,
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    /**protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
        ]);
    }*/
    protected function validator(array $data, $id = null)
    {
        $emailRule = ['required', 'string', 'email', 'max:255'];
        if ($id) {
            $emailRule[] = 'unique:users,email,' . $id;
        } else {
            $emailRule[] = 'unique:users';
        }
        $passwordRule = [
            $id ? 'nullable' : 'required', // En update, la contraseña puede ser opcional
            'string',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
        ];
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => $emailRule,
            'password' => $passwordRule,
        ]);
    }

    // public function store(Request $request)
    // {
    //     $this->validator($request->all())
    //         ->setCustomMessages([
    //             'password.regex' => 'La contraseña es obligatorio, minimo 8 caracteres, debe 
    //              contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
    //         ])
    //         ->validate();
    //     $usuario = new User();
    //     $usuario->name = $request->name;
    //     $usuario->email = $request->email;
    //     $usuario->password = Hash::make($request['password']);
    //     $usuario->fecha_ingreso = date($format = 'Y-m-d');
    //     $usuario->estado = '1';
    //     if ($request->hasFile(key: 'fotografia')) {
    //         $usuario->fotografia = $request->file(key: 'fotografia')->store(path: 'fotografias usuarios', options: 'public');
    //     }
    //     $usuario->save();
    //     return redirect()->route(route: 'usuarios.index')->with('mensaje', 'Se registro al usuario de la manera correcta');
    // }

    // FUNCION CARLOS

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->fecha_ingreso = date('Y-m-d');
        $usuario->estado = '1';

        if ($request->hasFile('fotografia')) {
            // Guardamos en storage/app/public/fotografias_usuarios
            $usuario->fotografia = $request->file('fotografia')
                ->store('fotografias_usuarios', 'public');
        }

        $usuario->save();

        return redirect()
            ->route('usuarios.index')
            ->with('mensaje', 'Se registró al usuario correctamente');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.show', ['usuario' => $usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.edit', ['usuario' => $usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    /**public function update(Request $request, $id)
    {
        $this->validator($request->all())
            ->setCustomMessages([
                'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
            ])
            ->validate();
        $usuario = User::findOrFail($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request['password']);
        if ($request->hasFile(key: 'fotografia')) {
            Storage::delete(paths: 'public/' . $usuario->fotografia);
            $usuario->fotografia = $request->file(key: 'fotografia')->store(path: 'fotografias usuarios', options: 'public');
        }
        $usuario->save();
        return redirect()->route(route: 'usuarios.index')->with('mensaje', 'Se actualizo el usuario de la manera correcta');
    }*/

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        // Validación personalizada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => [
                'nullable',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'roles' => 'nullable|array',
            'fecha_ingreso' => 'nullable|date',
            'fotografia' => 'nullable|image|max:2048',
        ], [
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'fotografia.max' => 'La imagen no debe superar los 2MB.',
        ]);

        // Actualizar datos básicos
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->fecha_ingreso = $request->fecha_ingreso ?? $usuario->fecha_ingreso;

        // SOLO actualizar contraseña si el usuario la escribió
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        // ============= MANEJO COMPLETO DE FOTOGRAFÍA =============

        // 1. Si se marcó para eliminar la foto
        if ($request->remove_photo == '1') {
            if ($usuario->fotografia) {
                Storage::delete('public/' . $usuario->fotografia);
            }
            $usuario->fotografia = null;
        }
        // 2. Si viene imagen en base64 (desde cámara web)
        elseif ($request->has('fotografia_base64') && $request->fotografia_base64 !== '') {
            // Eliminar foto anterior SI EXISTE
            if ($usuario->fotografia) {
                Storage::delete('public/' . $usuario->fotografia);
            }

            $base64 = $request->input('fotografia_base64');

            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
                $image = substr($base64, strpos($base64, ',') + 1);
                $image = base64_decode($image);
                $extension = strtolower($type[1]);
                $fileName = Str::random(40) . '.' . $extension;

                $path = storage_path('app/public/fotografias_usuarios/' . $fileName);

                if (!file_exists(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }

                file_put_contents($path, $image);
                $usuario->fotografia = 'fotografias_usuarios/' . $fileName; // ← SIEMPRE asigna la nueva
            }
        }
        // 3. Si se sube archivo manualmente
        elseif ($request->hasFile('fotografia')) {
            // Eliminar foto anterior SI EXISTE
            if ($usuario->fotografia) {
                Storage::delete('public/' . $usuario->fotografia);
            }

            // ← SIEMPRE guarda la nueva foto (exista o no la anterior)
            $usuario->fotografia = $request->file('fotografia')->store('fotografias_usuarios', 'public');
        }

        $usuario->save();

        // Sincronizar roles si están presentes
        if ($request->has('roles')) {
            $usuario->syncRoles($request->roles);
        }

        return redirect()->route('usuarios.index')
            ->with('mensaje', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->route(route: 'usuarios.index')->with('mensaje', 'Se elimino el usuario de la manera correcta');
    }
}
