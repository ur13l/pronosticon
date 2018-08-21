$(document).ready(function() {

    $(".item-jornada").click(function(){ 
        var id_jornada = $(this).data('id'),
            id_participacion = $('#_id_participacion').val();
        $("#datos_jornada").html("<h5>Cargando...</h5>")
        $("#resultados_jornada").html("<h5>Cargando...</h5>")
        $(".item-jornada").removeClass("selected");
        $(this).addClass("selected");
        $.ajax({
            url: $("#_url").val() + "/quinielas/datos_jornada",
            method: 'POST',
            data: {
                id_participacion: id_participacion,
                id_jornada: id_jornada,
                _token: $("#_token").val()
            },
            success:function (data) {
                $("#datos_jornada").html(data);
                table();
            }
        });

        $.ajax({
            url: $("#_url").val() + "/quinielas/resultados_jornada",
            method: 'POST',
            data: {
                id_jornada: id_jornada,
                _token: $("#_token").val()
            },
            success:function (data) {
                $("#resultados_jornada").html(data);
            }
        });


    });
    table();
});


function table() {

    $('#example').DataTable({
        scrollY:        "160px",
        scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 2
        },
        oLanguage: {
            "sProcessing":     "Procesando...",
            "sLengthMenu": 'Mostrar <select>'+
                '<option value="10">10</option>'+
                '<option value="20">20</option>'+
                '<option value="30">30</option>'+
                '<option value="40">40</option>'+
                '<option value="50">50</option>'+
                '<option value="-1">All</option>'+
                '</select> registros',
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando del (_START_ al _END_) de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Filtrar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Por favor espere - cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
}