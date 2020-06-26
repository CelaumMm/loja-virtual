(function ($) {
    "use strict";
    $(document).ready(function () {
        if (($(".main-navigation.onclick").length > 0) && $(window).width() > 991) {
            $.notify({
                // options
                message: 'The Dropdowns of the Main Menu, are now open with click on Parent Items. Click "Home" to checkout this behavior.'
            }, {
                // settings
                type: 'info',
                delay: 10000,
                offset: {
                    y: 150,
                    x: 20
                }
            });
        }

        if (!($(".main-navigation.animated").length > 0) && $(window).width() > 991 && $(".main-navigation").length > 0) {
            $.notify({
                // options
                message: 'The animations of main menu are disabled.'
            }, {
                // settings
                type: 'info',
                delay: 10000,
                offset: {
                    y: 150,
                    x: 20
                }
            }); // End Notify Plugin - The above code (from line 14) is used for demonstration purposes only

        }

        _datepicker();
        _mask();
        _money();
        _addressComplete();

    }); // End document ready

})(jQuery);

/** 01. Calendarios para o jquery-ui
 **************************************************************** **/
function _datepicker() {
    if (typeof jQuery('input').datepicker == 'function') {
        jQuery.datepicker.setDefaults(jQuery.datepicker.regional['pt-BR']);

        /* Ao adicionar essa classe no input, ele exibe um calendário */
        jQuery(".input-data").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            //minDate: new Date(),
            //maxDate: "+11M +30D"
        }).keypress(false).css({
            width: '120px'
        }).attr('autocomplete', 'off').bind('paste', function (e) {
            e.preventDefault();
        });

        /* Ao adicionar essa classe no input, ele exibe um calendário nao deixando selecionar antes da data atual */
        jQuery(".input-data-agora").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            minDate: new Date(),
            //maxDate: "+11M +30D"
        }).keypress(false).css({
            width: '120px'
        }).attr('autocomplete', 'off').bind('paste', function (e) {
            e.preventDefault();
        });

        jQuery(".input-data-nascimento").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            maxDate: "-1D",
            yearRange: 'c-100:c+10'
        }).keypress(false).css({
            width: '120px'
        }).attr('autocomplete', 'off').bind('paste', function (e) {
            e.preventDefault();
        });

        jQuery(".input-data-documento").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            maxDate: new Date(),
            yearRange: 'c-50:c+10'
        }).keypress(false).css({
            width: '120px'
        }).attr('autocomplete', 'off').bind('paste', function (e) {
            e.preventDefault();
        });

        //======== RANGE DE DATAS ==============
        /* Ao adicionar a classe input-data-inicio em um input e
         * input-data-fim no segundo input, evita que a data Fim seja menor que a data Inicio */
        jQuery(".input-data-inicio").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            onClose: function (selectedDate) {
                jQuery(".input-data-fim").datepicker("option", "minDate", selectedDate);

                /*
                 // Esse codigo aplica um limite de 3 anos entra a range de data
                 var dt = selectedDate.split("/");
                 var maxDate = dt[0] + "/" + dt[1] + "/" + (parseInt(dt[2]) + 3);
                 jQuery( ".input-data-fim" ).datepicker( "option", "maxDate", maxDate);
                 */
            }
        }).keypress(false).css({
            width: '120px'
        }).attr('autocomplete', 'off').bind('paste', function (e) {
            e.preventDefault();
        });

        jQuery(".input-data-fim").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            onClose: function (selectedDate) {
                jQuery(".input-data-inicio").datepicker("option", "maxDate", selectedDate);

                /*
                 // Esse codigo aplica um limite de 3 anos entra a range de data
                 var dt = selectedDate.split("/");
                 var minDate = dt[0] + "/" + dt[1] + "/" + (parseInt(dt[2]) - 3);
                 jQuery( ".input-data-inicio" ).datepicker( "option", "minDate", minDate );
                 */
            }
        }).keypress(false).css({
            width: '120px'
        }).attr('autocomplete', 'off').bind('paste', function (e) {
            e.preventDefault();
        });
        //======== RANGE DE DATAS ==============
    }
}

/** 02. Mascaras do jQuery-Mask-Plugin
 **************************************************************** **/
function _mask() {
    if (typeof jQuery('input').mask == 'function') {
        /*
         jQuery('.tel-cel, .telefone-celular').focusout(function () {
         var phone, element;
         element = jQuery(this);
         element.unmask();
         phone = element.val().replace(/\D/g, '');
         if (phone.length > 10) {
         element.mask("(99) 99999-999?9");
         } else {
         element.mask("(99) 9999-9999?9");
         }
         }).trigger('focusout');
         */

        var behavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
                options = {
                    onKeyPress: function (val, e, field, options) {
                        field.mask(behavior.apply({}, arguments), options);
                    }
                };

        jQuery('.tel-cel, .telefone-celular').mask(behavior, options);

        jQuery('.telefone, .tel').mask("(99) 9999-9999");
        jQuery('.celular, .cel').mask("(99) 99999-9999");
        jQuery(".cep").mask("99999-999");
        jQuery(".data").mask("99/99/9999");
        jQuery(".hora").mask("99:99");
        jQuery(".datahora").mask("99/99/9999 99:99");
        jQuery(".cnpj").mask("99.999.999/9999-99");

        jQuery(".cpf").mask("999.999.999-99", {reverse: false}).focusout(function () {
            var valor, element, erro = new String;

            element = jQuery(this);

            valor = element.val().replace(/\D/g, '');

            if (valor.length == 11) {
                if (valor == "00000000000" ||
                        valor == "11111111111" ||
                        valor == "22222222222" ||
                        valor == "33333333333" ||
                        valor == "44444444444" ||
                        valor == "55555555555" ||
                        valor == "66666666666" ||
                        valor == "77777777777" ||
                        valor == "88888888888" ||
                        valor == "99999999999") {

                    erro = "Número de CPF inválido: ";
                } else {
                    var a = [];
                    var b = new Number;
                    var c = 11;

                    for (i = 0; i < 11; i++) {
                        a[i] = valor.charAt(i);
                        if (i < 9)
                            b += (a[i] * --c);
                    }

                    if ((x = b % 11) < 2) {
                        a[9] = 0
                    } else {
                        a[9] = 11 - x
                    }
                    b = 0;
                    c = 11;

                    for (y = 0; y < 10; y++) {
                        b += (a[y] * c--);
                    }

                    if ((x = b % 11) < 2) {
                        a[10] = 0;
                    } else {
                        a[10] = 11 - x;
                    }

                    if ((valor.charAt(9) != a[9]) || (valor.charAt(10) != a[10])) {
                        erro = "Número de CPF inválido: ";

                    }
                }
            } else {
                if (valor.length == 0) {
                    return;
                } else {
                    erro = "Número de CPF inválido: ";
                }
            }

            if (erro.length > 0) {
                alert_erro(erro + element.val());
                element.val("");
            }
        });
    }
}

/** 03. Mascaras do jquery.maskmoney
 **************************************************************** **/
function _money() {
    if (typeof jQuery('input').maskMoney == 'function') {
        jQuery(".dinheiro-sigla, real-sigla").maskMoney({
            prefix: 'R$ ',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            precision: 2,
            affixesStay: true
        });

        jQuery(".dinheiro, real").maskMoney({
            prefix: 'R$ ',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            precision: 2,
            affixesStay: false
        });

        jQuery(".dinheiro-sem-sigla").maskMoney({
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            precision: 2,
            affixesStay: false
        });
    }
}

/** 04. Auto Completar Endereço
 **************************************************************** **/
function _addressComplete() {
    if (typeof jQuery('.cep').autocompleteAddress == 'function') {
        $(".cep").autocompleteAddress();
    }
}

/** 05. Alert do bootstrap3-dialog
 **************************************************************** **/
function alert_info(mensagem, milisegundos = false) {
    if (typeof BootstrapDialog == 'function') {
        var dialog = BootstrapDialog.show({
            title: "<h4><span class='fa fa-info-circle'></span> Informação</h4>",
            message: mensagem,
            draggable: true,
            type: BootstrapDialog.TYPE_INFO
        });

        if ($.isNumeric(milisegundos)) {
            setTimeout(function () {
                dialog.close();
            }, milisegundos);
        }
    } else {
        alert(mensagem);
}
}

function alert_info_redirecionar(mensagem, milisegundos, redirect) {

    if (typeof BootstrapDialog == 'function') {

        var dialog = BootstrapDialog.show({
            title: "<h4><span class='fa fa-info-circle'></span> Informação</h4>",
            message: mensagem,
            draggable: true,
            type: BootstrapDialog.TYPE_INFO,
            onhide: function (dialogRef) {
                location = redirect;
            }
        });

        if ($.isNumeric(milisegundos)) {
            setTimeout(function () {
                dialog.close();
            }, milisegundos);
        }

    } else {
        alert(mensagem);
        location = redirect;
    }
}

function alert_sucesso(mensagem, milisegundos = false) {
    if (typeof BootstrapDialog == 'function') {
        var dialog = BootstrapDialog.show({
            title: "<h4><span class='fa fa-check'></span> Sucesso</h4>",
            message: mensagem,
            draggable: true,
            type: BootstrapDialog.TYPE_SUCCESS
        });

        if ($.isNumeric(milisegundos)) {
            setTimeout(function () {
                dialog.close();
            }, milisegundos);
        }
    } else {
        alert(mensagem);
}
}

function alert_sucesso_redirecionar(mensagem, milisegundos, redirect) {

    if (typeof BootstrapDialog == 'function') {

        var dialog = BootstrapDialog.show({
            title: "<h4><span class='fa fa-check'></span> Sucesso</h4>",
            message: mensagem,
            draggable: true,
            type: BootstrapDialog.TYPE_SUCCESS,
            onhide: function (dialogRef) {
                location = redirect;
            }
        });

        if ($.isNumeric(milisegundos)) {
            setTimeout(function () {
                dialog.close();
            }, milisegundos);
        }

    } else {
        alert(mensagem);
        location = redirect;
    }
}

function alert_atencao(mensagem, milisegundos = false) {
    if (typeof BootstrapDialog == 'function') {
        var dialog = BootstrapDialog.show({
            title: "<h4><span class='fa fa-warning'></span> Atenção</h4>",
            message: mensagem,
            draggable: true,
            type: BootstrapDialog.TYPE_WARNING
        });

        if ($.isNumeric(milisegundos)) {
            setTimeout(function () {
                dialog.close();
            }, milisegundos);
        }
    } else {
        alert(mensagem);
}
}

function alert_atencao_redirecionar(mensagem, milisegundos, redirect) {
    if (typeof BootstrapDialog == 'function') {
        var dialog = BootstrapDialog.show({
            title: "<h4><span class='fa fa-warning'></span> Atenção</h4>",
            message: mensagem,
            draggable: true,
            type: BootstrapDialog.TYPE_WARNING,
            onhide: function (dialogRef) {
                location = redirect;
            }
        });

        if ($.isNumeric(milisegundos)) {
            setTimeout(function () {
                dialog.close();
            }, milisegundos);
        }

    } else {
        alert(mensagem);
        location = redirect;
    }
}

function alert_erro(mensagem, milisegundos = false) {
    if (typeof BootstrapDialog == 'function') {
        var dialog = BootstrapDialog.show({
            title: "<h4><span class='fa fa-times'></span> Ops! Algo deu errado.</h4>",
            message: mensagem,
            draggable: true,
            closable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            type: BootstrapDialog.TYPE_DANGER
        });

        if ($.isNumeric(milisegundos)) {
            setTimeout(function () {
                dialog.close();
            }, milisegundos);
        }
    } else {
        alert(mensagem);
}
}

function alert_erro_redirecionar(mensagem, milisegundos, redirect) {

    if (typeof BootstrapDialog == 'function') {

        var dialog = BootstrapDialog.show({
            title: "<h4><span class='fa fa-times'></span> Ops! Algo deu errado.</h4>",
            message: mensagem,
            draggable: true,
            type: BootstrapDialog.TYPE_DANGER,
            onhide: function (dialogRef) {
                location = redirect;
            }
        });

        if ($.isNumeric(milisegundos)) {
            setTimeout(function () {
                dialog.close();
            }, milisegundos);
        }

    } else {
        alert(mensagem);
        location = redirect;
    }
}

function empty(mixed_var) {
    var undef, key, i, len;
    var emptyValues = [undef, null, false, 0, '', '0'];

    for (i = 0, len = emptyValues.length; i < len; i++) {
        if (mixed_var === emptyValues[i]) {
            return true;
        }
    }

    if (typeof mixed_var === 'object') {
        for (key in mixed_var) {
            return false;
        }
        return true;
    }

    return false;
}