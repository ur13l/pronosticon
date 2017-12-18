/**
 * Archivo con la lógica de generar partidos para la jornada.
 */

 $(function() {

    /**
     * Funcionalidad de botón para agregar partido.
     */
    $("#agregar_partido").click(function(e) {
        var div = $("<div/>").addClass('row').addClass('partido_editar');
        var id = guid();
        div.attr('id', id);
        div.append($("#partido_base").html());
        $("#table_partidos").append(div);
        $("#empty_partidos").hide();
        $(`#${id} .select_equipo`).chosen();
    });

 });

