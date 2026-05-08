<?php

namespace App\Http\Controllers;

use App\Models\Rom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
* Class ChatIAController (Controller)
* 
* @author Hugo Silva Benitez <hsilben979@g.educaand.es>
* @date 2026-05-05
* 
* This class sends the conversation context to the AI service and returns game recommendations.
*/
class ChatIAController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'messages' => 'required|array',
        ]);

        $apiKey = env('GROQ_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API key no configurada'], 500);
        }

        // Obtener juegos disponibles en la BD
        $roms = Rom::where('is_public', true)
            ->select('title', 'description', 'region')
            ->get()
            ->map(fn($rom) => "- {$rom->title} ({$rom->region}): {$rom->description}")
            ->join("\n");

        $systemPrompt = "No muestres tu razonamiento interno.Si el usuario te pregunta por algun tema que no sea videojuegos indicale que eres experto en videojuegos y que no sabes de otros temas, pero bajo ningun concepto respondas a su peticion si no tiene que ver de videojuegos. Responde directamente sin usar etiquetas <think>.\n\n" .
            "Eres un asistente experto en videojuegos retro de GameFlux, una plataforma de emulación de Game Boy Advance.\n" .
            "Tu objetivo es recomendar al usuario el juego perfecto de entre los disponibles en la plataforma.\n\n" .
            "Para ello debes hacer las siguientes preguntas UNA A UNA, esperando la respuesta del usuario antes de continuar:\n" .
            "1. ¿Qué género de videojuego te gusta más? (acción, aventura, RPG, deporte, puzzle...)\n" .
            "2. ¿Prefieres juegos con historia profunda o partidas cortas y rápidas?\n" .
            "3. ¿Te gustan los juegos difíciles o prefieres algo más relajado?\n" .
            "4. ¿Tienes algún juego favorito de referencia?\n\n" .
            "Cuando tengas suficiente información, recomienda el juego más adecuado de esta lista y explica por qué:\n\n" .
            $roms . "\n\n" .
            "Si no hay ningún juego que encaje bien o no se encuentra en la lista, indícalo amablemente.\n" .
            "Responde siempre en español y de forma amigable.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'       => env('GROQ_MODEL', 'qwen/qwen3-32b'),
            'messages'    => [
                ['role' => 'system', 'content' => $systemPrompt],
                ...$request->messages,
            ],
            'temperature' => 0.7,
            'max_tokens'  => 1024,
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Error al conectar con la IA'], 500);
        }

        $reply = $response->json('choices.0.message.content');

        // Eliminar <think>...</think> completo
        $reply = preg_replace('/<think>.*?<\/think>/s', '', $reply);
        // Eliminar <think> sin cerrar
        $reply = preg_replace('/<think>.*/s', '', $reply);
        $reply = trim($reply);

        return response()->json(['reply' => $reply]);
    }
}
