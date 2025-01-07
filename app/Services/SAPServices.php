<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class SAPService
{
    protected Client $client;
    protected ?string $sessionId = null;
    protected string $baseUrl;
    protected string $companyDb;
    protected const CACHE_PREFIX = 'sap_session_';
    protected const CACHE_DURATION = 3600; // 1 hour

    public function __construct()
    {
        $this->baseUrl = rtrim(config('sap.sapb1.url'), '/') . '/';
        $this->setCompanyDb();
        $this->initializeClient();
        $this->initializeSession();
    }

    protected function setCompanyDb(): void
    {
        $this->companyDb = Session::get('company_db');

        if (!$this->companyDb && Auth::check()) {
            $this->companyDb = Auth::user()->company_db;
        }

        if (!$this->companyDb) {
            throw new \Exception('Company database not found in session or user data');
        }
    }

    protected function getCacheKey(): string
    {
        $userId = Auth::id() ?? 'guest';
        return self::CACHE_PREFIX . $userId . '_' . $this->companyDb;
    }

    protected function initializeClient(): void
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'verify' => false,
            'timeout' => 30,
            'connect_timeout' => 10,
            'http_errors' => true,
        ]);
    }

    protected function initializeSession(): void
    {
        $this->sessionId = Cache::get($this->getCacheKey());

        if (!$this->sessionId) {
            $this->authenticate();
        }
    }

    protected function authenticate(): void
    {
        try {
            $response = $this->client->post('Login', [
                'json' => [
                    'UserName' => config('sap.sapb1.username'),
                    'Password' => config('sap.sapb1.password'),
                    'CompanyDB' => $this->companyDb,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $this->sessionId = $body['SessionId'] ?? null;

            if ($this->sessionId) {
                Cache::put($this->getCacheKey(), $this->sessionId, self::CACHE_DURATION);
            } else {
                throw new \Exception('Session ID not found in response');
            }
        } catch (RequestException $e) {
            Log::error('SAP Authentication failed', [
                'error' => $e->getMessage(),
                'company_db' => $this->companyDb,
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ]);
            throw new \Exception('Authentication to SAP B1 failed: ' . $e->getMessage());
        }
    }

    protected function getDefaultHeaders(): array
    {
        return [
            'Cookie' => "B1SESSION={$this->sessionId}",
            'Content-Type' => 'application/json',
            'Prefer' => 'odata.maxpagesize=100'
        ];
    }

    protected function handleRequest(callable $request)
    {
        try {
            $response = $request();
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            if ($e->getResponse() && $e->getResponse()->getStatusCode() === 401) {
                Cache::forget($this->getCacheKey());
                $this->authenticate();
                return json_decode($request()->getBody()->getContents(), true);
            }

            Log::error('SAP API Request failed', [
                'error' => $e->getMessage(),
                'company_db' => $this->companyDb,
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ]);

            throw new \Exception('SAP API request failed: ' . $e->getMessage());
        }
    }

    public function get(string $endpoint, array $parameters = [])
    {
        return $this->handleRequest(function () use ($endpoint, $parameters) {
            return $this->client->get($endpoint, [
                'headers' => $this->getDefaultHeaders(),
                'query' => $parameters
            ]);
        });
    }

    public function getById(string $endpoint, string $id, array $parameters = [])
    {
        return $this->handleRequest(function () use ($endpoint, $id, $parameters) {
            return $this->client->get($endpoint . "('" . $id . "')", [
                'headers' => array_merge(
                    $this->getDefaultHeaders(),
                    ['Prefer' => 'odata.maxpagesize=1']
                ),
                'query' => $parameters
            ]);
        });
    }

    public function post(string $endpoint, array $data)
    {
        return $this->handleRequest(function () use ($endpoint, $data) {
            return $this->client->post($endpoint, [
                'headers' => array_merge(
                    $this->getDefaultHeaders(),
                    ['Prefer' => 'return=representation']
                ),
                'json' => $data
            ]);
        });
    }

    public function put(string $endpoint, array $data)
    {
        return $this->handleRequest(function () use ($endpoint, $data) {
            return $this->client->put($endpoint, [
                'headers' => array_merge(
                    $this->getDefaultHeaders(),
                    ['Prefer' => 'return=representation']
                ),
                'json' => $data
            ]);
        });
    }

    public function patch(string $endpoint, string $id, array $data)
    {
        return $this->handleRequest(function () use ($endpoint, $id, $data) {
            return $this->client->patch($endpoint . "('" . $id . "')", [
                'headers' => array_merge(
                    $this->getDefaultHeaders(),
                    ['Prefer' => 'return=representation']
                ),
                'json' => $data
            ]);
        });
    }

    public function delete(string $endpoint, string $id)
    {
        return $this->handleRequest(function () use ($endpoint, $id) {
            return $this->client->delete($endpoint . "('" . $id . "')", [
                'headers' => $this->getDefaultHeaders()
            ]);
        });
    }

    public function logout(): bool
    {
        try {
            if ($this->sessionId) {
                $response = $this->client->post('Logout', [
                    'headers' => [
                        'Cookie' => "B1SESSION={$this->sessionId}"
                    ]
                ]);

                // Clear the session from cache
                Cache::forget($this->getCacheKey());
                $this->sessionId = null;

                return true;
            }
            return false;
        } catch (RequestException $e) {
            Log::error('SAP Logout failed', [
                'error' => $e->getMessage(),
                'company_db' => $this->companyDb,
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ]);

            // Still clear local session even if remote logout fails
            Cache::forget($this->getCacheKey());
            $this->sessionId = null;

            throw new \Exception('Logout from SAP B1 failed: ' . $e->getMessage());
        }
    }

    public function changeCompanyDb(string $newCompanyDb): void
    {
        // Logout from current session
        $this->logout();

        // Set new company db
        $this->companyDb = $newCompanyDb;
        Session::put('company_db', $newCompanyDb);

        // Re-authenticate with new company
        $this->authenticate();
    }

    public function __destruct()
    {
        try {
            if ($this->sessionId) {
                $this->logout();
            }
        } catch (\Exception $e) {
            Log::error('Error during SAP service cleanup', [
                'error' => $e->getMessage(),
                'company_db' => $this->companyDb
            ]);
        }
    }
}
