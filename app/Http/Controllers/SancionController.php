<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Sancion;
use App\Models\Miembro;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class SancionController extends Controller
{
    public function sancionar(Request $request, $tipo, $miembro_id, $mes = null, $anio = null)
    {
        // Validar que el tipo sea válido
        if (!in_array($tipo, ['1', '2', '3'])) {
            return redirect()->back()->with('error', 'Tipo de sanción inválido');
        }

        // Buscar el miembro
        $miembro = Miembro::find($miembro_id);
        if (!$miembro) {
            return redirect()->back()->with('error', 'Miembro no encontrado');
        }

        // Si no se proporciona mes y año, usar los del request o el actual
        if (!$mes || !$anio) {
            $mes = $request->input('mes', now()->month);
            $anio = $request->input('anio', now()->year);
        }

        // Formatear el mes (Y-m)
        $mesFormateado = Carbon::create($anio, $mes, 1)->format('Y-m');

        // Verificar si ya existe una sanción para este mes específico
        $sancionExistente = Sancion::where('miembro_id', $miembro_id)
            ->where('mes', $mesFormateado)
            ->first();

        if ($sancionExistente) {
            return redirect()->back()->with('warning', 'Ya se ha enviado una sanción para este miembro en el mes seleccionado');
        }

        // Crear la sanción
        Sancion::create([
            'mes' => $mesFormateado,
            'tipo' => $tipo,
            'miembro_id' => $miembro_id,
            'enviado' => true,
        ]);

        // Mensaje según el tipo de sanción
        $mensajes = [
            '1' => 'Memorándum enviado correctamente',
            '2' => 'Sanción con memorándum rudo enviada correctamente',
            '3' => 'Sanción grave enviada correctamente'
        ];

        return redirect()->back()->with('success', $mensajes[$tipo]);
    }

    // Opcional: Método para ver el historial de sanciones
    public function historial($miembro_id)
    {
        $miembro = Miembro::with('sanciones')->find($miembro_id);
        if (!$miembro) {
            return redirect()->back()->with('error', 'Miembro no encontrado');
        }

        return view('sanciones.historial', compact('miembro'));
    }

    // Opcional: Método para cambiar estado de sanción
    public function cambiarEstado($sancion_id)
    {
        $sancion = Sancion::find($sancion_id);
        if (!$sancion) {
            return redirect()->back()->with('error', 'Sanción no encontrada');
        }

        $sancion->enviado = !$sancion->enviado;
        $sancion->save();

        $estado = $sancion->enviado ? 'activada' : 'desactivada';
        return redirect()->back()->with('success', "Sanción {$estado} correctamente");
    }












    public function generarPDF($sancion_id)
    {
        try {
            $sancion = Sancion::with('miembro')->find($sancion_id);

            if (!$sancion) {
                return redirect()->back()->with('error', 'Sanción no encontrada');
            }

            // Obtener datos para el PDF
            $meses = [
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre'
            ];

            $data = [
                'miembro' => $sancion->miembro,
                'sancion' => $sancion,
                'fecha_actual' => Carbon::now()->translatedFormat('d \d\e F \d\e Y'),
                'mes_sancion' => $meses[Carbon::parse($sancion->mes . '-01')->month],
                'anio_sancion' => Carbon::parse($sancion->mes . '-01')->year,
                'numero_memorandum' => $this->generarNumeroMemorandum($sancion),
                'referencia' => $this->getReferenciaPorTipo($sancion->tipo),
                'faltas' => $this->obtenerFaltasDelMes($sancion->miembro, $sancion->mes)
            ];

            // Seleccionar la vista según el tipo de sanción
            $vista = 'memorandum.tipo' . $sancion->tipo;

            $pdf = Pdf::loadView($vista, $data);

            $nombreArchivo = "memorandum_{$sancion->miembro->ci}_{$sancion->mes}.pdf";

            return $pdf->download($nombreArchivo);
        } catch (\Exception $e) {
            \Log::error('Error generando PDF: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    private function generarNumeroMemorandum($sancion)
    {
        $numero = Sancion::where('mes', $sancion->mes)
            ->where('id', '<=', $sancion->id)
            ->count();

        $anio = Carbon::parse($sancion->mes . '-01')->format('Y');

        return str_pad($numero, 3, '0', STR_PAD_LEFT) . '/' . $anio;
    }

    private function getReferenciaPorTipo($tipo)
    {
        $referencias = [
            '1' => 'LLAMADA DE ATENCIÓN',
            '2' => 'AMONESTACIÓN ESCRITA',
            '3' => 'ARRESTO'
        ];

        return $referencias[$tipo] ?? 'SANCIÓN DISCIPLINARIA';
    }

    private function obtenerFaltasDelMes($miembro, $mes)
    {
        // Aquí puedes implementar la lógica para obtener las faltas del mes
        // Por ahora retornamos un valor por defecto
        return 1;
    }
}
