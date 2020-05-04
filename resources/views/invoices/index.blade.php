@extends('layouts.index')
@section('content')
<div class="main main-raised">
    <div class="section">
        <div class="container">
            @if($errors->any())
            <div id="divErrors">
                @foreach($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" id="divErrors">
                    {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endforeach
            </div>
            @endif
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" id="divSuccess">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="title">
                <h2 class="text-blue">
                    <div class="row">
                        <div class="col-6"> Facturas Generadas
                             <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="col-6">
                            <div class="text-right btn-group-sm">
                                <a href="{{ route('invoice.create') }}" class="btn btn-blue">
                                    <i class="fas fa-plus"></i> Crear Factura
                                </a>
                            </div>
                        </div>
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
                                </th>
                                <th nowrap>{{ $invoice->created_at }}</th>
                                <th>
                                    <div class="btn-group">
                                        <a href="{{ route('invoice.show', $invoice)}}"
                                            class="btn button-transp text-success">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        @if(!$invoice->isPaid() && !$invoice->isPending() && !$invoice->isAnnulated())
                                        <div>
                                            <a href="{{ route('invoice.edit', $invoice)}}"
                                                class=" btn button-transp text-blue">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{ route('invoice.annulate.view', $invoice)}}"
                                                class=" btn button-transp text-danger">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        </div>
                                        @endif
                                        @if($invoice->isAnnulated())
                                        <div>
                                            <form action="{{ route('invoice.annulate.cancel', $invoice)}}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class=" btn button-transp text-danger">
                                                    <i class="fas fa-undo"></i> Cancelar anulación
                                                </button>
                                            </form>
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
