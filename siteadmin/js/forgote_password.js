$(document).ready(function(){

$('#manage_form').validate({
          rules: {
            'email':{
                required:true,
                email:true,
                    remote: {
                    url:baseurl+"index.php/home/forgote_email_check",
                    type: "post",
                    }
                },
            'new_password' : {
              required: true,
            },
            'conf_password' : {
              required: true,
              equalTo: "#new_password",
            },
            
          },
          messages: {
        
          'email':{required:"Email address can not be blank",email:"Enter valid email address",remote: 'Your email address is not exits'},
            
            'new_password' : {
                required: 'Please enter New password.',
                //remote: 'Passwords is match.'
            },
            'conf_password' : {
                required: 'Please enter confirm password.',
                equalTo: "Your password and confirm password is not match.",
        },
       
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
      
    });});