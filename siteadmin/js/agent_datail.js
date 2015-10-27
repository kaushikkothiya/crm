$(document).ready(function(){
$('#manage_form').validate({
                 rules:{
                        agent:{required:true}, 
                        start_date:{required:true},
                        end_date:{required:true},
                    },    
                messages:{
                         agent:{required:"Please select agent"},     
                         start_date:{required:"Start date must not be  empty"},
                         end_date:{required:"End date must not be  empty"},
                         
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
                                url:baseurl+"index.php/inquiry/check_agent_free_selectdate",
                                data: 'id=' +$("#agent").val()+'&start_date=' +$("#start_date").val()+'&end_date=' +$("#end_date").val(),
                                success: function(msg){
                                    
                                    if(msg =='false'){
                                        alert('Agent not free');
                                        return false;
                                    }else{
                                        form.submit();

                                    }
                                   
                                }
                             });
                    },

            });

});