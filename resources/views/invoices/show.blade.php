@extends('layouts.index')
@section('content')
<div class="section section-btns text-right">
    <div class="container">
        <a class="btn btn-primary" href=""><i class="far fa-eye"></i> Ver intentos de pago </a>
        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#create">
            Realiza el pago de la factura
        </a>
    </div>
</div>
<div class="section section-invoice">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="section">
                    <div class="container">
                        <h5 class="card-title"><b>Información del Cliente</b></h5>
                        <hr>
                        <p class="card-text"><b>Nombre : </b>{{ $invoice->client->fullName }}</p>
                        <p class="card-text"><b>Documento : </b>{{ $invoice->client->fullDocument }}</p>
                        <p class="card-text"><b>Contacto : </b>{{ $invoice->client->mobile }}</p>
                        <p class="card-text"><b>Correo Electrónico : </b>{{ $invoice->client->email }}</p>
                        <p class="card-text"><b>Dirección : </b>{{ $invoice->client->address }}</p>
                        <p class="card-text"><b>Ubicación :</b>
                            {{ $invoice->client->department . '-' . $invoice->client->city }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="section">
                    <div class="container">
                        <h5 class="card-title"><b>Información del Vendedor</b></h5>
                        <hr>
                        <p class="card-text"><b>Nombre : </b>{{ $invoice->seller->fullName }}</p>
                        <p class="card-text"><b>Documento : </b>{{ $invoice->seller->fullDocument }}</p>
                        <p class="card-text"><b>Contacto : </b>{{ $invoice->seller->mobile }}</p>
                        <p class="card-text"><b>Compañia : </b>{{ $invoice->seller->company }}</p>
                        <p class="card-text"><b>Dirección : </b>{{ $invoice->seller->address }}</p>
                        <p class="card-text"><b>Ubicación : </b>
                            {{ $invoice->seller->department . '-' . $invoice->client->city }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="section">
                    <div class="container">
                        <h5 class="card-title"><b>{{ $invoice->title }}</b></h5>
                        <hr>
                        <p class="card-text"><b>Ref. </b> {{ $invoice->reference }}</p>
                        <p class="card-text"><b>Fecha de creación : </b>{{ $invoice->created_at }}</p>
                        <p class="card-text"><b>Fecha de vencimiento : </b>{{ $invoice->duedate }}</p>
                        <p class="card-text"><b>Fecha de recibo : </b>{{ $invoice->receipt_date }}</p>
                        <p class="card-text"><b>Fecha de pago : </b>{{ $invoice->payment_date }}</p>
                        <p class="card-text"><br></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#SKU
                    </th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Unidad</th>
                    <th scope="col">Total</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->products as $product)
                <tr>
                    <th>{{ $product->sku }}</th>
                    <th>{{ $product->category }}</th>
                    <th>{{ $product->name}}</th>
                    <th>{{ $product->pivot->quantity }}</th>
                    <th>{{ '$'. number_format($product->pivot->unit_value) }}</th>
                    <th>{{ '$'. number_format($product->pivot->total_value) }}</th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row text-right">
            <div class="col-sm-9 col-sm-offset-9">
                <p> <b> Subtotal: </b></p>
                <p> <b> IVA (16%): </b></p>
                <p> <b>Total:</b></p>
            </div>
            <div class="col-sm-2 col-sm-offset-9">
                <p> {{ '$'. number_format($invoice->subtotal) }}</p>
                <p> {{'$'. number_format($invoice->vat) }}</p>
                <p> {{'$'. number_format($invoice->total) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection