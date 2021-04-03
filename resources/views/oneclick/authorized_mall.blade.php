@extends('layout')
@section('content')
<h1>Request</h1>
<pre> {{  print_r($req, true) }} </pre>


<h1>Response</h1>
<?php if($resp->isApproved()): ?>
<span class="text-green-700 text-xl my-2 inline-block font-bold">Transacción aprobada</span>
<?php else: ?>
<span class="text-red-700 text-xl my-2 inline-block font-bold">Transacción rechazada</span>
<?php endif; ?>
<pre> {{  print_r($resp, true) }} </pre>


<h2>Estado de la transacción</h2>
<form method="post" action="/oneclick/mall/transactionStatus" >
    @csrf
    <label>Buy order: {{ $resp->getBuyOrder() }}</label>
    <input type="text" name="buy_order" value="{{  $resp->getBuyOrder() }}">

    <button type="submit">Enviar datos</button>
</form>



<h2>Reembolso de la transacción</h2>
<form method="post" action="/oneclick/mall/refund">
    @csrf
    <label>Buy order padre</label>
    <input name="parent_buy_order" value="{{ $resp->getBuyOrder() }}">

    <label>Commerce code hijo</label>
    <input name="commerce_code" value="{{ $resp->getDetails()[0]->getCommerceCode() }}">

    <label>Buy order hijo</label>
    <input name="child_buy_order" value="{{ $resp->getDetails()[0]->getBuyOrder() }}">

    <label>Monto</label>
    <input name="amount" value="{{ $resp->getDetails()[0]->getAmount() }}"/>

    <button type="submit">Enviar</button>
</form>
@endsection
