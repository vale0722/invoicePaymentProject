@extends('layouts.index')
@section('content')
@include('invoices.payments.create')
<div class="main main-raised">
    <div class="section section-btns text-right">
        <div class="container">
            @if(session()->has('success'))
            <div class="alert alert-success" id="divSuccess">
                {{session()->get('success')}}
            </div>
            @endif
            @if($errors->any())
            <div id="divSuccess">
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
                @endforeach
            </div>
            @endif
            <a class="btn btn-primary" href="#history"><i class="far fa-eye"></i> Ver
                Intentos de pago
            </a>
            @if(!$invoice->isPaid() && !$invoice->isAnnulated())
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create">
                Realiza el pago de la factura
            </button>
            @endif
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
                            @if($invoice->isPaid())
                            <span class="badge badge-success">Pagada</span>
                            @elseif($invoice->isAnnulated())
                            <span class="badge badge-danger">Anulada</span>
                            @elseif($invoice->isExpired())
                            <span class="badge badge-danger">Vencida</span>
                            @elseif($invoice->isPending())
                            <span class="badge badge-warning">Pendiente</span>
                            @else
                            <span class="badge badge-secondary">No Pago</span>
                            @endif
                            @if(isset($invoice->receipt_date))
                            <span class="badge badge-primary">Recibida</span>
                            @else
                            <span class="badge badge-secondary">No Recibida</span>
                            @endif
                            <hr>
                            <p class="card-text"><b>Ref. </b> {{ $invoice->reference }}</p>
                            <p class="card-text"><b>Fecha de creación : </b>{{ $invoice->created_at }}</p>
                            <p class="card-text"><b>Fecha de vencimiento : </b>{{ $invoice->duedate }}</p>
                            <p class="card-text"><b>Fecha de recibo : </b>{{ $invoice->receipt_date }}</p>
                            <p class="card-text"><b>Fecha de pago : </b>{{ $invoice->payment_date }}</p>
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
                    <p> <b> Total: </b></p>
                </div>
                <div class="col-sm-2 col-sm-offset-9">
                    <p> {{ '$'. number_format($invoice->subtotal) }}</p>
                    <p> {{'$'. number_format($invoice->vat) }}</p>
                    <p> {{'$'. number_format($invoice->total) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="section" id="history" name="history">
        <div class="container">
            <div class="title">
                <h2 class="text-blue">
                    Histórico de Pagos <i class="fas fa-file-invoice-dollar"></i>
                </h2>
            </div>
            <div class="card">
                <div class="card-body table-invoices">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Reference</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Código de estado</th>
                            <th scope="col">Mensaje</th>
                            <th scope="col">Fecha de actualización</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($invoice->payments as $payment)
                            <tr>
                                <th>{{ $invoice->reference }}</th>
                                <th>{{ '$' . number_format($invoice->total) }}</th>
                                <th>
                                    @if(\App\Constans\PaymentsStatuses::FAILED === $payment->reason)
                                        Ha fallado
                                    @elseif(\App\Constans\PaymentsStatuses::OK === $payment->reason)
                                        OK
                                    @elseif(\App\Constans\PaymentsStatuses::APPROVED === $payment->reason)
                                        Aprobado
                                    @elseif(\App\Constans\PaymentsStatuses::APPROVED_PARTIAL === $payment->reason)
                                        Parcialmente Aprobado
                                    @elseif(\App\Constans\PaymentsStatuses::PARTIAL_EXPIRED === $payment->reason)
                                        Pago Parcial Vencido
                                    @elseif(\App\Constans\PaymentsStatuses::REJECTED === $payment->reason)
                                        Denegado
                                    @elseif(\App\Constans\PaymentsStatuses::PENDING === $payment->reason)
                                        Pendiente
                                    @elseif(\App\Constans\PaymentsStatuses::PENDING_VALIDATION === $payment->reason)
                                        Pendiente de Validación
                                    @else
                                        ---
                                    @endif
                                </th>
                                <th>{{ $payment->message }}</th>
                                <th>{{ $payment->updated_at }}</th>
                                <th>
                                    @if($payment->isPending() && !$invoice->isAnnulated())
                                        <a href="{{ route('payment.show', $payment)}}" class="text-success">
                                            <i class="fas fa-running"></i> Continuar</a></th>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <th colspan="8" class="text-center">NO HA REALIZADO NINGÚN INTENTO DE PAGO</th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
