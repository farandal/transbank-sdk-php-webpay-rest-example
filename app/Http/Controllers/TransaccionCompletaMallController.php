<?php

/**
 * Class TransaccionCompletaMall
 *
 * @category
 * @package App\Http\Controllers
 *
 */


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Transbank\TransaccionCompleta\MallTransaction;
use Transbank\TransaccionCompleta\TransaccionCompleta;

class TransaccionCompletaMallController
{

    public function __construct(){
        if (app()->environment('production')) {
            TransaccionCompleta::configureForProduction(config('services.transbank.transaccion_completa_mall_cc'), config('services.transbank.transaccion_completa_mall_api_key'));
        } else {
            TransaccionCompleta::configureForTestingMallNoCVV();
        }
    }

    public function showMallCreate(Request $request)
    {
        $childCommerceCodes = [TransaccionCompleta::DEFAULT_MALL_NO_CVV_CHILD_COMMERCE_CODE_1, TransaccionCompleta::DEFAULT_MALL_NO_CVV_CHILD_COMMERCE_CODE_2];
        return view('transaccion_completa/mall_create',["childCommerceCodes" => $childCommerceCodes ]);
    }


    public function mallCreate(Request $request) {

        $req = $request->except('_token');
        $res = MallTransaction::build()->create(
            $req["buy_order"],
            $req["session_id"],
            $req["card_number"],
            $req["card_expiration_date"],
            $req["details"]
        );


        return view('transaccion_completa/mall_created', [
                "req" => $req,
                "res" => $res,
                "details" => $req["details"]
        ]);
    }

    public function mallInstallments(Request $request)
    {

        $req = $request->except('_token');
        $res = MallTransaction::build()->installments(
            $req["token_ws"],
            $req["details"]
        );

        return view('transaccion_completa/mall_installments', [
            "req" => $req,
            "res" => $res,
            "details" => $req["details"]
        ]);

    }

    public function mallCommit(Request $request)
    {

        $req = $request->except('_token');
        $res = MallTransaction::build()->commit(
            $req["token"],
            $req["details"]
        );

        return view('transaccion_completa/mall_commit', [
            "req" => $req,
            "res" => $res
        ]);

    }

    public function mallStatus($token, Request $request)
    {

        $req = $request->except('_token');
        $res = MallTransaction::build()->status($token);

        return view('transaccion_completa/mall_status', [
            "req" => $req,
            "res" => $res,
            "token" => $token
        ]);
    }

    public function mallRefund(Request $request)
    {

        $req = $request->except('_token');

        $res = MallTransaction::build()->refund(
          $req["token"],
          $req["child_buy_order"],
          $req["child_commerce_code"],
          $req["amount"]
        );

        return view('transaccion_completa/mall_refund', [
            "req" => $req,
            "res" => $res
        ]);

    }


}
