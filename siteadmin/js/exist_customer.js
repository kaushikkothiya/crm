$(document).ready(function(){
    
    $(".create-new-client").on('click',function(){
        
        $("#frm-existing-client").attr('action',baseurl+'inquiry/new_client');
        $("#re_aquired").val($('#aquired:checked').val());
        $("#re_email_mobile").val($('#email_mobile').val());
        $("#frm-existing-client").submit();
        return;
    });
    
    $('#manage_form').validate({
        rules:{
            email_mobile:{required:true},                 
        },    
        messages:{
            email_mobile:{required:"Please enter email address or mobile phone of client"},     
        },
        showErrors:function(errorMap, errorList){
            $("div.overlay").hide();
            var error=[];
            $.each(errorMap, function(key, value) {
                error.push(value);
            });

            if(error.length!=0) {
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
                data: 'email_mobile=' +$("#email_mobile").val()+'&aquired=' +$("#aquired").val(),
                success: function(msg){
                   
                    if(msg =='false'){
                        alert('Customer Not Exist');
                        $('.create-new-client').removeClass('hidden');
                        return false;
                    }else if (msg =='inactive') {
                        alert('This customer is not active');
                        return false;
                    }else{
                        form.submit();
                    }
                }
            });
        },
    });
});