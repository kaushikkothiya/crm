$(document).ready(function(){
$('#manage_form').validate({
                 rules:{
                        email_mobile:{required:true}, 
                        
                    },    
                messages:{
                         email_mobile:{required:"Please enter email or mobile phone of client"},     
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
                  focusInvalid: false,
                  
                  submitHandler: function (form) {
                     //event.preventDefault();
                          $.ajax({
                                type: "post",
                                url:baseurl+"index.php/inquiry/check_customer_exist",
                                data: 'email_mobile=' +$("#email_mobile").val(),
                                success: function(msg){
                                    
                                     if(msg =='false'){
                                         alert('Customer Not Exist');
                                         return false;
                                     }else{
                                         form.submit();

                                     }
                                   
                                }
                             });
                    },

            });

});