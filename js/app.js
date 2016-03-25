$().ready(function(){
    // si la url esta en register
    if(window.location.href.split('/')[3] == "#register")
        $('.forms_content').addClass('register');
    // else
    //     history.pushState({}, 'Registro', '/');
    
    // evento cuando los input de texto obtiene el foco
    $('.input-content input[type=text],.input-content input[type=password],.input-content input[type=email],.input-content input[type=number]').focusin(function(){
        $(this).parent().addClass('active');
    });
    
    // evento cuando los input de texto pierden el foco
    $('.input-content input[type=text],.input-content input[type=password],.input-content input[type=email],.input-content input[type=number]').focusout(function(){
        $(this).parent().removeClass('active');
        
        if($(this).val().length > 0)
            $(this).parent().addClass('with-data');
        else
            $(this).parent().removeClass('with-data');
    });
    
    // evento del boton que muestra el formulario de registro
    $('#btn_register').click(function(){
        $('.forms_content').addClass('register');
        history.pushState({}, 'Registro', '#register');
    });
    
    // evento del boton que muestra el formulario de login
    $('#btn_login').click(function(){
        $('.forms_content').removeClass('register');
        history.pushState({}, 'Registro', '/');
    });
    
    // evento que me elimina un usuario
    $('.delete_user').click(function(){
        var $key = $(this).attr('data-key'); // obtenemos la clave
        var $element = $(this);
        
        // mostramos el mensaje al usuario de confirmacion
        var option = confirm("¿Estas seguro de eliminar el usuario '"+ $key +"'?");
        
        if(option){
            $.ajax({
                url: 'lib/Functions.php',
                type: "POST",
                data: {
                    key: $key
                },
                success: function(res){
                    // si la respuesta es correcta actualizo la tabla
                    if(res == 1){
                        $element.parent().parent().slideUp("1000");
                        setTimeout(function(){ $element.parent().parent().remove(); },2000);
                    }else{
                        alert("ocurrio un error al intentar borrar el usuario '"+$key+"'");
                    }
                }
            });
        }
        
    });
});