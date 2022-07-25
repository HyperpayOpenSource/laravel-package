<?php
namespace App\Http\Controllers;
use Hyperpay\Payment\Controllers\MainController;
use Illuminate\Support\Facades\Session;

class PaymentController extends MainController
{
    public function success($result)
    {
        return $result;
    }

}
