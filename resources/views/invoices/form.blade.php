<div class="form-row">
    <div class="form-group col-md-6">
        <label for="reference"> Referencia: </label>
        <input type="text" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference"
            placeholder="Referencia" value="{{ (isset($invoice->reference) ? $invoice->reference : '') }}"
            required>
        <div class="valid-feedback">
            Perfecto!
        </div>
        <div class="invalid-feedback">
            @error('reference')
                {{ $message }}
            @enderror
        </div>
    </div>
    <div class="form-group col-md-6">
        <label for="title"> Título: </label>
        <input type="text" class="form-control @error('title')is-invalid @enderror" id="title" name="title"
            placeholder="Título" value="{{ (isset($invoice->title) ? $invoice->title : old('title')) }}" required>
            <div class="valid-feedback text-left">
                Perfecto!
            </div>
            <div class="invalid-feedback text-left">
                @error('title')
                    {{ $message }}
                @enderror
            </div>
        </div>
    </div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="client">Cliente: </label>
        <select name="client" id="client" class="form-control custom-select @error('client') is-invalid @enderror">
            @foreach($clients as $client)
            <option value="{{ $client->id }}">
                {{ $client->fullDocument .': '. $client->fullName }}
            </option>
            @endforeach
        </select>
        <div class="valid-feedback text-left">
            Perfecto!
        </div>
        <div class="invalid-feedback text-left">
            @error('client')
                {{ $message }}
            @enderror
        </div>
    </div>
    <div class="form-group col-md-6">
        <label for="seller">Vendedor: </label>
        <select name="seller" id="seller" class="form-control custom-select @error('seller') is-invalid @enderror">
            @foreach($sellers as $seller)
            <option value="{{ $seller->id }}">
                {{ $seller->fullDocument .': '. $seller->fullName }}
            </option>
            @endforeach
        </select>
        <div class="valid-feedback text-left">
            Perfecto!
        </div>
        <div class="invalid-feedback text-left">
            @error('seller')
                {{ $message }}
            @enderror
        </div>
    </div>
</div>
