/**
 * Archivo para la vista de generar un nuevo usuario.
 * Autor: Uriel Infante
 */

$(function() {

    //Validación para hacer que la imagen aparezca.
    $('#imagen').change(function(){
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
            {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $('#img_container').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#img').attr('src', '/assets/no_preview.png');
        }
        });

        //Validación de formulario para nueva quiniela
        $("#form_detalle").validate({
            submitHandler: function(form) {
                form.submit();
            },
            rules: {
                nombre: "required",
                id_liga: "required",
                siglas: "required"
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

    $("#eliminar_equipo").click(function() {
        $("#dialog_eliminar").dialog("open");
    });
});