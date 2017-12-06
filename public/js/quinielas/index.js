/**
 * Método onReady: Se ejecuta cuando carga la página.
 */
$(function () {
    
    /**
     * Método para evitar el reemplazo de paginación por XHR
     */
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getQuinielas(page, $("#busqueda").val());

    });

    $("#busqueda").on("keyup paste change", function (e) {
        getQuinielas(1, $(this).val())
    }) 

});
    
var xhr;
function getQuinielas(page, q) {
    if (xhr) {
        xhr.abort();
    }
    xhr = $.ajax({
        url: $("#_url").val() + '/quinielas/buscar',
        data: {
            page: page,
            q: q
        }
    }).done(function (data) {
        $(".lista").html(data);
    });
}
