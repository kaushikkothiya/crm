$(document).ready(function(){
//alert($("#country_id").val());

 $.validator.addMethod('check_country', function (value,element) { 
     return this.optional(element) || value != 0;   
    }, "Please select country");
 
 $.validator.addMethod('check_city', function (value,element) { 
     return this.optional(element) || value != 0;   
    }, "Please select city");

$('#manage_form').validate({
                 rules:{
                        fname:{
                          //required:true
                          //noHTML: true,
                          required: function (element) {
                       
                                 if($('#lname').val() !=''){
                                  return '';                               
                                 }
                                 else
                                 {
                                    return true;
                                    
                                 }  
                              },
                        }, 
                        //lname:{//noHTML: true},
                        email:{
                          required:true,
                          email:true,
                          remote: {
                                url:baseurl+"index.php/home/employee_email_check",
                                type: "post",
                              data: {
                                  id: function() {
                                            var element = $(this);
                                            return  $('#employee_id').val();
                                            }
                                          }
                                      }
                        },
                        password:{required: function (element) {
                         
                                 if($('#employee_id').val() !=''){
                                  return '';                               
                                 }
                                 else
                                 {
                                     return true;
                                 }  
                              }
                       },
                        country_id:{
                              check_country:true
                              },
                        city_id:{
                              check_city:true
                              },
                        mobile_no:{
                          required:true,
                          number:true,
                          //maxlength:10,
                          remote: {
                                url:baseurl+"index.php/home/employee_mobile_check",
                                type: "post",
                              data: { id: $('#employee_id').val(),country_code: $('#county_code').val()},

                               }
                        },
                        //country_id:{required:true},
                        //country_id:{required:true},
                       // email:{required:true},
                        },
                messages:{
                         fname:{required:"First name and last name can not be blank"},     
                         //lname:{required:"last name must not be  empty"},
                         email:{required:"Email address can not be blank",email:"Enter valid email address",remote: 'your email address is already exits'},
                         password:{required:"Password can not be blank"},
                         mobile_no:{required:"Mobile number can not be blank",number:"Mobile number enter only digits",remote: 'your Mobile number is already exit'},     
                         //country_id:{required:"Please Select Country"},                          
                         
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