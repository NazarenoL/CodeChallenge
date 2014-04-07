$(document).ready(function(){

	/**
	 * Add the Stripe validations to the normal jquery validation plugin
	 */
	
	//Card Number
	jQuery.validator.addMethod("cardNumber", function(value, element) {
	    return this.optional(element) || Stripe.card.validateCardNumber(value);
	}, "* Card Number should be valid. Don't use dashes to separate it.");

	//Card expiration date
	jQuery.validator.addMethod("cardExpires", function(value, element) {
	    return this.optional(element) || Stripe.card.validateExpiry($("#UserExpiration-month").val(), $("#UserExpiration-year").val() );
	}, "* The expiration date should be valid.");

	//Card CVC/CVV
	jQuery.validator.addMethod("cardCvc", function(value, element) {
	    return this.optional(element) || Stripe.card.validateCVC(value);
	}, "* The CVV2/CVC2 code should be valid.");
	

	$("form").validate({
		//Define a group as both are evaluated togethr
		 groups: {
            expiration : "data[User][expiration-month] data[User][expiration-year]",
        },
		rules: {
			"data[User][name]": {
				required: true,
			},
			"data[User][surname]": {
				required: true,
			},
			"data[User][email]": {
				required: true,
				email: true
			},
			"data[User][password]": {
				required: true
			},
			"data[password2]": {
				required: true,
				equalTo: "#UserPassword"
			},
			"data[User][card-number]": {
				required: true,
				cardNumber: true
			},
			"data[User][expiration-year]": {
				required: true,
				cardExpires: true
			},
			"data[User][expiration-month]": {
				required: true,
			},
			"data[User][cvv]": {
				required: true,
				cardCvc: true
			}
		},
		messages: {
			"data[User][name]": "Please specify your name",
			"data[User][surname]": "Please specify your surname",
			"data[User][email]": {
				required: "We need your email address to contact you",
				email: "Your email address must be in the format of name@domain.com"
			},
			"data[User][password]": {
				required: "Please specify your password"
			},
			"data[password2]": {
				required: "Please repeat your password",
				equalTo: "Both passwords must match"
			},
			"data[User][card-number]": {
				required: "Please insert a valid credit card number",
			}
		},
		submitHandler : function(form){
			$('#btnSubmit').attr('disabled', 'disabled');
			// Get the Stripe token:
		    Stripe.createToken({
		        number: $("#UserCard-number").val(),
		        cvc:  $("#UserCvv").val(),
		        exp_month:  $("#UserExpiration-month").val(),
		        exp_year:  $("#UserExpiration-year").val(),
		        name:  $("#UserName").val() + " " +  $("#UserSurname").val()
		    }, stripeResponseHandler);
		}
	});

	/**
	 * Prepare the function that receives the stripe response
	 */
	function stripeResponseHandler(status, response) {

		if (response.error) {
		    reportError(response.error.message);
		} else { // No errors, submit the form.
			// Get a reference to the form:
			var f = $("form");
			 
			// Get the token from the response:
			var token = response.id;
			 
			// Add the token to the form:
			f.append('<input type="hidden" name="data[User][stripeToken]" value="' + token + '" />');
			
			//Delete the name for all the card fields, so they don't get submitted to our server
			$(".card-info").removeAttr('name');
			
			// Submit the form:
			f.get(0).submit();
		}
	}

	/**
	 * Function to show errors on processing
	 */
	
	function reportError(msg) {
	 
	    // Show the error in the form:
	    $('#errors').text(msg).addClass("alert alert-danger").focus();
	 
	    // Re-enable the submit button:
	    $('#btnSubmit').prop('disabled', false);
	 
	    return false;
	 
	}

});