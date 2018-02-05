/**
 * Archivo para la vista editar de una liga.
 * Autor: Uriel Infante
 */

$(function() {

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

    $("#eliminar_jornadas").click(function() {
        $("#dialog_eliminar").dialog("open");
    });
});