/*!
 * jquery.confirm
 *
 * @version 2.3.1
 *
 * @author My C-Labs
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @author Russel Vela
 * @author Marcus Schwarz <msspamfang@gmx.de>
 *
 * @license MIT
 * @url http://myclabs.github.io/jquery.confirm/
 */
(function ($) {

    /**
     * Confirm a link or a button
     * @param [options] {{title, text, confirm, cancel, confirmButton, cancelButton, post, confirmButtonClass}}
     */
    $.fn.confirm = function (options) {
        if (typeof options === 'undefined') {
            options = {};
        }

        this.click(function (e) {
            e.preventDefault();

            var newOptions = $.extend({
                button: $(this)
            }, options);

            $.confirm(newOptions, e);
        });

        return this;
    };    

    /**
     * Show a confirmation dialog
     * @param [options] {{title, text, confirm, cancel, confirmButton, cancelButton, post, confirmButtonClass}}
     * @param [e] {Event}
     */
    $.confirm = function (options, e) {
        // Do nothing when active confirm modal.
        if ($('.confirmation-modal').length > 0) {
            $('.confirmation-modal').remove();
        }

        // Parse options defined with "data-" attributes
        var dataOptions = {};
        if (options.button) {
            var dataOptionsMapping = {
                'title': 'title',
                'text': 'text',
                'confirm-button': 'confirmButton',
                'cancel-button': 'cancelButton',
                'confirm-button-class': 'confirmButtonClass',
                'cancel-button-class': 'cancelButtonClass'
            };
            $.each(dataOptionsMapping, function(attributeName, optionName) {
                var value = options.button.data(attributeName);
                if (value) {
                    dataOptions[optionName] = value;
                }
            });
        }

        // Default options
        var settings = $.extend({}, $.confirm.options, {
            confirm: function () {
                if (options.post) {
                    var url = e && (('string' === typeof e && e) || (e.currentTarget && e.currentTarget.attributes['href'] && e.currentTarget.attributes['href'].value));
                    if (url) {
                        if (options.post) {
                            var form = $('<form method="post" class="hide" action="' + url + '"></form>');
                            $(parent.document.body).append(form);
                            form.submit();
                        } else {
                            window.location = url;
                        }
                    }
                }
            },
            cancel: function (o) {
            },
            button: null
        }, dataOptions, options);

        // Modal
        var modalHeader = '';
        var modalFooter = '';
        var modalBody = '';
        var modalConfirmBtn = '';
        var modalCancelBtn = '';
        if (options.title != null) {
            modalHeader =
                '<div class=modal-header style="height:40px;">' +
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="position:absolute; top:11px; right:10px;">&times;</button>' +
                    '<h4 class="modal-title" style="position:absolute; top:8px;">' + settings.title + '</h4>' +
                '</div>';

            modalBody = '<div class="modal-body">' + settings.text + '</div>';
        }
        else {
            modalBody =
                '<div class="modal-body">' +
                    (options.confirmButton == null ? ('<button type="button" class="close" data-dismiss="modal" aria-label="true">&times;</button>') : ('')) +
                    settings.text +
                '</div>';
        }

        if (options.confirmButton != null) {
            if (options.cancelButton != null) {
                modalConfirmBtn =
                    '<button class="confirm btn btn-mini ' + settings.confirmButtonClass + '" type="button" data-dismiss="modal" style="height:30px;width:40px; padding:0px;position:absolute;bottom:6px;right:75px;">' +
                        settings.confirmButton +
                    '</button>';

                modalCancelBtn =
                    '<button class="cancel btn btn-mini ' + settings.cancelButtonClass + '" type="button" data-dismiss="modal" style=" height:30px;width:40px; padding:0px;position:absolute;bottom:6px;right:10px;margin-right:10px;">' +
                        settings.cancelButton +
                    '</button>';
            }
            else {
                modalConfirmBtn =
                    '<button class="confirm btn btn-mini ' + settings.confirmButtonClass + '" type="button" data-dismiss="modal" style="height:30px;width:40px; padding:0px;position:absolute;bottom:6px;right:10px;margin-right:10px;">' +
                        settings.confirmButton +
                    '</button>';
            }
        }

        if (options.controlButton) {
            modalFooter =
                '<div class="modal-footer" style="height:45px;">' +
                    modalConfirmBtn +
                    modalCancelBtn +
                '</div>';
        }

        var modalHTML =
                '<div class="confirmation-modal modal fade" tabindex="-1" role="dialog">' +
                    '<div class="modal-dialog" style="z-index:inherit;">' +
                        '<div class="modal-content">' +
                            modalHeader +
                            modalBody +
                            modalFooter +
                        '</div>' +
                    '</div>' +
                '</div>';

        
        var modal = $(modalHTML);

        switch (options.style) {
            case 'AlertWarning':
                {
                    modal.find('.modal-content').addClass('AlertWarning');
                    break;
                }
            case 'AlertSuccess':
                {
                    modal.find('.modal-content').addClass('AlertSuccess');
                    break;
                }
            case 'AlertError':
                {
                    modal.find('.modal-content').addClass('AlertError');
                    break;
                }
            default:
                {
                    break;
                }
        }

        modal.on('shown.bs.modal', function () {
            if ($(parent.document.body).find("#myAlert").length > 0) {
                $(parent.document.body).find("#myAlert").remove();
            }
        });
        modal.on('hidden.bs.modal', function () {
            if ($(parent.document.body).find("#myAlert").length > 0) {
                $(parent.document.body).find("#myAlert").remove();
            }
            modal.remove();
        });
        modal.find(".confirm").click(function () {
            settings.confirm(settings.button);
        });
        modal.find(".cancel").click(function () {
            settings.cancel(settings.button);
        });
        
        // Show the modal
        $(parent.document.body).append(modal);

        if (options.confirm != null)
            modal.modal({ backdrop: 'static', keyboard: false });           //点击确认框以外部分，确认框不会隐藏
        else
            modal.modal('show');                                            //点击提示框以外部分，提示框隐藏
    };

    /**
     * Globally definable rules
     */
    $.confirm.options = {
        text: "Are you sure?",
        title: "提示",
        confirmButton: "确定",
        cancelButton: "取消",
        style: null,
        controlButton: false,
        post: false,
        confirmButtonClass: "btn-primary",
        cancelButtonClass: "btn-default"
    }


    var o_html = '<div id="myAlert" hidden="hidden"></div>';
    var o_alert = null;

    myAlert = function (message, title) {
        var alertParams = {
            text: message,
            title: title,
            style: 'AlertSuccess',
        };

        ProcessAlert(alertParams);
    };

    myAlertWarning = function (message, title) {
        var alertParams = {
            text: message,
            title: title,
            style: 'AlertWarning',
        };

        ProcessAlert(alertParams);
    };

    myAlertError = function (message, title) {
        var alertParams = {
            text: message,
            title: title,
            style: 'AlertError',
        };

        ProcessAlert(alertParams);
    };

    myAlertSuccess = function (message, callback, title) {
        var alertParams = {
            text: message,
            title: title,
            style: 'AlertSuccess',
            controlButton: true,
            confirm: function (button) {
                if (callback != null)
                    callback();
            },
            confirmButton: "确定",
            confirmButtonClass: "btn-primary",
        };

        ProcessAlert(alertParams);
    };

    myConfirm = function (message, callback, title) {
        var alertParams = {
            text: message,
            title: title,
            controlButton: true,
            confirm: function (button) {
                if (callback != null)
                    callback();
            },
            confirmButton: "确定",
            cancelButton: "取消",
            confirmButtonClass: "btn-primary",
            cancelButtonClass: "btn-default"
        };

        ProcessAlert(alertParams);
    };

    function ProcessAlert(alertParams) {
        if ($(parent.document.body).find("#myAlert").length < 1) {
            $(parent.document.body).append($(o_html));
        }

        o_alert = $(parent.document.body).find("#myAlert");

        if (o_alert.length > 0 && alertParams!=null) {
            o_alert.confirm(alertParams);
            o_alert.click();
        }
    };
})(jQuery);