/**
 * Método onReady: Se ejecuta cuando carga la página.
 */
$(function () {
    
    /**
     * Mpetodo para evitar el reemplazo de paginación por XHR
     */
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getUsuarios(page, $("#busqueda").val());

    });

    $("#busqueda").on("keyup paste change", function (e) {
        getUsuarios(1, $(this).val())
    }) 

});
    
    var xhr;
    function getUsuarios(page, q) {
        if (xhr) {
            xhr.abort();
        }
        xhr = $.ajax({
            url: $("#_url").val() + '/usuarios/buscar',
            data: {
                page: page,
                q: q
            }
        }).done(function (data) {
            $(".lista").html(data);
        });
    }
    