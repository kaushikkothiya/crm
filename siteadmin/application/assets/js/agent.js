function EmailFunction(){
  $(document).ready(function(){
    alert('dfsdf');
  } 
}

function product_att_check(id,attid, oldval){

	$(document).ready(function(){
		$.ajax({
        type:"POST",
        url:"product_sku.php",
       	data : {product:"productatt",sku : $('#'+id).val(), productid : $('#iProductId').val(), action : $('#action').val(), attid: attid},
        success: function (response) {
        	var response = response.trim()
        	if (response == "false") {
        		alert('This Product Code (SKU) is already exist please change it.');
        		$('#'+id).val(oldval);
        	}
        }
      });
	});
}
$(document).ready(function(){
 $("#vPSKU").change(function() {
  	$.ajax({
        type:"POST",
        url:"product_sku.php",
       	data : {product:"product",sku : $(this).val(), productid : $('#iProductId').val(), action : $('#action').val()},
        success: function (response) {
        	var response = response.trim()
        	if (response == "false") {
        		alert('This Product Code (SKU) is already exist please change it.');
        		$('#vPSKU').val($('#vPoldSKU').val());
        	}
        }
      });
});

});