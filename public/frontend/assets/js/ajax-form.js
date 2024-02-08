$(function() {

	// Get the form.
	var form = $('#contact-form');

	// Get the messages div.
	var formMessages = $('.ajax-response');

	// Set up an event listener for the contact form.
	$(form).submit(function(e) {
		// Stop the browser from submitting the form.
		e.preventDefault();

		// Serialize the form data.
		var formData = $(form).serialize();

        // console.log(formData);

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			data: formData
		})
		.done(function(response) {
			// Make sure that the formMessages div has the 'success' class.
			$(formMessages).removeClass('error');
			$(formMessages).addClass('success');

            // console.log(response);
             if (response['success'] == true) {

                 // Set the message text.
                 $(formMessages).text(response['data']);

                 // Clear the form.
                 $('#contact-form #inputName').val('');
                 $('#contact-form #inputEmail').val('');
                 $('#contact-form #inputSubject').val('');
                 $('#contact-form #textareaMessage').val('');

                 $("#contact-form .errorName").text("");
                 $("#contact-form .errorEmail").text("");
                 $("#contact-form .errorMessage").text("");

                 $("#contact-form .ajax-response.success").show();

             } else {
                 if (response['data']['name']) {
                     $("#contact-form .errorName").text(response['data']['name']);
                 } else {
                     $("#contact-form .errorName").text("");
                 }

                 if (response['data']['email']) {
                     $("#contact-form .errorEmail").text(response['data']['email']);
                 } else {
                     $("#contact-form .errorEmail").text("");
                 }

                 if (response['data']['message']) {
                     $("#contact-form .errorMessage").text(response['data']['message']);
                 } else {
                     $("#contact-form .errorMessage").text("");
                 }

             }


		})
		.fail(function(data) {
			// Make sure that the formMessages div has the 'error' class.
			$(formMessages).removeClass('success');
			$(formMessages).addClass('error');

			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured and your message could not be sent.');
			}
		});
	});


    $(document).on('keyup','.formInput',function (){
        $("#contact-form .ajax-response.success").hide();
    })

});
