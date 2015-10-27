$(document).ready(function(){
$('#manage_form').validate({
          rules: {
          'password' : {
          required : true,
          remote: {
                url:baseurl+"index.php/home/change_pass_check",
                type: "post",
                data: {
                  id: function() {
                  var element = $(this);
                  return  $('#change_pass_id').val();
                  }
                 }
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
        'password' : {
          required : 'Please enter current passwords.',
          remote: 'Your current passwords password is wrong'
        },
        'new_password' : {
          required: 'Please enter new password.',
          //remote: 'Passwords is match.'
         },
        'conf_password' : {
          required: 'Please enter confirm password.',
          equalTo: "Your password and confirm password is not match.",
        },
       
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
    });});