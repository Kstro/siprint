function validar(){
    $('#promocion_nombre').
      attr('data-bvalidator', 'required,required');

    $('#promocion_codigo').
      attr('data-bvalidator', 'required,required');
      
    $('#promocion_porcentaje').
      attr('data-bvalidator', 'between[0:100],required,required');
  
    var optionsBootstrap2 = {
        classNamePrefix:   'bvalidator_bootstraprt_',
        offset:               {x:-27, y:-6},
        template:          '<div class="{errMsgClass}"><div class="bvalidator_bootstraprt_arrow"></div><div class="bvalidator_bootstraprt_cont1">{message}</div></div>',    
        templateCloseIcon:   '<div style="display:table"><div style="display:table-cell">{message}</div><div style="display:table-cell"><div class="{closeIconClass}">&#215;</div></div></div>'
    };
    //Validar el formulario
    $('form').bValidator(optionsBootstrap2);

}	
	

