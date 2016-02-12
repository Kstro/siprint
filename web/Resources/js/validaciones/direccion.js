function validar(){
    $('#direccion_name').
      attr('data-bvalidator', 'required,required');
    
    $('#direccion_phoneNumber').
      attr('data-bvalidator', 'required,required');
    
    $('#direccion_linea1').
      attr('data-bvalidator', 'required,required');
    
    $('#direccion_linea2').
      attr('data-bvalidator', 'required,required');
    
    $('#direccion_city').
      attr('data-bvalidator', 'required,required');
    
    $('#direccion_country').
      attr('data-bvalidator', 'required,required');
    
    $('#direccion_zipCode').
      attr('data-bvalidator', 'required,required');
    
    $('#direccion_state').
      attr('data-bvalidator', 'required,required');
    
    $('#direccion_securityAccessCode').
      attr('data-bvalidator', 'required,required');
    
    var optionsBootstrap2 = {
        classNamePrefix:   'bvalidator_bootstraprt_',
        offset:               {x:-27, y:-6},
        template:          '<div class="{errMsgClass}"><div class="bvalidator_bootstraprt_arrow"></div><div class="bvalidator_bootstraprt_cont1">{message}</div></div>',    
        templateCloseIcon:   '<div style="display:table"><div style="display:table-cell">{message}</div><div style="display:table-cell"><div class="{closeIconClass}">&#215;</div></div></div>'
    };
    //Validar el formulario
    $('form').bValidator(optionsBootstrap2);

}	