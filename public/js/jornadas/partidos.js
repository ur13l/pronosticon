/**
 * Archivo con la lógica de generar partidos para la jornada.
 */

 $(function() {

    /**
     * Funcionalidad de botón para agregar partido.
     */
    $("#agregar_partido").click(function(e) {
        var div = $("<div/>");
        div.addClass('div_partido');
        div.append($("#partido_base").html());
        $("#table_partidos").append(div);
        $("#empty_partidos").hide();
    });

   $(".select_equipo").selectric();
 });