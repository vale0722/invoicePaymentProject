<div class="modal fade" id="create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $invoice->title }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span> × </span>
                </button>
            </div>
            <div class="modal-body">
                @if($invoice->isPending())
                <div class="alert alert-danger"> Tienes un pago en proceso, puedes continuarlo en la sesión "Ver intentos de pago"</div>
                @else
                <div class="container">
                    <div class='row'>
                        <div class="col-md-6">
                            <div class="row"> Nombre del cliente</div>
                            <div class="row"> Documento de Identidad</div>
                            <div class="row"> Correo Electronico</div>
                            <div class="row"> Código de Factura</div>
                            <div class="row"> Estado de la factura </div>
                            <div class="row"> Monto </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row"> {{$invoice->client->fullName}}</div>
                            <div class="row"> {{$invoice->client->documentType.' '. $invoice->client->document}}</div>
                            <div class="row"> {{$invoice->client->email}}</div>
                            <div class="row"> {{$invoice->reference}}</div>
                            <div class="row">
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
                            </div>
                        <div class="row"> {{'$'. number_format($invoice->total) . ' COP'}} </div>
                        </div>
                    </div>
                    <br>
                    <form action="{{ route('payment.store', $invoice) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block"> confirmar </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
