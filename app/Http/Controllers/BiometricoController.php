<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Marcaciones;
use App\Models\UserBiometrico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BiometricoController extends Controller
{
    public function registrar(Request $request)
    {
        try {
            $data = $request->all(); // Laravel maneja JSON o x-www-form automáticamente

            Log::info('Registrar asistencia - data: ' . json_encode($data));

            // ✅ 1. Validación primero
            $validator = Validator::make($data, [
                'finger_id' => 'required|integer',
                'estado' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::error('Validación fallida: ' . json_encode($validator->errors()));
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            // ✅ 2. Buscar usuario por finger_id
            $finger_id = $data['finger_id'];
            $usuario = UserBiometrico::where('finger_id', $finger_id)->first();

            if (!$usuario) {
                Log::warning('No se encontró usuario con finger_id: ' . $finger_id);
                return response()->json(['success' => false, 'error' => 'Usuario no registrado'], 404);
            }

            // ✅ 3. Registrar asistencia
            $asistencia = Marcaciones::create([
                'carnet' => $usuario->carnet,
                'fecha_marcacion' => now(),
            ]);

            Log::info('Asistencia registrada correctamente: ID ' . $asistencia->carnet);

            return response()->json(['success' => true, 'asistencia_id' => $asistencia->carnet]);
        } catch (\Exception $e) {
            Log::error('Error en registrar asistencia: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error interno del servidor'], 500);
        }
    }

    public function usuarios_registrados(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'finger_id' => 'required|integer',
                'carnet' => 'required|string|max:30',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            $carnet = $request->input('carnet');
            $finger_id = $request->input('finger_id');

            $existing = UserBiometrico::where('carnet', $carnet)
                ->orWhere('finger_id', $finger_id)
                ->first();

            if ($existing) {
                return response()->json(['success' => false, 'error' => 'Usuario o huella ya registrados'], 409);
            }

            $usuario = UserBiometrico::create([
                'carnet' => $carnet,
                'finger_id' => $finger_id,
            ]);

            return response()->json(['success' => true, 'usuario_id' => $usuario->id]);
        } catch (\Exception $e) {
            \Log::error('Error al registrar usuario: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error interno del servidor'], 500);
        }
    }

    public function listar_usuarios()
    {
        $usuarios = UserBiometrico::all();

        return response()->json([
            'success' => true,
            'data' => $usuarios,
        ]);
    }

    public function eliminar_usuarios($finger_id)
    {
        try {
            // Buscar usuario por finger_id
            $usuario = Usuario::where('finger_id', $finger_id)->first();

            if (!$usuario) {
                return response()->json(['success' => false, 'error' => 'Usuario no encontrado'], 404);
            }

            // Eliminar usuario
            $usuario->delete();

            return response()->json(['success' => true, 'message' => 'Usuario eliminado correctamente']);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar usuario: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Error interno del servidor'], 500);
        }
    }
}
