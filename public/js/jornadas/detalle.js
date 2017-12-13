/**
 * Archivo para la vista de generar o editar una jornada.
 * Autor: Uriel Infante
 */

$(function() {

    $("#fecha_inicio, #fecha_fin").datepicker("option", "dateFormat", "dd/mm/yy");
    $("#fecha_inicio, #fecha_fin").datepicker();    
    $("#fecha_inicio, #fecha_fin").datepicker("option", "dateFormat", "dd/mm/yy");
    if($("#fecha_inicio").val()){
        $("#fecha_inicio").datepicker('setDate', moment($("#fecha_inicio").val(), 'DD/MM/YYYY').format('MM/DD/YYYY'));
    }

    if($("#fecha_fin").val()) {
        $("#fecha_fin").datepicker('setDate', moment($("#fecha_fin").val(), 'DD/MM/YYYY').format('MM/DD/YYYY'));        
    }

    jQuery.validator.addMethod("fechaMayorQue", function(value, element, params) {
        
        if (moment(value, 'DD/MM/YYYY') > moment($(params).val(),'DD/MM/YYYY')) {
            return true;
        } else {
            return false;
        }
        
    }, 'La fecha debe ser igual o posterior a la fecha de inicio.');
 

    //Validación de formulario para nueva quiniela
    $("#form_detalle").validate({
        submitHandler: function(form) {
            form.submit();
        },
        rules: {
            nombre: "required",
            id_liga: "required",
            fecha_inicio: "required",
            fecha_fin: {
                required:true,
                fechaMayorQue: "#fecha_inicio"
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

    $("#eliminar_jornada").click(function() {
        $("#dialog_eliminar").dialog("open");
    });
});