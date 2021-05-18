<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <style>
        .webpay_form input {
            font-size: 20px;
        }
    </style>

</head>

<body>
<h1> Ejemplo Transacción Completa creada</h1>

<h3>Parametros recibidos:</h3>
<pre>
    {{ print_r($req) }}
</pre>


<h3>Respuesta:</h3>
<pre>
    {{ print_r($res)  }}
</pre>

<form class="webpay_form" method="post" action="/transaccion_completa/installments" style="display: flex; flex-direction:column; width:50%;font-size: 20px;">
    @csrf
    <label for="installments_number">
        Cuotas
    </label>
    <input id="installments_number" name="installments_number" value="10"/>
    <label for="token_ws">
        Token
    </label>
    <input name="token_ws" value={{ $res->getToken() }} />

    <button type="submit">Consultar Cuotas</button>
</form>
<br>
<br>
<br>
<form class="webpay_form" action="/transaccion_completa/transaction_commit" method="post" style="display: flex; flex-direction:column; width:50%;font-size: 20px;" >
    @csrf
    <label for="token_ws">Token</label>
    <input type="text" name="token_ws" value="{{ $res->getToken() }}">
    <label for="grace_period">
        Periodo de Gracia
    </label>
    <input type="text" name="grace_period" value="false">
    <button type="submit">Confirmar Transaccion</button>
</form>


</body>
