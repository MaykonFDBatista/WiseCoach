/*
 * Default messages for the jQuery validation plugin.
 * Language: EN
 */

var cpfInvalido       = '';
var dataInvalida      = "&nbsp;<span style='color: #D14;'>Enter a valid date.</span>";
var emailIndisponivel = "&nbsp;<span style='color: #D14;'>This email address is already in use.</span>";
var required          = "&nbsp;<span style='color: #D14;'>This field is required.</span>";
var senhasDiferentes  = "&nbsp;<span style='color: #D14;'>Passwords are different!</span>";
var numeroPositivo    = "&nbsp;<span style='color: #D14;'>Enter a positive number.</span>";
 
(function ($) {
	$.extend($.validator.messages, {
		required: required,
		remote: "&nbsp;<span style='color: #D14;'>Please fix this field.</span>",
		email: "&nbsp;<span style='color: #D14;'>Please enter a valid email address.</span>",
		url: "&nbsp;<span style='color: #D14;'>Please enter a valid URL.</span>",
		date: "&nbsp;<span style='color: #D14;'>Please enter a valid date.</span>",
		dateISO: "&nbsp;<span style='color: #D14;'>Please enter a valid date (ISO).</span>",
		dateDE: "&nbsp;<span style='color: #D14;'>Bitte geben Sie ein g?ltiges Datum ein.</span>",
		number: "&nbsp;<span style='color: #D14;'>Please enter a valid number.</span>",
		numberDE: "&nbsp;<span style='color: #D14;'>Bitte geben Sie eine Nummer ein.</span>",
		digits: "&nbsp;<span style='color: #D14;'>Please enter only digits</span>",
		creditcard: "&nbsp;<span style='color: #D14;'>Please enter a valid credit card.</span>",
		equalTo: "&nbsp;<span style='color: #D14;'>Please enter the same value again.</span>",
		accept: "&nbsp;<span style='color: #D14;'>Please enter a value with a valid extension.</span>",
		maxlength: $.validator.format("&nbsp;<span style='color: #D14;'>Please enter no more than {0} characters.</span>"),
		minlength: $.validator.format("&nbsp;<span style='color: #D14;'>Please enter at least {0} characters.</span>"),
		rangelength: $.validator.format("&nbsp;<span style='color: #D14;'>Please enter a value between {0} and {1} characters long.</span>"),
		range: $.validator.format("&nbsp;<span style='color: #D14;'>Please enter a value between {0} and {1}.</span>"),
		max: $.validator.format("&nbsp;<span style='color: #D14;'>Please enter a value less than or equal to {0}.</span>"),
		min: $.validator.format("&nbsp;<span style='color: #D14;'>Please enter a value greater than or equal to {0}.</span>")
	});
}(jQuery));

