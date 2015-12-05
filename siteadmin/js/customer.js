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
                // required:true,
                required: function (element) {
                    if($('#lname').val() !='') {
                        return '';
                    } else {
                        return true;
                    }
                },
            },
            // lname:{
            //  // required:true,
            //   required: function (element) {

            //          if($('#fname').val() !=''){
            //           return '';
            //          }
            //          else
            //          {
            //             return true;

            //          }
            //       },

            // },
            email:{
                // required:true,
                email:true,
                remote: {
                    url:baseurl+"index.php/home/customer_email_check",
                    type: "post",
                    data: {
                        id: function() {
                            var element = $(this);
                            return  $('#customer_id').val();
                        }
                    }
                }
            },
            password:{required:true},
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
                    url:baseurl+"index.php/home/customer_mobile_check",
                    type: "post",
                    data: { id: $('#customer_id').val(),country_code: $('#county_code').val()},
                }
            },
            //country_id:{required:true},
            //country_id:{required:true},
            // email:{required:true},
        },
        messages:{
            fname:{required:"First name or last name must not be  empty"},
            //lname:{required:"last name or last name must not be  empty"},
            email:{/*required:"Email must not be  empty",*/ email:"Enter valid email",remote: 'your email is already exits'},
            password:{required:"Password must not be  empty"},
            mobile_no:{required:"Mobile number must not be empty",number:"Mobile number must contain only digits",remote: 'your Mobile number is already exit'},
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