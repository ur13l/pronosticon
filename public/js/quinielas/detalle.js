$(function() {
    //Validación de formulario para nueva convocatoria
    $("form").validate({
        submitHandler: function(form) {
            form.submit();
        },
        rules: {
            nombre: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            codigo: {
                required: true,
                maxlength: 9,
                minlength: 9
            }
            
        },
        messages:{
            titulo: "Este campo es obligatorio",
            "fecha_inicio": "Este campo es obligatorio",
            "fecha_cierre": "Este campo es obligatorio",
            descripcion: "Este campo es obligatorio",
            imagen: "Este campo es obligatorio",
            documentos: "Este campo es obligatorio",
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
});