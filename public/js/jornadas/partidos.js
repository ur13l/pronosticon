/**
 * Archivo con la lógica de generar partidos para la jornada.
 */

 $(function() {

    $("#agregar_partido").click(function(e) {
        var div = $("<div/>");
        div.addClass('div_partido');
        div.append($("#partido_base").html());
        $("#table_partidos").append(div);
        $("#empty_partidos").hide();
    });
 });