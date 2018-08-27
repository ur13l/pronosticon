/**
 * Archivo para la vista editar de una quiniela.
 * Autor: Uriel Infante
 * Mejorado por: Enyerber Freitez
 */
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
        scrollY:        "280px",
        scrollX:        true,
        scrollCollapse: true,
        ordering: false,
        fixedColumns:   {
            leftColumns: 1
        },
        "pageLength": 100,
        "lengthMenu": [[10, 25, 50, 75, 100, 150, 200, 250, -1], [10, 25, 50, 75, 100, 150, 200, 250, "All"]],

        oLanguage: {
            "sProcessing":     "Procesando...",
            "sLengthMenu": 'Mostrar <select>'+
                '<option value="10">10</option>'+
                '<option value="25">25</option>'+
                '<option value="50">50</option>'+
                '<option value="75">75</option>'+
                '<option value="100">100</option>'+
                '<option value="150">150</option>'+
                '<option value="200">200</option>'+
                '<option value="250">250</option>'+
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