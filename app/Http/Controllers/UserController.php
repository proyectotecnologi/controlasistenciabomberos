<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', ['usuarios' => $usuarios]);
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function store(Request $request)
    {
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request['password']);
        $usuario->fecha_ingreso = date($format = 'Y-m-d');
        $usuario->estado = '1';
        if ($request->hasFile(key: 'fotografia')) {
            $usuario->fotografia = $request->file(key: 'fotografia')->store(path: 'fotografias usuarios', options: 'public');
        }
        $usuario->save();
        return redirect()->route(route: 'usuarios.index')->with('mensaje', 'Se registro al usuario de la manera correcta');
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
    public function update(Request $request, $id)
    {
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
