<?php

/**
 * Class Patpass Comercio
 *
 * @category
 * @package App\Http\Controllers
 *
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Transbank\Patpass\PatpassComercio;
use Transbank\Patpass\PatpassComercio\Inscription;
use Transbank\Webpay\Exceptions\WebpayRequestException;
use Transbank\Webpay\Options;

class PatpassComercioController extends Controller
{

    public function __construct()
    {
        if (app()->environment('production')) {
            PatpassComercio::configureForProduction(config('services.transbank.patpass_comercio_cc'), config('services.transbank.patpass_comercio_api_key'));
        } else {
            PatpassComercio::configureForTesting();
        }
    }

    public function startTransaction(Request $request)
    {

        $req = $request->except('_token');
        try {
            $res = Inscription::build()->start(
                $req['url'],
                $req['nombre'],
                $req['pApellido'],
                $req['sApellido'],
                $req['rut'],
                $req['serviceId'],
                $req['finalUrl'],
                $req['montoMaximo'],
                $req['telefonoFijo'],
                $req['telefonoCelular'],
                $req['nombrePatPass'],
                $req['correoPersona'],
                $req['correoComercio'],
                $req['direccion'],
                $req['ciudad']
            );
        } catch (WebpayRequestException $e) {
            dd($e);
        }

        return view('patpass_comercio/inscription_started', [
            "params" => $req,
            "response" => $res,
        ]);
    }
    public function status(Request $request)
    {

        $req = $request->except('_token');
        $res = Inscription::build()->status(
            $req["tokenComercio"]
        );
        return view('patpass_comercio/inscription_status', [
            "params" => $req,
            "response" => $res,
        ]);
    }

    public function finishStartTransaction(Request $request)
    {
        $req = $request->all();
        $res = $request->all();
        return view('patpass_comercio/inscription_finish', [
            "req" => $req,
            "res" => $res,
        ]);
    }

    public function displayVoucher(Request $request)
    {

        $req = $request->all();

        return view('patpass_comercio/voucher_confirmation', [
            "req" => $req,
        ]);
    }
}
