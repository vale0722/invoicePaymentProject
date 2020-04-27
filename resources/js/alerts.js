import swal from 'sweetalert';

if (document.getElementById('divErrors')){
    swal({
        title: "Error!",
        text: 'Algo ha fallado!',
        icon: 'error',
    });
}

if (document.getElementById('divSuccess')){
    swal({
        title: "Proceso finalizado!",
        icon: 'success',
    });
}