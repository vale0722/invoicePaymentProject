@extends('layouts.index')
@section('content')
<div class="main main-raised">
    <div class="section">
        <div class="container">
            <a href="{{ route('home') }}" class="btn btn-blue btn-raised btn-rab btn-round">
                <i class="fas fa-undo"></i>
            </a>
            <div class="title">
                <h2 class="text-blue">
                    <i class="fas fa-plus-circle"></i> Creación de facturas
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
            <form action="{{ route('invoice.store') }}" method="POST">
                @csrf
                @include('invoices.form')
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