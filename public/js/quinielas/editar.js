/**
 * Archivo para la vista editar de una quiniela.
 * Autor: Uriel Infante
 * Mejorado por: Enyerber Freitez
 */

$(function() {
    /**
     * Lógica de autocompletado para el input de agregar participante a la quiniela.
     * Este método desencadena el submit del formulario recargando la página 
     * al seleccionar un item.
     */
    $("#id_usuario_autocomplete").autocomplete({
        source: $("#_url").val() + "/usuarios/autocomplete?id_quiniela=" + $("#_id_quiniela").val(),
        minLength: 1,
        select: function(event, ui) {
            var par = JSON.parse($("#participantes").val());
            if (par.indexOf(ui.item.value) == -1) {
                par.push(ui.item.value);
                $("#participantes").val(JSON.stringify(par));
                $("#tabla_participantes").append(`
                    <tr>
                        <td class="startd">
                            ${ui.item.label}
                        </td>
                        <td>
                            <span style="cursor:pointer" data-id="${ui.item.value}" class="eliminar_participante">&times;</span>
                        </td>
                    </tr>
                `)
            
            }
            setTimeout(function() {
            $("#id_usuario_autocomplete").val("");
            }, 20);
        }
    });

    $(document).on('click', ".eliminar_participante", function() {
        var id =$(this).data('id'),
            arr = JSON.parse($("#participantes").val());
        $(this).parent().parent().remove();
        console.log(id);
        arr.pop(id);
        $("#participantes").val(JSON.stringify(arr));
        
    });

    /**
     * Validación de formulario para bolsa.
     */
    $("#form_actualizar_bolsa").validate({
        submitHandler: function(form) {
            form.submit();
        },
        rules: {
            cantidad: {
                required: true
            }
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            $(element).addClass('invalid');
            $(error).css('color', '#F44336 ');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });

    $(".item-jornada").click(function(){ 
        var id_jornada = $(this).data('id'),
            id_quiniela = $('#_id_quiniela').val();
        $("#datos_jornada").html("<h5>Cargando...</h5>")
        $(".item-jornada").removeClass("selected");
        $(this).addClass("selected");
        $.ajax({
            url: $("#_url").val() + "/quinielas/datos_jornada_admin",
            method: 'POST',
            data: {
                id_quiniela: id_quiniela,
                id_jornada: id_jornada,
                _token: $("#_token").val()
            },
            success:function (data) {
                $("#datos_jornada").html(data);
                table();

            },
            error: function(e) {
            }
        });
    });
    table();


    function table() {

        $('#example').DataTable({
            scrollY:        "240px",
            scrollX:        true,
            scrollCollapse: true,
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
    $( "#dialog_eliminar" ).dialog({
        autoOpen: false,
        modal: true,
        show: {
          effect: "fade",
          duration: 200
        },
        hide: {
          effect: "explode",
          duration: 200
        },
        buttons: {
            "Eliminar": function() {
                $("#form_eliminar").submit();
                $( this ).dialog( "close" );
            },
            "Cancelar": function() {
              $( this ).dialog( "close" );
            }
          }
      });

    $("#eliminar_quiniela").click(function() {
        $("#dialog_eliminar").dialog("open");
    });

    $( "#dialog_eliminar_participacion" ).dialog({
        autoOpen: false,
        modal: true,
        show: {
          effect: "fade",
          duration: 200
        },
        hide: {
          effect: "explode",
          duration: 200
        },
        buttons: {
            "Eliminar": function() {
                $("#form_eliminar_participacion").submit();
                $( this ).dialog( "close" );
            },
            "Cancelar": function() {
              $( this ).dialog( "close" );
            }
          }
      });

      $(".eliminar_participacion").click(function() {
        $("#dialog_eliminar_participacion").dialog("open");
        $("#usuario_eliminar").html("¿Estás seguro de eliminar la participación de " + $(this).data('nombre') + "?")
        $("#id_participacion").val($(this).data('id_participacion'));
    });

    $("#imagen").change(function() {
        $("#form_actualizar").submit();
    });

});