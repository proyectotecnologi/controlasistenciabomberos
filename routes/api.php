<?php

use App\Http\Controllers\BiometricoController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['success' => false, 'message' => 'Credenciales inválidas'], 401);
    }

    $token = $user->createToken('token-api')->plainTextToken;

    return response()->json(['success' => true, 'token' => $token]);
});


//Registrar usuario
Route::post('/usuarios_registrados', [BiometricoController::class, 'usuarios_registrados']); //registrar nuevo usuario
Route::get('/listar_usuarios', [BiometricoController::class, 'listar_usuarios']);
Route::post('/registrar_asistencia', [BiometricoController::class, 'registrar']); //realizar marcacion
Route::post('/registrar_asistencia', [BiometricoController::class, 'registrar']);
Route::delete('/usuarios/{finger_id}', [BiometricoController::class, 'eliminar_usuarios']);
