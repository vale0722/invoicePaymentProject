<div class="form-row">
    <div class="form-group col-md-6">
        <label for="reference"> Referencia: </label>
        <input type="text" class="form-control @error('reference')is-invalid @enderror" id="reference" name="reference"
            placeholder="referencia" value="{{ (isset($invoice->reference) ? $invoice->reference : old('reference')) }}"
            require>
    </div>
    <div class="form-group col-md-6">
        <label for="title"> Título: </label>
        <input type="text" class="form-control @error('title')is-invalid @enderror" id="title" name="title"
            placeholder="título" value="{{ (isset($invoice->title) ? $invoice->title : old('title')) }}" require>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="client">Cliente: </label>
        <select name="client" id="client" class="form-control @error('client') is-invalid @enderror">
            @foreach($clients as $client)
            <option value="{{ $client->id }}">
                {{ $client->fullDocument .': '. $client->fullName }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="seller">Vendedor: </label>
        <select name="seller" id="seller" class="form-control @error('seller') is-invalid @enderror">
            @foreach($sellers as $seller)
            <option value="{{ $seller->id }}">
                {{ $seller->fullDocument .': '. $seller->fullName }}
            </option>
            @endforeach
        </select>
    </div>
</div>