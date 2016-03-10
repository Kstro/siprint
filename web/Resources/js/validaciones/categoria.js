function validar(){
    $('#categoria_nombre').
      attr('data-bvalidator', 'required,required');
      
    $('.costo-attr').
      attr('data-bvalidator', 'min[0.01], required,required');  
      
    $('.valor-atributo-0').
      attr('data-bvalidator', 'min[1], required, required');    
      
    $('.valor-atributo-0').
      attr('data-bvalidator-msg', 'Select at least one attribute');      
      
//    $('#categoria_file').
//      attr('data-bvalidator', 'required,required');
  
    var optionsBootstrap2 = {
        classNamePrefix:   'bvalidator_bootstraprt_',
        offset:               {x:-27, y:-6},
        template:          '<div class="{errMsgClass}"><div class="bvalidator_bootstraprt_arrow"></div><div class="bvalidator_bootstraprt_cont1">{message}</div></div>',    
        templateCloseIcon:   '<div style="display:table"><div style="display:table-cell">{message}</div><div style="display:table-cell"><div class="{closeIconClass}">&#215;</div></div></div>'
    };
    //Validar el formulario
    $('form').bValidator(optionsBootstrap2);

}	