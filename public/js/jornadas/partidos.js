/**
 * Archivo con la lógica de generar partidos para la jornada.
 */

 $(function() {

    $(`.partido_mod select`).chosen();
    $(`.partido_mod .chosen-container`).addClass('twelve columns margin-responsive').css('width','');

    /**
     * Funcionalidad de botón para agregar partido.
     */
    $("#agregar_partido").click(function(e) {
        var div = $("<div/>").addClass('row').addClass('partido_editar');
        var id = guid();
        div.attr('id', id);
        div.append($("#partido_base").html());
        $("#table_partidos").append(div);
        $("#empty_partidos").hide();
        $(`#${id} select`).chosen();
        $(`#${id} .chosen-container`).addClass('twelve columns margin-responsive').css('width','');
        $("html, body").animate({ scrollTop: $(document).height() }, 300);
    });

    //Validación de formulario para nueva quiniela
    $("#form_partidos").validate({
        submitHandler: function(form) {
            form.submit();
        },
        rules: {
            "hora[]": "required"
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
                var id = $("#id_eliminar").val();
                var id_equipos_eliminar = JSON.parse($("#id_equipos_eliminar").val());
                id_equipos_eliminar.push(id);
                $("#id_equipos_eliminar").val(JSON.stringify(id_equipos_eliminar));
            },
            "Cancelar": function() {
              $( this ).dialog( "close" );
            }
          }
      });

    $(".quitar").click(function() {
        $("#dialog_eliminar").dialog("open");
        $("#id_eliminar").val($(this).data('id'));
    });

 });

