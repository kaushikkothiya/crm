$(document).ready(function(){
 get_city_area();
 $.validator.addMethod('check_country', function (value,element) { 
     return this.optional(element) || value != 0;   
    }, "Please select country");
 $.validator.addMethod('check_city', function (value,element) { 
     return this.optional(element) || value != 0;   
    }, "Please select city");
 
 $.validator.addMethod('check_city_area', function (value,element) { 
     return this.optional(element) || value != 0;   
    }, "Please select city area");
 $.validator.addMethod('check_property_category', function (value,element) { 
     return this.optional(element) || value != 0;   
    }, "Please select property category");
 
 $.validator.addMethod('check_furnished', function (value,element) { 
     return this.optional(element) || value != 0;   
    }, "Please select furnished type");
 // $.validator.addMethod('check_bedrooms', function (value,element) { 
 //     return this.optional(element) || value != 0;   
 //    }, "Please select bedrooms");
 
 // $.validator.addMethod('check_bathrooms', function (value,element) { 
 //     if(value!='0' || $('#property_category').val() =='9' || $('#property_category').val() =='10' || $('#property_category').val() =='11' || $('#property_category').val() =='12' || $('#property_category').val() =='16' ){
 //        return true;
 //    }else{
 //        return false;
 //    }
 //     //return this.optional(element) || value != 0;   
 //    }, "Please select bathrooms");

 $.validator.addMethod('check_type', function (value,element) { 
     return this.optional(element) || value != 0;   
    }, "Please select type");
$.validator.addMethod('check_agent_id', function (value,element) { 
     return this.optional(element) || value != 0;   
    }, "Please select agent");
//  $.validator.addMethod("check_short_desc", function (value, element) {
//   alert('asd');
// //var // = CKEDITOR.instances[element.id];
//   //_editor.updateElement();

// // var elValue = $(element).val();
// // if (elValue.length > 0) {
// // return true;
// // }
// // return false;
// }, "No data in editor");

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
                        lname:{
                          //noHTML: true,
                        },
                        email:{
                          email:true,
                        },
                        //  cname:{
                        //   noHTML: true,
                        // },
                        mobile_no:{
                          required:true,
                          number:true,
                        },
                        type:{
                          check_type:true
                        },
                        agent_id:{
                          check_agent_id:true
                        },  
                        address:{
                         // noHTML: true,
                          maxlength: 500
                        },
                        country_id:{
                          check_country:true
                           },
                        city_id:{
                              check_city:true
                              },
                        city_area_id:{
                              check_city_area:true
                              },
                        property_category:{
                              check_property_category:true
                              },
                        furnished_type:{
                              check_furnished:true
                              },
                        rent_price:{
                          required:true,
                          number:true,
                         // maxlength:10
                        },
                        sale_price:{
                          required:true,
                          number:true,
                          //maxlength:10
                        },
                        size:{
                          required:true,
                          number:true,
                          //maxlength:10
                        },
                        // bedrooms:{
                        //         noHTML: true,
                        //         required: function (element) {
                       
                        //          if($('#property_category').val() =='5' || $('#property_category').val() =='9' || $('#property_category').val() =='10' || $('#property_category').val() =='11' || $('#property_category').val() =='12' || $('#property_category').val() =='16'){
                        //           return '';                               
                        //          }
                        //          else
                        //          {
                        //             return true;
                                    
                        //          }  
                        //       },
                        //         //required:true,
                        //        },
                        // bedrooms:{
                        //       check_bedrooms:true
                        //       },
                        // bathrooms:{
                        //       check_bathrooms:true
                        //       },
                        link_url:{
                              //required:true,
                              url: true,
                               required: function (element) {
                       
                                 if($('#link_url1').val() !='' || $('#link_url2').val() !=''){
                                  return '';                               
                                 }
                                 else
                                 {
                                    return true;
                                    
                                 }  
                              },
                              },
                        link_url1:{
                              url: true,
                              },
                        link_url2:{
                              url: true,
                              },      
                        reference_no:{
                         // noHTML: true,
                          required:true,
                          remote: {
                                url:baseurl+"index.php/home/property_ref_check",
                                type: "post",
                              data: {
                                  id: function() {
                                            var element = $(this);
                                            return  $('#property_id').val();
                                            }
                                          }
                                      }
                        },
                        image:{
                          required: function (element) {
                       
                                 if($('#property_id').val() !=''){
                                  return '';                               
                                 }
                                 else
                                 {
                                    return true;
                                    
                                 }  
                              },
                          accept: 'gif|jpg|png|jpeg',
                          //minlength:350,
                          //maxlength:350
                        },
                        
                        short_desc:{
                          //noHTML: true,
                          check_short_desc:true
                        },

                        //long_decs:{required:true},
                            
                        },
                messages:{
                         fname:{required:"First name or last name must not be empty"},
                         //lname:{required:"last name must not be  empty"},
                         email:{required:"Email must not be  empty",email:"Enter valid email"},
                         password:{required:"Password must not be  empty"},
                         mobile_no:{required:"Mobile number must not be empty",number:"Mobile number must contain only digits"},     
                          
                         address:{/*required:"address must not be  empty",*/maxlength:"address must not enter More then 500 characters"},     
                         rent_price:{required:"Rent Price must not be empty",number:"Rent Price  must contain only digits"},     
                         sale_price:{required:"Selling Price must not be empty",number:"Selling Price must contain only digits"},     
                         size:{required:"Size must not be empty",number:"Size must contain only digits"},     
                         reference_no:{required:"Reference Number must not be  empty",remote: 'Your reference number is already exits'},
                         image:{required:"Image must not be  empty",accept:"Only images with type jpg/png/gif are allowed"},
                         bedrooms:{required:"Please select bedrooms"},
                         //bathrooms:{required:"Please select bathrooms"},
                         link_url:{required:"URL link must not be  empty",url:"Please enter a valid URL Link1"},
                         link_url1:{url:"Please enter a valid URL Link2"},
                         link_url2:{url:"Please enter a valid URL Link3"},

                        // long_decs:{required:"Long Description must not be  empty"},
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
                  focusInvalid: false,
                   submitHandler: function (form) {

                    //alert("call");return false;
                     //event.preventDefault();$("#checkbox1").is(":checked")
                        /*if($("#type").val() =='1' || $("#type").val() =='3')
                        {
                          if(($("#checkbox1").is(":checked") ==true) && ($("#checkbox2").is(":checked") == true)){
                            form.submit();
                          }else{
                            alert('Please select both check box');
                          }
                        }else{
                          form.submit();
                        }*/

                        if($('#property_id').val() != 'NULL' && $('#property_id').val().length != 0){
                             var h = [];
                        //var myarr = $(this).attr('id').split("_");
                        //console.log(myarr);
                            $("ul.reorder-photos-list li").each(function() { 
                               var myarr = $(this).attr('id').split("_");
                               h.push(myarr[2]);  
                            });
                            $.ajax({
                              type: "POST",
                              //url: baseurl+"order_update.php",
                              url: baseurl+"home/order_update",
                              data: {ids: " " + h + "", "prop_id": $('#property_id').val()},
                              success: function(html) 
                              {
                                //form.submit();
                                if($("#type").val() =='1' || $("#type").val() =='3'){
                                  if(($("#checkbox1").is(":checked") ==true) && ($("#checkbox2").is(":checked") == true)){
                                    form.submit();
                                  }else if($("#checkbox1").is(":checked") ==false){
                                    alert(' Please agree to "Title Deeds / Planning Permission / Building Permission".');
                                  }else if($("#checkbox2").is(":checked") == false){
                                    alert(' Please agree to "Commission Agreement".');
                                  }
                                }
                                else{
                                  form.submit();
                                }
                              }
                              
                            }); 
                        }else{
                          if($("#type").val() =='1' || $("#type").val() =='3'){
                            if(($("#checkbox1").is(":checked") ==true) && ($("#checkbox2").is(":checked") == true)){
                              form.submit();
                            }else{
                              alert('Please select both check box');
                            }
                          }else{
                            form.submit();
                          }
                        }

                      

                        /*if($("#type").val() =='1' || $("#type").val() =='3'){
                          if(($("#checkbox1").is(":checked") ==true) && ($("#checkbox2").is(":checked") == true)){
                            form.submit();
                          }else{
                            alert('Please select both check box');
                          }
                        }*/

                        /*else{
                          var h = [];
                          $("ul.reorder-photos-list li").each(function() { 
                                var myarr = $(this).attr('id').split("_");
                               h.push(myarr[2]);  
                            });
                            $.ajax({
                              type: "POST",
                              url: baseurl+"home/order_update",
                              data: {ids: " " + h + "", "prop_id": $('#property_id').val()},
                              success: function(html) 
                              {
                                form.submit();
                              }
                              
                            }); 
                        }*/
                    
                    }               
            });


});
var counter = 0;
function multiurl()
{
     var div = document.createElement('DIV');
     div.innerHTML = '<div class="input-group add-course" id="removeneurl'+counter+'"><input id="link_url[]' + counter + '" name = "link_url[]" type="text" />' +'<span class="input-group-btn">'+
                     '<input id="Button' + counter + '" type="button" ' + 'value="Remove" onclick = "removeneurl(\'removeneurl' + counter + '\')" class="btn btn-danger"/></span></div>';
     document.getElementById("multiurladd").appendChild(div);
     counter++;

}
function removeneurl(div)

{
  $('#'+div).parent().remove();
}
var counter = 0;
function mulimage()
{
     var div = document.createElement('DIV');
     div.innerHTML = '<div class="input-group add-course" id="removephone'+counter+'"><input id="identity_check_img[]' + counter + '" name = "identity_check_img[]" type="file" class="file" />' +'<span class="input-group-btn">'+
                     '<input id="Button' + counter + '" type="button" ' + 'value="Remove" onclick = "Removephoneno(\'removephone' + counter + '\')" class="btn btn-danger"/></span></div>';
     document.getElementById("mulimage").appendChild(div);
     counter++;

}
function Removephoneno(div)

{
  $('#'+div).parent().remove();
}
function get_city_area()
 {  
   //alert($('#city_ar_id').val());
    $('#city_area_id').html('');
    $.ajax({
        type: "post",
        url:baseurl+"index.php/home/get_city_area",
        data: 'city_id=' +$("#city_id option:selected").val(),
        success: function(msg){

        var jason = $.parseJSON(msg);
        
        $('#city_area_id').append("<option value='0' selected='selected'>Select city area</option>");
        //cityAreaSelected = "<?php echo $user[0]->city_area; ?>";
        for (var i  in jason) 
        {
          if($('#city_ar_id').val() !='' && $('#city_ar_id').val() == jason[i].id){
              areaSelected = "selected='selected'";
          }else{
            areaSelected = "";
          }
          $('#city_area_id').append("<option value='"+jason[i].id+"' " + areaSelected+"> "+jason[i].title+'</option>');
          
        }
    }
         });
 }