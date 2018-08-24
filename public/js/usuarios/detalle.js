$(function() {
    //Validación de formulario para nueva convocatoria
    $("#form_usuario").validate({
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
            'Authorization': 'Client-ID 6b46d712c33128a'
        },
        url: 'https://api.imgur.com/3/album/tnhH8/images',
        type: 'json',
        success: function (data) {
            var tr = null;
            for(i in data.data){
                if(i%6 == 0) {
                    tr = $('<tr/>');
                    $("#avatars").append(tr);
                }
                tr.append(
                    `   <td><div  class="selectable" style="height:60px; width:60px; display:inline; text-align: center;">
                            <img height="50" width="50" src= "${data.data[i].link}" >
                        </div></td>
                    `
                )
            }
        }
    });
  $(document).on('click', '.selectable', function() {
        var imagen = $(this).find('img').attr('src');
        $(".selectable *").css('background', 'white');
        $(this).find("img").css('background', '#ff8000');
        $("#img_avatar").attr('src', imagen);
        $("#img_avatar").css('width', 300);
        $("#img_avatar").css('height', 300);
        $("#avatar").val(imagen);
    });

    $( "#dialog_eliminar" ).dialog({
        autoOpen: false,
        modal: true,
        show: {
          effect: "fade",
          duration: 200
        },
        hide: {
          effect: "explode",
          duration: 200
        },
        buttons: {
            "Eliminar": function() {
                $("#form_eliminar").submit();
                $( this ).dialog( "close" );
            },
            "Cancelar": function() {
              $( this ).dialog( "close" );
            }
          }
      });

    $("#eliminar_usuario").click(function() {
        $("#dialog_eliminar").dialog("open");
    });
});