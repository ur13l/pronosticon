/**
 * Archivo para la vista editar de una quiniela.
 * Autor: Uriel Infante
 */

$(function() {

    /**
     * Lógica de autocompletado para el input de agregar participante a la quiniela.
     * Este método desencadena el submit del formulario recargando la página 
     * al seleccionar un item.
     */
    $("#id_usuario_autocomplete").autocomplete({
        source: $("#_url").val() + "/usuarios/autocomplete?id_quiniela=" + $("#_id_quiniela").val(),
        minLength: 1,
        select: function(event, ui) {
            $("#id_usuario").val(ui.item.value);
            setTimeout(function () {
                $("#id_usuario_autocomplete").val(ui.item.label);
            }, 20); 
            $("#form_agregar_participante").submit();
        }
    });

    /**
     * Validación de formulario para bolsa.
     */
    $("#form_actualizar_bolsa").validate({
        submitHandler: function(form) {
            form.submit();
        },
        rules: {
            cantidad: {
                required: true
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