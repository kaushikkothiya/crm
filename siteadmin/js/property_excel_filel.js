
$(document).ready(function(){
//alert($("#country_id").val());
$('#excel_form').validate({
                 rules:{
                        xls_files:{
                            required:true,
                            extension: "xls|xlsx"
                        }, 
                        },
                messages:{
                         xls_files:{required:"Please Upload Excel File",extension:"It allow only xls or xlsx file"},     
                         
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