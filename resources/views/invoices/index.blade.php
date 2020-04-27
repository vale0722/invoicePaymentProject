@extends('layouts.index')
@section('content')
<div class="main main-raised">
    <div class="section">
        <div class="container">
            @if($errors->any())
            <div id="divErrors">
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
                @endforeach
            </div>
            @endif
            <div class="title">
                <h2 class="text-blue">
                    Facturas Generadas <i class="fas fa-file-invoice-dollar"></i>
                    <div class="text-right">
                        <a href="{{ route('invoice.create') }}" class="btn btn-blue btn-raised btn-rab btn-round">
                            <i class="fas fa-plus"></i> Crear Factura
                        </a>
                    </div>
                </h2>
            </div>
            <div class="card">
                <div class="card-body table-invoices">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#Ref</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Vendedor</th>
                                <th scope="col">Total</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Fecha de creación</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <th>{{ $invoice->reference }}</th>
                                <th>{{ $invoice->client->fullName }}</th>
                                <th>{{ $invoice->seller->fullName }}</th>
                                <th>{{ '$'. number_format($invoice->total) }}</th>
                                <th>
                                    @if($invoice->isApproved())
                                    <span class="badge badge-success">Pagada</span>
                                    @elseif($invoice->isExpired())
                                    <span class="badge badge-danger">Vencida</span>
                                    @elseif($invoice->isPending())
                                    <span class="badge badge-warning">Pendiente</span>
                                    @else
                                    <span class="badge badge-secondary">No Pago</span>
                                    @endif
                                </th>
                                <th nowrap>{{ $invoice->created_at }}</th>
                                <th>
                                    <div class="btn-group">
                                        <a href="{{ route('invoice.show', $invoice)}}" class="text-success">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        @if(!$invoice->isApproved() && !$invoice->isPending())
                                        <div>
                                            <a href="{{ route('invoice.edit', $invoice)}}" class="text-warning">
                                                . <i class="far fa-edit"></i>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection