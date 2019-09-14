<?php

namespace MyCV\Wallet;

use GuzzleHttp\Client;

class Wallet
{
    protected $client;

    public function __construct() {
        $this->client = new Client([
            'base_uri' => env('WALLET_API_URL'),
            'headers' => [
                'Wallet-Partner-Public' => env('WALLET_PARTNER'),
                'Wallet-Partner-Secret' => env('WALLET_SECRET'),
            ]
        ]);
    }

    public function getInfo($address)
    {
        $response = $this->client->request('GET', "/v1/wallets/{$address}");
        if ($response->getStatusCode() === OK) {
            return json_decode($response->getBody()->getContents());
        }
    }

    /**
     * Register a wallet
     */
    public function register()
    {
        $response = $this->client->request('POST', '/v1/register');
        if ($response->getStatusCode() === CREATED) {
            return json_decode($response->getBody()->getContents());
        }
    }

    /**
     * Register a wallet
     */
    public function transaction($formParams = [])
    {
        $response = $this->client->request('POST', '/v1/transaction', [
            'form_params' => $formParams
        ]);
        if ($response->getStatusCode() === OK) {
            return json_decode($response->getBody()->getContents());
        }
    }
}
