$(function() {
    $("#form_contestar").validate({
        submitHandler: form => form.submit(),
        ignore: [],
        errorElement : 'div',
        errorPlacement: (error, element) => {
            $("#error_placement").show();
            $("#error_placement").html("Hay algunos errores en la captura de tu quiniela, revisa que todos los resultados sean correctos y envíalos nuevamente.")
            $(element).addClass('invalid');
            $(error).css('color', '#F44336 ');
            
        }
    });

    $('[name^="resultado_local"]').each(function() {
        $(this).rules('add', {
            required: true,
            maxlength: 2,
            digits: true,
        })
    });

    $('[name^="resultado_visita"]').each(function() {
        $(this).rules('add', {
            required: true,
            maxlength: 2,
            digits: true,
        })
    });
});