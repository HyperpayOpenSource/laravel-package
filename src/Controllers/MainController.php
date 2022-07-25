<?php

namespace Hyperpay\Payment\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    protected $success_pattren = '/^(000\.000\.|000\.100\.1|000\.[36])/';
    protected $successManualReviewCodePattern = '/^(000\.400\.0|000\.400\.100)/';

    public function payment(Request $request)
    {

        $environment = \config('payments.environment') ?? 'test';
        $url = config("payments.endpoints.$environment.checkouts");
        $response = Http::withoutVerifying()-> get($url . "/" . $request->id . "/payment")->json();

        $code =  ($response['result']['code'] ?? '');
        $success = preg_match($this->success_pattren , $code) || preg_match($this->successManualReviewCodePattern , $code) ;

        if($success){
            return $this->success($response);
        }else{
            return $this->failed($response);
        }
    }

    public function success($result)
    {
        return $result;
    }

    public function failed($result)
    {
        Session::flash('alert' , $result['result']['description']);
        return back();
    }
}
