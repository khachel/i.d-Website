var notification = '<p class="notification"></p>',
	working;

function userInfoEdit() {

	/*-------------------------------------*\
		Visual form actions
	\*-------------------------------------*/

	// Switch between the edit button and the save + cancel buttons
	function toggleFormButtons() {
		jQuery('.user__info__edit--edit, .user__info__edit--save, .user__info__edit--cancel')
			.toggleClass('hidden');
	}

	// Make the form editable
	function formEditable() {
		toggleFormButtons();
		jQuery('.user__info__input--editable')
			.attr('readonly', false)
			.each(function () {
				var jQuerythis = jQuery(this);
				jQuerythis.attr('data-before', jQuerythis.val());
			});
	}

	// Cancel the form editing
	function formCanceled() {
		jQuery('.user__info__input--editable').each(function () {
			var jQuerythis = jQuery(this);
			jQuerythis.val(jQuerythis.attr('data-before')).removeClass('invalid');
		});

		formReadonly();
	}

	// Make the form read only
	function formReadonly() {
		jQuery('.user__info')
			.removeClass('user__info--working')
			.find('.user__info__input--editable')
				.attr('readonly', true);
		toggleFormButtons();
	}

	// Apply defined functions to events (a.k.a. make the buttons work)
	jQuery('.user__info__edit--edit').on('click', formEditable);
	jQuery('.user__info__edit--cancel').on('click', formCanceled);





	/*-------------------------------------*\
		Form communication with the back-end
	\*-------------------------------------*/

	function formDone(response, status, error) {
		jQuery('.' + working).removeClass(working + '--working');

		// Throw the response to the fail function if we got no success
		if (!response['success']) {
			formFail(response, status, error);
			return;
		}

		// Otherwise tell it’s done...
		var noti = jQuery(notification)
			.addClass('notification--success')
			.text(response['message'])
			.prependTo('.' + working);

		// ...and revert the form to read only or empty the password fields
		if (working === 'user__info') {
			formReadonly();
		} else if (working === 'user__password') {
			jQuery('.' + working).children('input').each(function() {
				jQuery(this).val('');
			});
		}
	}

	function formFail(response, status, error) {
		// Tell the user something failed
		if (response['message'] !== undefined) {
			userError = response['message'];
		} else if (response.readyState === 4) {
			userError = 'There has been an error, please try again later or send this to someone at ID: ' + error;
		} else if (response.readyState === 0) {
			userError = 'There has been a network error, are you still connected to the internet?';
		} else {
			userError = 'There has been an error we don’t even understand :/';
		}
		jQuery(notification)
			.addClass('notification--failed')
			.text(userError)
			.prependTo('.' + working);
	}

	function listenToForm(formClass) {
		jQuery(document).on('submit' , 'form.' + formClass, function(e) {

			e.preventDefault();

			jQuery('.notification').remove();
			jQuery(this).addClass(formClass + '--working');
			working = formClass;

			var formData = new FormData(jQuery(this)[0]);

			jQuery.ajax({
				url: ajaxurl,
				type: 'POST',
				dataType: 'JSON',
				data: formData,
				processData: false,
				contentType: false
			})
			.done(formDone)
			.fail(formFail);
		});
	}

	listenToForm('user__info');
	listenToForm('user__password');

}
