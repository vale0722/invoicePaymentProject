@extends('layouts.index')
@section('content')
<div class="section">
    <div class="container">
        <div class="title">
            <h2 class="text-blue">
                Facturas Generadas <i class="fas fa-file-invoice-dollar"></i>
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
                            <th>{{ $invoice->total }}</th>
                            <th>{{ $invoice->state }}</th>
                            <th nowrap>{{ $invoice->created_at }}</th>
                            <th><a href="{{ route('invoice.show', $invoice)}}" class="text-success"><i class="far fa-eye"></i></a></th>
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