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