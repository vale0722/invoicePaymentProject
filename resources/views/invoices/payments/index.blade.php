@extends('layouts.index')
@section('content')
<div class="main main-raised">
    <div class="section">
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
            <a href="{{ route('invoice.show', $invoice) }}" class="btn btn-blue btn-raised btn-rab btn-round">
                <i class="fas fa-undo"></i>
            </a>
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
                                <th scope="col">#</th>
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
                                <th>{{ $payment->id }}</th>
                                <th>{{ $invoice->reference }}</th>
                                <th>{{ '$' . number_format($invoice->total) }}</th>
                                <th>{{ $payment->reason }}
                                <th>{{ $payment->message }}</th>
                                <th>{{ $payment->updated_at }}</th>
                                <th>
                                    @if($payment->isPending())
                                    <a href="{{ route('payment.show', $payment)}}" class="text-success"><i
                                            class="far fa-eye"></i> Continuar</a></th>
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