function validar(){
    $('#usuario_persona_nombres').
      attr('data-bvalidator', 'required,required');

    $('#usuario_persona_apellidos').
      attr('data-bvalidator', 'required,required');
      
    $('#usuario_username').
      attr('data-bvalidator', 'required,required');
      
    $('#usuario_password_first').
      attr('data-bvalidator', 'required,required');  
      
    $('#usuario_password_second').
        attr('data-bvalidator', 'equalto[usuario_password_first],required,required');
	
    $('#usuario_password_second').
            attr('data-bvalidator-msg', 'Passwords must match, typing again.');     
      
    $('#usuario_persona_telefono').
      attr('data-bvalidator', 'required,required');  
      
    $('#usuario_email').
      attr('data-bvalidator', 'required,required');  
        
    //Opciones del validador
    var optionsBootstrap2 = {
        classNamePrefix:   'bvalidator_bootstraprt_',
        offset:               {x:-27, y:-6},
        template:          '<div class="{errMsgClass}"><div class="bvalidator_bootstraprt_arrow"></div><div class="bvalidator_bootstraprt_cont1">{message}</div></div>',    
        templateCloseIcon:   '<div style="display:table"><div style="display:table-cell">{message}</div><div style="display:table-cell"><div class="{closeIconClass}">&#215;</div></div></div>'
    };
    //Validar el formulario
    $('form').bValidator(optionsBootstrap2);

}	

function validarCreacionUsuario(){
    $('#firstname').
      attr('data-bvalidator', 'required,required');

    $('#lastname').
      attr('data-bvalidator', 'required,required');
      
    $('#username').
      attr('data-bvalidator', 'required,required');
      
    $('#password').
      attr('data-bvalidator', 'required,required');  
      
    $('#re-password').
        attr('data-bvalidator', 'equalto[password],required,required');
	
    $('#re-password').
            attr('data-bvalidator-msg', 'Passwords must match, typing again.');     
      
//    $('#usuario_persona_telefono').
//      attr('data-bvalidator', 'required,required');  
//      
    $('#email').
      attr('data-bvalidator', 'required,required');  
        
    //Opciones del validador
    var optionsBootstrap2 = {
        classNamePrefix:   'bvalidator_bootstraprt_',
        offset:               {x:-27, y:-6},
        template:          '<div class="{errMsgClass}"><div class="bvalidator_bootstraprt_arrow"></div><div class="bvalidator_bootstraprt_cont1">{message}</div></div>',    
        templateCloseIcon:   '<div style="display:table"><div style="display:table-cell">{message}</div><div style="display:table-cell"><div class="{closeIconClass}">&#215;</div></div></div>'
    };
    //Validar el formulario
    $('form').bValidator(optionsBootstrap2);

}