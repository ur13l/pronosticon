$(function() {

    $(".item-jornada").click(function(){ 
        var id_jornada = $(this).data('id'),
            id_participacion = $('#_id_participacion').val();
        $("#datos_jornada").html("<h5>Cargando...</h5>")
        $(".item-jornada").removeClass("selected");
        $(this).addClass("selected");
        $.ajax({
            url: $("#_url").val() + "/quinielas/datos_jornada",
            method: 'POST',
            data: {
                id_participacion: id_participacion,
                id_jornada: id_jornada,
                _token: $("#_token").val()
            },
            success:function (data) {
                $("#datos_jornada").html(data);
            }
        });
    });
});