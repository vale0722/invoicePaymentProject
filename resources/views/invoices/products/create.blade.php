@extends('layouts.index')
@section('content')
<div class="main main-raised">
    <div class="section">
        <div class="container">
            <a href="{{ route('invoice.edit', $invoice) }}" class="btn btn-blue btn-raised btn-rab btn-round">
                <i class="fas fa-undo"></i>
            </a>
            <div class="title">
                <h2 class="text-blue">
                    Agregar producto a {{ $invoice->title }}
                </h2>
            </div>
            @if($errors->any())
            <div id="divErrors">
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
                @endforeach
            </div>
            @endif
            <form action="{{ route('invoice.product.store', $invoice) }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="quantity">Cantidad: </label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="0"
                            value="{{ old('quantity') }}">
                    </div>
                    <div class="form-group col-6">
                        <label for="product">Producto: </label>
                        <select name="product" id="product" class="form-control @error('product') is-invalid @enderror">
                            @foreach($products as $product)
                            <option value="{{ $product->id }}"> {{ $product->sku . ': ' . $product->name }} </option>
                            @endforeach
                        </select>
                    </div>
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
</div>
@endsection