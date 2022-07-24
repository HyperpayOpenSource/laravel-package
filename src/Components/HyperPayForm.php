<?php

namespace Hyperpay\Payment\Components;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Http;

class HyperPayForm extends Component
{
    protected $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($amount, $merchantTransactionId, $firstName = "", $lastName = "", $email = "", $street = "", $city = "", $state = "", $country = "", $zip = "", $shipping_cost = "")
    {
        $this->amount = $amount;
        $this->merchantTransactionId = $merchantTransactionId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->street = $street;
        $this->email = $email;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->zip = $zip;
        $this->shipping_cost = $shipping_cost;
        $this->config = config('payments');
        $this->config['gatewayes'] = Arr::where( $this->config['gatewayes'], function ($value) {
            return ($value['enabled'] ?? null) == true;
        });;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $config = $this->config;
        $environment = $config['environment'] ?? 'test';
        $paymentWidgets =  $config['endpoints'][$environment]['paymentWidgets']  ?? null;
        return view('HyperPayForm::hyper-pay-form', compact('config' , 'paymentWidgets'));
    }

    public function prepare($gateWay)
    {

        $method = $this->config['gatewayes'][$gateWay] ?? null;
        $environment = $this->config['environment'] ?? 'test';
        $url = $this->config['endpoints'][$environment]['checkouts'] ?? null ;

        if(!$method || !$url) return null;

        $data = [
            "entityId" => $method['entity_id'],
            "amount" => $this->amount,
            "currency" => $method['currency'],
            "paymentType" => $method['transaction_type'],
            "merchantTransactionId" => $this->merchantTransactionId,
            "customer.email" => $this->email,
            "customer.givenName" => $this->firstName,
            "customer.surname" => $this->lastName,
            "billing.street1" => $this->street,
            "billing.city" => $this->city,
            "billing.state" => $this->state,
            "billing.country" => $this->country,
            "billing.postcode" => $this->zip,
            "shipping.postcode" => $this->zip,
            "shipping.street1" => $this->street,
            "shipping.city" => $this->city,
            "shipping.state" => $this->state,
            "shipping.country" => $this->country,
            "shipping.cost" => $this->shipping_cost,
        ];

        // to remove empty data from array
        $data = array_filter($data);
        $response = Http::withoutVerifying()->asForm()->withToken($method['access_token'])->post($url, $data);
        $response = $response->json();

        return $response["id"] ?? null ;
    }

}
