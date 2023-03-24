$(document).ready(function () {
	var base_url = location.origin;
	$("#formSubmit").submit(function(e) {	
		e.preventDefault();
			var urls =  $(this).attr('data-action');
			$.ajax({
				url: urls,
				method: 'POST',
				data: new FormData(this),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success : function(data) {
					if(data.type==="success"){
						location.href=base_url+"/blank";	
					}else{
                  	 	$('.div_notif').show();
						$('#label_notif').html('<i class="fa fa-warning"> '+data.message+'</i>');
                    }
				},
				error: function( xhr, textStatus, error ){
					//console.log(xhr.responseJSON.message);
					// console.log(xhr.statusText);
					$('.div_notif').show();
					$('#label_notif').html('<i class="fa fa-warning"> Please check username or password!</i>');\
					$("#username").val(null);
					$("#password").val(null);
					$("#password").attr("placeholder", "Type your answer here");
				}
			});
	});  
  });