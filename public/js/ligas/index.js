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
        getLigas(page, $("#busqueda").val());

    });

    $("#busqueda").on("keyup paste change", function (e) {
        getLigas(1, $(this).val())
    }) 

});
    
var xhr;
function getLigas(page, q) {
    if (xhr) {
        xhr.abort();
    }
    xhr = $.ajax({
        url: $("#_url").val() + '/ligas/buscar',
        data: {
            page: page,
            q: q
        }
    }).done(function (data) {
        $(".lista").html(data);
    });
}
