<?php

namespace MyCV\Wallet;

use GuzzleHttp\Client;

class WalletClient
{
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;

    const INCREASE_TYPE = 'increase';
    const DECREASE_TYPE = 'decrease';
    const TRANSFER_TYPE = 'transfer';
    const RECEIVE_TYPE = 'receive';

    const COIN_TYPE = 'coin';
    const CREDIT_TYPE = 'credit';
    const VND_TYPE = 'vnd';

    const ERROR_WALLET_NOT_EXIST = 1001;
    const ERROR_COST_NOT_ENOUGH = 1002;
    const ERROR_RECEIVER_NOT_EXIST = 1003;

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

    /**
     * Get info a wallet by wallet address
     */
    public function getInfo($address)
    {
        $response = $this->client->request('GET', "/v1/wallets/{$address}");
        if ($response->getStatusCode() === self::STATUS_OK) {
            return json_decode($response->getBody()->getContents());
        }
    }

    /**
     * Register a wallet
     */
    public function register()
    {
        $response = $this->client->request('POST', '/v1/register');
        if ($response->getStatusCode() === self::STATUS_CREATED) {
            return json_decode($response->getBody()->getContents());
        }
    }

    /**
     * Make a transaction to wallet
     */
    public function transaction($formParams = [])
    {
        $response = $this->client->request('POST', '/v1/transaction', [
            'form_params' => $formParams
        ]);
        if ($response->getStatusCode() === self::STATUS_OK) {
            return json_decode($response->getBody()->getContents());
        }
    }
}
