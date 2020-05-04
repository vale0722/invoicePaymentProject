@extends('layouts.index')
@section('content')
<div class="main main-raised">
    <div class="section">
        <div class="container">
            <div class="title">
                <a href="{{ route('home') }}" class="btn btn-transparent">
                    <i class="fas fa-undo"></i>
                </a>
                <h2 class="text-blue text-center" >
                    <i class="fas fa-edit"></i> Editando {{ $invoice->title }}
                </h2>
            </div>
            <form action="{{ route('invoice.update', $invoice) }}" class="was-validated" method="POST">
                @csrf
                @method('put')
                @include('invoices.form')
                <div class="form-group">
                    <label for="stateReceipt"> Marcar Como recibido </label>
                    <select name="stateReceipt" id="stateReceipt">
                        @if(isset($invoice->receipt_date))
                        <option value="1" select> Si </option>
                        <option value="2"> No </option>
                        @else
                        <option value="2" select> No</option>
                        <option value="1"> Si </option>
                        @endif
                    </select>
                </div>
                <div class="form-group text-center">
                    <br>
                    <button type="submit" name="save" class="btn btn-blue">
                        <i class="far fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="section section-invoice">
        <div class="container">
            <h2 class="text-blue text-right">
                <a href="{{ route('invoice.product.create', $invoice) }}"
                    class="btn btn-blue btn-raised btn-rab btn-round">
                    <i class="fas fa-cart-plus"></i>
                </a>
            </h2>
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
                        <div class="col-sm-3 col-sm-offset-9 text-center">
                            <p> {{ '$'. number_format($invoice->subtotal) }}</p>
                            <p> {{'$'. number_format($invoice->vat) }}</p>
                            <p> {{'$'. number_format($invoice->total) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
