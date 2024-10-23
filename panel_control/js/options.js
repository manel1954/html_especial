jQuery('.contact-form,.contact-form-2').each(function () {
    "use strict";
    var t = jQuery(this);
    var t_result = jQuery(this).find('.form-send');
    var t_result_init_val = t_result.val();
    var validate_email = function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    };
    var t_timeout;
    t.submit(function (event) {
        event.preventDefault();
        var t_values = {};
        var t_values_items = t.find('input[name],textarea[name]');
        t_values_items.each(function () {
            t_values[this.name] = jQuery(this).val();
        });
        if (t_values['contact-name'] === '' || t_values['contact-email'] === '' || t_values['contact-message'] === '') {
            t_result.val('Por favor, rellena todos los campos.');
        } else
        if (!validate_email(t_values['contact-email']))
            t_result.val('Por favor, introduce un Mail correcto.');
        else
           // jQuery.post("php/contacts.php", t.serialize(), function (result) {



	

window.location.href = "example.php";




        clearTimeout(t_timeout);
        t_timeout = setTimeout(function () {
            t_result.val(t_result_init_val);
        }, 3000);
    });

});









jQuery('.contact-form1,.contact-form1-2').each(function () {
    "use strict";
    var t = jQuery(this);
    var t_result = jQuery(this).find('.form-send');
    var t_result_init_val = t_result.val();
    var validate_email = function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    };
    var t_timeout;
    t.submit(function (event) {
        event.preventDefault();
        var t_values = {};
        var t_values_items = t.find('input[name],textarea[name]');
        t_values_items.each(function () {
            t_values[this.name] = jQuery(this).val();
        });
        if (t_values['contact-name'] === '' || t_values['contact-email'] === '' || t_values['contact-message'] === '') {
            t_result.val('Por favor, rellena todos los campos.');
        } else
        if (!validate_email(t_values['contact-email']))
            t_result.val('Por favor, introduce un Mail correcto.');
        else
            jQuery.post("php/contacts1.php", t.serialize(), function (result) {
                t_result.val(result);
            });
        clearTimeout(t_timeout);
        t_timeout = setTimeout(function () {
            t_result.val(t_result_init_val);
        }, 3000);
    });

});










/* AS JavaScript [START] */
$Electra = {};

// Email object
$Electra.email = {};

// Forms
$Electra.form = {};
$Electra.form.errorClass = 's_error';

$Electra.form.subscribe = {};
$Electra.form.subscribe.id = '#newsletter';

jQuery(document).ready(function ($) {

    "use strict";

    /* SUBSCRIBE FORM */
    $($Electra.form.subscribe.id).on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var input = form.find('input[type="text"]');
        if ($Electra.form.validate(form)) {
            $.post('php/subscribe.php', form.serialize(), function (result) {
                input.attr('placeholder', result);
                input.val('');
            });
        } else {
            setTimeout(function () {
                input.removeClass($Electra.form.errorClass);
            }, 800);
        }
        return false;
    });
});







