/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: PT (Portuguese; português)
 * Region: BR (Brazil)
 */

var cpfInvalido       = "&nbsp;<span style='color: #D14;'>Informe um CPF v&aacute;lido.</span>";
var dataInvalida      = "&nbsp;<span style='color: #D14;'>Informe uma data válida.</span>";
var emailIndisponivel = "&nbsp;<span style='color: #D14;'>Este endereço de email já está sendo usado.</span>";
var required          = "&nbsp;<span style='color: #D14;'>Este campo &eacute; obrigatório.</span>";
var senhasDiferentes  = "&nbsp;<span style='color: #D14;'>As senhas são diferentes!</span>";
var horarioIndisponivel  = "&nbsp;<span style='color: #D14;'>Este hor&aacute;rio n&atilde;o est&aacute; dispon&iacute;vel.</span>";
var numeroPositivo    = "&nbsp;<span style='color: #D14;'>Digite um n&uacute;mero positivo.</span>";

(function ($) {
	$.extend($.validator.messages, {
		required: required,
		remote: "&nbsp;<span style='color: #D14;'>Por favor, corrija este campo.</span>",
		email: "&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a um endere&ccedil;o eletr&ocirc;nico v&aacute;lido.</span>",
		url: "&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a uma URL v&aacute;lida.</span>",
		date: "&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a uma data v&aacute;lida.</span>",
		dateISO: "&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).</span>",
		number: "&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.</span>",
		digits: "&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a somente d&iacute;gitos.</span>",
		creditcard: "&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.</span>",
		equalTo: "&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a o mesmo valor novamente.</span>",
		accept: "&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.</span>",
		maxlength: $.validator.format("&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres.</span>"),
		minlength: $.validator.format("&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a ao menos {0} caracteres.</span>"),
		rangelength: $.validator.format("&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento.</span>"),
		range: $.validator.format("&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a um valor entre {0} e {1}.</span>"),
		max: $.validator.format("&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a um valor menor ou igual a {0}.</span>"),
		min: $.validator.format("&nbsp;<span style='color: #D14;'>Por favor, forne&ccedil;a um valor maior ou igual a {0}.</span>")
	});
}(jQuery));