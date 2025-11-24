<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TelegramReminderController extends Controller
{
    /**
     * Enviar recordatorio de una cita específica vía Telegram
     */
    public function enviarRecordatorioCita($id)
    {
        // Buscar cita con relaciones
        $cita = Cita::with('cliente.persona')->findOrFail($id);

        if ($cita->estado !== 'aceptado') {
            return response()->json([
                'message' => 'Solo se pueden enviar recordatorios de citas aceptadas.'
            ], 400);
        }

        $persona = $cita->cliente->persona ?? null;

        if (!$persona) {
            return response()->json([
                'message' => 'No se encontró la información del cliente.'
            ], 422);
        }

        $hora = Carbon::parse($cita->fechahorainicio)->format('d/m/Y H:i');

        $mensaje = "📌 Recordatorio de Cita\n".
                   "👤 Cliente: {$persona->nombre}\n".
                   "🕒 Día y hora: {$hora}";

        $token = config('services.telegram.token');
        $chatId = config('services.telegram.chat_id');

        if (!$token || !$chatId) {
            return response()->json([
                'message' => 'No se ha configurado Telegram TOKEN o CHAT ID.'
            ], 500);
        }

        $response = Http::get("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $mensaje,
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'No se pudo enviar el mensaje a Telegram.',
                'details' => $response->body(),
            ], 500);
        }

        return response()->json([
            'message' => 'Recordatorio enviado correctamente por Telegram.',
        ]);
    }
}
