<?php

namespace App\Payments\Classes;

use App\Helpers\FunctionsHelper;
use App\Models\MercadoPagoProcess;
use App\Payments\Interfaces\PaymentMethodInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Preference;

class MercadoPagoPayment implements PaymentMethodInterface
{
    private $iva = 0.16;
    private $items;
    private $returnURL;
    private $cancelURL;

    public function __construct(array $items, string $returnURL, string $cancelURL)
    {
        $this->items = $items;
        $this->returnURL = $returnURL;
        $this->cancelURL = $cancelURL;
    }

    static function buildItems(array $products): array
    {
        $paypalCollection = collect(Config::get('donations.packages'));
        $items = [];

        foreach ($products as $product) {
            $donationPack = $paypalCollection->where('id', $product['id'])->first();
            $items[] = [
                "id" => $donationPack['id'],
                "title" => $donationPack['name'],
                "description" => $donationPack['description'],
                "category_id" => "virtual_goods",
                "quantity" => $product['qty'],
                "currency_id" => env('MP_CURRENCY'),
                "unit_price" => $donationPack['price'] * 17.5,
            ];
        }
        return $items;
    }



    static function buildPaymentData(array $items, string $returnURL, string $cancelURL): array
    {
        return [
            "auto_return" => "approved",
            "back_urls" => array(
                "success" => $returnURL,
                "failure" => $cancelURL,
            ),
            "expiration_date_form" => Carbon::now()->format('Y-m-d\TH:i:s\Z'),
            "expiration_date_to" => Carbon::now()->addHour()->format('Y-m-d\TH:i:s\Z'),
            "expires" => true,
            "metadata" => array(
                "master_id" => auth()->user()->id,
                "items" => json_encode($items[0]),
                "payment_status" => "pending",
                "paymet_method" => "mercado_pago",
                "mc_gross" => collect($items)->sum('unit_price'),
            ),
            "items" => $items,
            "binary_mode" => true,
            "payment_methods" => array(
                "default_payment_method_id" => "master",
                "excluded_payment_types" => array(
                    array("id" => "ticket"),
                    array("id" => "atm"),
                    array("id" => "bank_transfer"),
                ),
                "installments" => 3,
                "default_installments" => 1
            ),
            "statement_descriptor" => env('MP_STATEMENT_DESCRIPTOR'),
        ];
    }

    private function registerDonation($response) : void
    {
        $total_amount = collect($response->items)->sum('unit_price');
        $helper = new FunctionsHelper();
        $free = (($total_amount * 0.035) + 4.00);
        $iva = $free * $this->iva;
        $total_fee = $free + $iva;
        MercadoPagoProcess::create([
            'preference_id' => $response->id,
            'master_id' => auth()->user()->id,
            'client_id' => $response->client_id,
            'items' => json_encode($response->items),
            'credits' => $total_amount / 17.5,
            'payment_status' => 'pending',
            'create_date' => $response->date_created,
            'mc_gross' => $total_amount,
            'mc_fee' => $total_fee,
            'mc_currency' => env('MP_CURRENCY'),
        ]);
    }

    public function process() : string
    {
        MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));
        $client = new PreferenceClient();
        $items = self::buildItems($this->items);
        $paymentData = self::buildPaymentData($items, $this->returnURL, $this->cancelURL);
        $response = $client->create($paymentData);
        $this->registerDonation($response);
        
        return json_encode($response);
    }
}