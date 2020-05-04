@extends('layouts.index')
@section('content')
<div class="main main-raised">
    <div class="section">
        <div class="container">
            <div class="title">
                <a href="{{ route('home') }}" class="btn btn-transparent h2">
                    <i class="fas fa-undo"></i>
                </a>
                <h2 class="text-danger text-center">
                    <i class="fas fa-ban"></i> Anular {{ $invoice->title . ' REF. ' . $invoice->reference}}
                </h2>
            </div>
            <p class="text-center"> ¿Desea anular la factura?</p>
            <br>
            <form action="{{ route('invoice.annulate', $invoice) }}"
                class="text-center was-validated"
                method="POST" novalidate>
                @csrf
                @method('PATCH')
                <div class="form-row">
                    <label for="reason">Motivo: </label>
                    <input type="text" class="form-control" id="reason"
                        name="reason" minlength="1" required>
                    <div class="valid-feedback">
                        Perfecto!
                    </div>
                    <div class="invalid-feedback">
                        @error('reason')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-success text-center form-control"> confirmar </button>
            </form>
        </div>
    </div>
</div>
