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
            <a href="{{ route('home') }}" class="btn btn-blue btn-raised btn-rab btn-round">
                <i class="fas fa-undo"></i>
            </a>
            <div class="title">
                <h2 class="text-danger">
                    <i class="fas fa-ban"></i> Anular {{ $invoice->title . ' REF. ' . $invoice->reference}}
                </h2>
            </div>
            <p class="text-center"> ¿Desea anular la factura?</p>
            <br>
            <form action="{{ route('invoice.annulate', $invoice) }}" class="text-center" method="POST">
                @csrf
                <label for="reason">Motivo: </label>
                <input type="text" class="form-control" id="reason" name="reason" required>
                <br>
                <button type="submit" class="btn btn-success text-center form-control"> confirmar </button>
            </form>
        </div>
    </div>
</div>