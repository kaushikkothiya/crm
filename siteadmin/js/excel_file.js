
$(document).ready(function(){
//alert($("#country_id").val());
$('#inquireexcel_form').validate({
                 rules:{
                        inquire_xls_files:{
                            required:true,
                            extension: "xls|xlsx"
                        }, 
                        },
                messages:{
                         inquire_xls_files:{required:"Please Upload Excel File",extension:"It allow only xls or xlsx file"},     
                         
                        },
                 showErrors:function(errorMap, errorList){
                     $("div.overlay").hide();
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