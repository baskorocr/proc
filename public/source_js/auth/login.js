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
						location.href=base_url+"/dashboard";	
					}else{
                  	 	$('.div_notif').show();
						$('#label_notif').html('<i class="fa fa-warning"> '+data.message+'</i>');
						$('#label_notif').html('<i class="fa fa-warning"> Please check username or password!</i>');
						$("#username").val("");
						$("#password").val("");
						// $("#username").attr("placeholder", "Username");
                    }
				},
				error: function( xhr, textStatus, error ){
					//console.log(xhr.responseJSON.message);
					// console.log(xhr.statusText);
					$('.div_notif').show();
					$('#label_notif').html('<i class="fa fa-warning"> Please check username or password!</i>');
					$("#username").val("");
					$("#password").val("");
					// $("#password").attr("placeholder", "Password");
				}
			});
	});  
  });