<?php

namespace App\Payments\Classes;

use App\Helpers\Paypal\PaypalApiContext;
use App\Helpers\Paypal\PaypalHttpClient;
use App\Payments\Interfaces\PaymentMethodInterface;
use Illuminate\Support\Facades\Config;

class PaypalPayment implements PaymentMethodInterface
{
    private $currency;
    private $apiContext;
    private $httpClient;
    private $products;
    private $returnURL;
    private $cancelURL;
    const SANDBOX_URL = 'https://api-m.sandbox.paypal.com/v2/checkout/orders';
    const LIVE_URL = 'https://api-m.paypal.com/v2/checkout/orders';

    public function __construct(array $products, string $returnURL, string $cancelURL)
    {
        $this->currency = Config::get('paypal.currency');
        $this->apiContext = new PaypalApiContext();
        $this->httpClient = new PaypalHttpClient();
        $this->products = $products;
        $this->returnURL = $returnURL;
        $this->cancelURL = $cancelURL;
    }

    private function getPaypalUrl()
    {
        return env('PAYPAL_MODE') == 'SANDBOX' ? self::SANDBOX_URL : self::LIVE_URL;
    }

    public function getOrderInfo($orderID)
    {
        $token = $this->apiContext->getAccessToken();
        $response = $this->httpClient->get($this->getPaypalUrl() . '/' . $orderID, $token);

        return $response;
    }

    public function process() : string
    {
        $token = $this->apiContext->getAccessToken();
        $items = $this->buildItems($this->products);
        $totalPrice = $this->calculateTotalPrice($items);
        $data = $this->buildPaymentData($totalPrice, $items, $this->returnURL, $this->cancelURL);
        $response = $this->httpClient->post($this->getPaypalUrl(), $token, $data);
        $response = json_encode($response->json());

        return $response;
    }

    public function capturePayment($orderID)
    {
        $token = $this->apiContext->getAccessToken();
        $response = $this->httpClient->post($this->getPaypalUrl() . '/' . $orderID . '/capture', $token, [
            'id' => $orderID
        ]);

        return json_encode($response->json());
    }

    static function buildItems($products) : array
    {
        $paypalCollection = collect(Config::get('donations.packages'));
        $items = [];

        foreach ($products as $product) {
            $donationPack = $paypalCollection->where('id', $product['id'])->first();

            $items[] = [
                'name' => $donationPack['name'],
                'currency' => Config::get('paypal.currency'),
                'quantity' => $product['qty'],
                'price' => $donationPack['price'],
                'sku' => $donationPack['id'],
                'description' => $donationPack['description'],
                'category' => 'DONATION',
                'unit_amount' => [
                    'currency_code' => Config::get('paypal.currency'),
                    'value' => $donationPack['price'],
                ],
            ];
        }

        return $items;
    }

    private function calculateTotalPrice($items)
    {
        return array_reduce($items, function ($carry, $item) {
            return $carry + $item['price'] * $item['quantity'];
        }, 0);
    }

    private function buildPaymentData($totalPrice, $items, $returnURL, $cancelURL) : array
    {
        return [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $this->currency,
                        'value' => $totalPrice,
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => $this->currency,
                                'value' => $totalPrice,
                            ]
                        ]
                    ],
                    'items' => $items
                ]
            ],
            'application_context' => [
                'brand_name' => env('APP_NAME'). ' Donations',
                'description' => 'Thank you for supporting our '.env('APP_NAME').' free server! Your generous donation will directly contribute to improving and maintaining our free services. We are grateful for your ongoing support in the development of our project.',
                'locale' => 'en-US',
                'landing_page' => 'NO_PREFERENCE',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                'payment_method' => [
                    'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED'
                ],
                'return_url' => $returnURL,
                'cancel_url' => $cancelURL
            ]
        ];
    }
}