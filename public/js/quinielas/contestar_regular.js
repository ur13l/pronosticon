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

    if($("#tipo_quiniela").val() == "Regular") {

        //Se generan las validaciones cuando la quiniela permite marcador.
        if($("#permitir_marcador").val() == 1) {
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
        }

        //Se genera cuando la quiniela no permite marcador y es regular
        else {
            $(".selectable").click(function() {
                var key = $(this).data('key'),
                    ganador = $(this).data('ganador');
                $(this).siblings().css('background', 'white');
                $(this).siblings().find('*').css('color', '#ff9000');
                $(this).css('background', '#ff9000');
                $(this).find('*').css('color', 'white');
                $(`[name='id_equipo_ganador[${key}]']`).val(ganador);
                
            });

            $('[name^="id_equipo_ganador["]').each(function() {
                $(this).rules('add', {
                    required: true
                })
            });
        }
    }

    //Las quinielas survivor nunca permiten marcador
    else if($("#tipo_quiniela").val() == "Survivor") {
        $(".selectable").click(function() {
            var ganador = $(this).data('ganador'),
                id_partido = $(this).closest('.partido_editar').siblings('[name^="id_partido"]').val();
               
            $('.selectable').css('background', 'white');
            $('.selectable').find('*').css('color', '#ff9000');
            $(this).css('background', '#FF9000');
            $(this).find('*').css('color', 'white');
            $(`[name='id_equipo_ganador_survivor']`).val(ganador);
            $(`[name='id_partido_survivor']`).val(id_partido);
            
        });

       
        $("[name='id_equipo_ganador_survivor']").rules('add', {
            required: true
        });
    }




   
});