/*
Theme FAQ
 */
jQuery(document).ready(function () {

    jQuery(document).on('click', '.theme-faq-accordion-title', function () {
        jQuery(this).closest('.theme-faq-accordion-block').toggleClass('active');
        jQuery(this).closest('.theme-faq-accordion-block').find('.theme-faq-accordion-deck').slideToggle(200).toggleClass('active');
        jQuery(this).closest('.theme-faq-accordion-block').find('span.active').removeClass('active').siblings().addClass('active');
    });

});

/*
Theme Form
 */
//jQuery('.theme-form .theme-form-submit').prop('disabled', true);

function validateEmail(email) {

    let re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    return re.test(String(email).toLowerCase());

}

jQuery(document).on('keyup', '.theme-form .theme_form_field_email', function () {

    let email = jQuery(this).val();
    if (validateEmail(email)) {
        jQuery(this).closest('label').removeClass('requaired');
        jQuery(this).closest('.theme-form').find('.theme-form-submit').prop('disabled', false);
    } else {
        jQuery(this).closest('label').addClass('requaired');
        jQuery(this).closest('.theme-form').find('.theme-form-submit').prop('disabled', true);
    }

});

function validatePhone(phone) {

    let re = /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g;
    return re.test(String(phone).toLowerCase());

}

jQuery(document).on('keyup', '.theme-form .theme_form_field_phone', function () {

    let email = jQuery(this).val();
    if (validatePhone(email)) {
        jQuery(this).closest('label').removeClass('requaired');
        jQuery(this).closest('.theme-form').find('.theme-form-submit').prop('disabled', false);
    } else {
        jQuery(this).closest('label').addClass('requaired');
        jQuery(this).closest('.theme-form').find('.theme-form-submit').prop('disabled', true);
    }

});

jQuery(document).on('click', '.theme-form .theme-form-submit', function(e) {

    e.preventDefault();

    let form = jQuery(this).closest('.theme-form');

    let field_required = form.find('.field_required');

    var error = '';
    jQuery(field_required).each(function () {
        let val = jQuery(this).val();
        if(val == '') {
            jQuery(this).closest('label').addClass('requaired');
            error = 'error';
        }
    });

    if(error != 'error') {
        jQuery.ajax({
            type: "POST",
            url: ajax.url,
            data: {
                nonce: ajax.nonce,
                action: 'send_theme_form',
                data: jQuery(this).closest('.theme-form').serialize()
            },
            success: function (response) {
                form.closest('.theme-form-section').find('.theme-form-response').text(response);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                form.closest('.theme-form-section').find('.theme-form-response').text(response);
            },
        });
    }
    return false;

});