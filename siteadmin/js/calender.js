$(document).ready(function(){
$('#appoint_form').validate({
                 rules:{
                        status_change_comments:{required:true}, 
                        start_date:{required:true},
                        end_date:{required:true}, 
                        
                      },
                messages:{
                         status_change_comments:{required:"Note must not be  empty"},     
                         start_date:{required:"Start date name must not be  empty"},
                         end_date:{required:"Repetitive date name must not be  empty"},     
                         
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