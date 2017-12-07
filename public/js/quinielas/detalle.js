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
        $("form").validate({
            submitHandler: function(form) {
                form.submit();
            },
            rules: {
                nombre: "required",
                imagen: "required",
                descripcion: "required",
                id_liga: "required",
                id_tipo_quiniela: "required",
                bolsa: "required"
                
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

    $("#id_tipo_quiniela").change(function() {
        var self = this;
        var value = $(self).val();
        if(value == 1) {
            $("#div_permitir_marcador").show();
            $("#div_reponches").hide();
        }
        else {
            $("#div_permitir_marcador").hide();
            $("#div_reponches").show();
        }
    });
});