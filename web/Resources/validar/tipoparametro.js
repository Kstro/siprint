
function validarTipoParametro(){
$('.nombreTipoParametro').
        attr('data-bvalidator', 'required,required');

    //Opciones del validador
    var optionsRed = { 
        classNamePrefix: 'bvalidator_bootstraprt_', 
        lang: 'es',
        onAfterAllValidations: function(elements, formIsValid){
            
            // if validation failed or there are some visible error messages
            if(!formIsValid || $('#ex10errors > :visible').length){
                $('.btn-edit').addClass('btn-edit');//invalid
            }
            else{
                //alert('n');//valid
            }
        },
    };
 
    //Validar el formulario
    $('form').bValidator(optionsRed);
	
 }	
	