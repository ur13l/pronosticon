/**
 * Archivo con la lógica de generar partidos para la jornada.
 */

 $(function() {

    $(`.partido_mod select`).chosen();
    $(`.partido_mod .chosen-container`).addClass('twelve columns margin-responsive').css('width','');


    /**
     * Iteración para darle un id a cada partido para editar
     */
    $(".partido_mod").each((item, val) => {
        $(val).attr('id', guid());
    });
     
    /**
     * Funcionalidad de botón para agregar partido.
     */
    $("#agregar_partido").click(e => {
        let div = $("<div/>").addClass('row').addClass('partido_editar'),
             id = guid();
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
        submitHandler: form => form.submit(),
        rules: {
            "hora[]": "required"
        },     
        errorElement : 'div',
        errorPlacement: (error, element) => {
            let placement = $(element).data('error');
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
                let id = $("#id_eliminar").val(),
                    id_partidos_eliminar = JSON.parse($("#id_partidos_eliminar").val()),
                    elem = $("#" + $("#cont_eliminar").val());
                if(id) {
                    id_partidos_eliminar.push(id);
                    $("#id_partidos_eliminar").val(JSON.stringify(id_partidos_eliminar));    
                }
                elem.hide('slideUp', () => elem.remove()); 
                $( this ).dialog( "close" );
            },
            "Cancelar": function() {
              $( this ).dialog( "close" );
            }
          }
      });

    $(document).on('click', ".quitar", (event) => {
        $("#dialog_eliminar").dialog("open");
        $("#id_eliminar").val($(event.currentTarget).data('id'));
        $("#cont_eliminar").val($(event.currentTarget).parent().parent().attr('id'));
    });

 });

