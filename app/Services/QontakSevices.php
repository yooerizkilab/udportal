<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class QontakSevices
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = env('QONTAK_BASE_URL');
        $this->token = env('QONTAK_TOKEN');
    }

    public function channel($endpoint, $parameters = [])
    {
        $response = Http::withToken($this->token)->get($this->baseUrl . $endpoint, $parameters);

        if ($response->successful()) {
            return $response; // Mengembalikan objek respons
        } else {
            $errorMessage = $response->body(); // Ambil pesan error dari respons
            throw new \Exception("Request to Qontak API failed: " . $errorMessage);
        }
    }

    public function sendMessage($message = [])
    {
        $endpoint = 'broadcasts/whatsapp/direct';

        $response = Http::withToken($this->token)
            ->withHeader('Content-Type', 'application/json')
            ->post($this->baseUrl . $endpoint, $message);

        if ($response->successful()) {
            return $response; // Mengembalikan objek respons
        } else {
            $errorMessage = $response->body(); // Ambil pesan error dari respons
            throw new \Exception("Request to Qontak API failed: " . $errorMessage);
        }
    }
}
