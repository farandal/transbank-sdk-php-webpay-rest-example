<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Transbank\Webpay\Options;
use Transbank\Webpay\Oneclick\MallInscription;
use Transbank\Webpay\Oneclick\MallTransaction;
use Transbank\Webpay\Oneclick;

class OneclickController extends Controller
{

    public function __construct(){
        if (app()->environment('production')) {
            Oneclick::configureForProduction(config('services.transbank.oneclick_mall_cc'), config('services.transbank.oneclick_mall_api_key'));
        } else {
            Oneclick::configureForTesting();
        }
    }

    public function startInscription(Request $request)
    {

        $req = $request->except('_token');
        $userName = $req["user_name"];
        $email = $req["email"];
        $responseUrl = $req["response_url"];


        $resp = MallInscription::build()->start($userName, $email, $responseUrl);

        session(['user_name' => $userName, 'email' => $email]);
        return view('oneclick/inscription_successful', ['resp' => $resp, 'req' => $req]);
    }

    public function finishInscription(Request $request)
    {
        $req = $request->except('_token');
        $token = $req["TBK_TOKEN"];

        $resp = MallInscription::build()->finish($token);
        $userName = session("user_name");
        return view('oneclick/inscription_finished', ["resp" => $resp, "req" => $req, "username" => $userName]);

    }

    public function authorizeMall(Request $request)
    {
        $req = $request->except('_token');

        $userName = $req["username"];
        $tbkUser = $req["tbk_user"];
        $parentBuyOrder = $req["buy_order"];
        $childBuyOrder = $req["details"][0]["buy_order"];
        $amount = $req["details"][0]["amount"];
        $installmentsNumber = $req["details"][0]["installments_number"];
        $childCommerceCode = $req["details"][0]["commerce_code"];

        $details = [
            [
                "commerce_code" => $childCommerceCode,
                "buy_order" => $childBuyOrder,
                "amount" => $amount,
                "installments_number" => $installmentsNumber
            ]
        ];

        $resp = MallTransaction::build()->authorize($userName, $tbkUser, $parentBuyOrder, $details);

        return view('oneclick/authorized_mall', ["req" => $req, "resp" => $resp]);

    }

    public function transactionStatus(Request $request)
    {
        $req = $request->except('_token');
        $buyOrder = $req["buy_order"];

        $resp = MallTransaction::build()->status($buyOrder);

        return view('oneclick/mall_transaction_status', ["req" => $req, "resp" => $resp]);
    }

    public function refund(Request $request)
    {
        $req = $request->except('_token');
        $buyOrder = $req["parent_buy_order"];
        $childCommerceCode = $req["commerce_code"];
        $childBuyOrder = $req["child_buy_order"];
        $amount = $req["amount"];

        $resp = MallTransaction::build()->refund($buyOrder, $childCommerceCode, $childBuyOrder, $amount);

        return view('oneclick/mall_refund_transaction', ["req" => $req, "resp" => $resp]);
    }

    public function deleteInscription(Request $request)
    {
        $req = $request->except('_token');
        $tbkUser = $req["tbk_user"];
        $userName = $req["user_name"];

        $resp = MallInscription::build()->delete($tbkUser, $userName);
        return view('oneclick/mall_inscription_deleted', ["req" => $req, "resp" => $resp]);
    }



}
