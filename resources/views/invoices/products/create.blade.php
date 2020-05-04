@extends('layouts.index')
@section('content')
<div class="main main-raised">
    <div class="section">
        <div class="container">
            <div class="title">
                <a href="{{ route('invoice.edit', $invoice) }}" class="btn btn-transparent">
                    <i class="fas fa-undo"></i>
                </a>
                <h2 class="text-blue text-center" >
                    <i class="fas fa-shopping-cart"></i> Agregar producto a {{ $invoice->title }}
                </h2>
            </div>
            <form action="{{ route('invoice.product.store', $invoice) }}" class="was-validated" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="quantity">Cantidad: </label>
                        <input type="number"
                            pattern="^[0-9]+" min="1"
                            class="form-control" id="quantity"
                            name="quantity" placeholder="0"
                            value="{{ old('quantity') }}" required>
                        <div class="valid-feedback text-left">
                            Perfecto!
                        </div>
                        <div class="invalid-feedback text-left">
                            @error('quantity')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="product">Producto: </label>
                        <select name="product" id="product" class="form-control custom-select @error('product') is-invalid @enderror">
                            @foreach($products as $product)
                            <option value="{{ $product->id }}"> {{ $product->sku . ': ' . $product->name }} </option>
                            @endforeach
                        </select>
                        <div class="valid-feedback text-left">
                            Perfecto!
                        </div>
                        <div class="invalid-feedback text-left">
                            @error('product')
                                {{ $message }}
                            @enderror
                        </div>
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
