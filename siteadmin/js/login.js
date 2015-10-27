
$(document).ready(function(){
//alert($("#country_id").val());
$('#manage_form').validate({
                 rules:{
                        username:{required:true}, 
                        password:{required:true},
                        },
                messages:{
                         username:{required:"Username must not be  empty"},     
                         password:{required:"Password must not be  empty"},
                         
                        },
                 showErrors:function(errorMap, errorList){
                     var error=[];
                     $.each(errorMap, function(key, value) {
                         error.push(value);
                     });

                     if(error.length!=0){
                      $.toast({
                                 heading: 'Following errros were found on the page',
                                 text:error,  
                                 icon: 'error'
                             });
                         }
                  },
                  onkeyup:false,
                  focusInvalid: false
               
            });
});