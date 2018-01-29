$(function() {
    //Validación de formulario para nueva convocatoria
    $("form").validate({
        submitHandler: function(form) {
            form.submit();
        },
        ignore: [],
        rules: {
            nombre: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            codigo: {
                required: true,
                maxlength: 10,
                minlength: 5
            },
            avatar: {
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

    $.ajax({
        method: "GET",
        headers: {
            'Authorization': 'Client-ID 72c79f8aa136764'
        },
        url: 'https://api.imgur.com/3/album/O0peK/images',
        type: 'json',
        success: function (data) {
            for(i in data.data){
                $("#avatars").append(
                    ` <div class="selectable" style="padding: 10px; height: 50px; margin: 5px; display:inline;">
                        <img height="50" src= "${data.data[i].link}" >
                    </div>`
                )
            }
        }
    });

    $(document).on('click', '.selectable', function() {
        var imagen = $(this).find('img').attr('src');
        $(".selectable *").css('background', 'white');
        $(this).find("img").css('background', '#ff8000');
        $("#img_avatar").attr('src', imagen);
        $("#avatar").val(imagen);
    });
});