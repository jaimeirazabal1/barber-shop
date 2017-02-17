/*
 *  Document   : readyLogin.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Login page
 */

var ReadyPasswordReset = function() {

    return {
        init: function() {
            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

            /* Login form - Initialize Validation */
            $('#form-password-reset').validate({
                errorClass: 'help-block animation-slideUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.help-block').remove();
                },
                rules: {
                    'password': {
                        required: true,
                        minlength: 8
                    },
                    'password_confirmation': {
                        required: true,
                        minlength: 8,
                        equalTo: '#password'
                    }
                },
                messages: {
                    'password': {
                        required: 'El campo contraseña es obligatorio.',
                        minlength: 'Su contraseña debe tener al menos 8 caracteres de longitud.'
                    },
                    'password_confirmation': {
                        required: 'El campo confirmar contraseña es obligatorio.',
                        minlength: 'Su contraseña debe tener al menos 8 caracteres de longitud.',
                        equalTo: 'Los campos de contraseña no coinciden'
                    }
                }
            });
        }
    };
}();