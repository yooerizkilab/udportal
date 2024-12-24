<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Exception;

class SAPServices
{
    protected $baseUrl;
    protected $sessionId;

    public function __construct()
    {
        $this->baseUrl = env('SAP_B1_URL');
        $this->authenticate();
    }

    /**
     * 
     * * Authentication to SAP B1 API
     * 
     **/
    protected function authenticate()
    {
        $response = Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Content-Type' => 'application/json'
        ])->post($this->baseUrl . 'Login', [
            'UserName' => env('SAP_B1_USERNAME'),
            'Password' => env('SAP_B1_PASSWORD'),
            'CompanyDB' => env('SAP_B1_DATABASE')
        ]);

        if ($response->successful()) {
            $this->sessionId = $response['SessionId'];
        } else {
            $errorMessage = $response->body(); // Ambil pesan error dari respons
            throw new \Exception("Authentication to SAP B1 failed: " . $errorMessage);
        }
    }

    /**
     * 
     * * GET Service Method to SAP B1 API
     * 
     **/
    public function get($endpoint, $parameters = [])
    {
        return Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Cookie' => "B1SESSION={$this->sessionId}",
            'Content-Type' => 'application/json',
            'Prefer' => 'odata.maxpagesize=100'
        ])->get($this->baseUrl . $endpoint, $parameters);

        if ($response->successful()) {
            // Ambil data dari response menjadi json
            return $response;
        } else {
            $errorMessage = $response->body(); // Ambil pesan error dari respons
            throw new \Exception("Authentication to SAP B1 failed: " . $errorMessage);
        }
    }

    /**
     * 
     * * GET By ID Service Method to SAP B1 API
     * 
     **/
    public function getById($endpoint, $id, $parameters = [])
    {
        return Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Cookie' => "B1SESSION={$this->sessionId}",
            'Content-Type' => 'application/json',
            'Prefer' => 'odata.maxpagesize=1'
        ])->get($this->baseUrl . $endpoint . "('" . $id . "')", $parameters);

        if ($response->successful()) {
            return $response;
        } else {
            $errorMessage = $response->body(); // Ambil pesan error dari respons
            throw new \Exception("Authentication to SAP B1 failed: " . $errorMessage);
        }
    }

    /**
     * 
     * * POST Service Method to SAP B1 API
     * 
     **/
    public function post($endpoint, $data)
    {
        return Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Cookie' => "B1SESSION={$this->sessionId}",
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ])->post($this->baseUrl . $endpoint, $data);

        if ($response->successful()) {
            return $respons;
        } else {
            $errorMessage = $response->body(); // Ambil pesan error dari respons
            throw new \Exception("Authentication to SAP B1 failed: " . $errorMessage);
        }
    }

    /**
     * 
     * * PUT Service Method to SAP B1 API
     * 
     **/
    public function put($endpoint, $data)
    {
        return Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Cookie' => "B1SESSION={$this->sessionId}",
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ])->put($this->baseUrl . $endpoint, $data);

        if ($response->successful()) {
            return $response;
        } else {
            $errorMessage = $response->body(); // Ambil pesan error dari respons
            throw new \Exception("Authentication to SAP B1 failed: " . $errorMessage);
        }
    }

    /**
     *  
     * * PATCH Service Method to SAP B1 API 
     * 
     **/
    public function patch($endpoint, $id, $data)
    {
        return Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Cookie' => "B1SESSION={$this->sessionId}",
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ])->patch($this->baseUrl . $endpoint . "('" . $id . "')", $data);

        if ($response->successful()) {
            return $response;
        } else {
            $errorMessage = $response->body(); // Ambil pesan error dari respons
            throw new \Exception("Authentication to SAP B1 failed: " . $errorMessage);
        }
    }

    /** 
     * 
     * * DELETE Service Method to SAP B1 API
     * 
     **/
    public function delete($endpoint, $id)
    {
        return Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Cookie' => "B1SESSION={$this->sessionId}",
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ])->delete($this->baseUrl . $endpoint . "('" . $id . "')");

        if ($response->successful()) {
            return $response;
        } else {
            $errorMessage = $response->body(); // Ambil pesan error dari respons
            throw new \Exception("Authentication to SAP B1 failed: " . $errorMessage);
        }
    }

    /** 
     *
     * * Logout Service Method to SAP B1 API
     *
     **/
    public function logout()
    {
        try {
            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'Cookie' => "B1SESSION={$this->sessionId}"
            ])->post($this->baseUrl . 'Logout');

            if ($response->successful()) {
                $this->sessionId = null;
                return $response;
            } else {
                $errorMessage = $response->body();
                throw new \Exception("Logout from SAP B1 failed: " . $errorMessage);
            }
        } catch (\Exception $e) {
            throw new \Exception("Error during logout: " . $e->getMessage());
        }
    }
}
