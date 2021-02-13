/**
 * Load interactions with the header elements
 */
(function ($) {
    $.fn.dropdown = function () {
        this.each(function () {
            let dropdown = $(this);
            dropdown.find('.button').unbind('click');
            dropdown.find('.button').click(function () {
                dropdown.toggleClass('active');
            });
        });
    }

    $(document).ready(() => {
        $('.dropdown').dropdown();
    });
})(jQuery);

/**
 * Load a start and end date checker
 */
(function ($) {
    $.fn.dateChecker = function () {
        this.each(function () {
            let start_date = $(this).find('.start_date');
            let end_date = $(this).find('.end_date');

            if (start_date.length > 0 && end_date.length > 0) {
                start_date.change(() => {
                    end_date.attr('min', start_date.val());
                });
                end_date.change(() => {
                    start_date.attr('max', end_date.val());
                });
            }
        });
    }

    $(document).ready(() => {
        $('.date-checker').dateChecker();
    });
})(jQuery);

/**
 * Change a boolean property of an entity configured with BooleableBehavior
 */
(function ($) {
    $.fn.checkbox = function () {
        this.unbind('click');
        this.click(function () {
            let checkbox = $(this);
            AjaxStorage.register('boolean');
            const id = checkbox.data('id');
            const controller = checkbox.data('controller');
            const field = checkbox.data('field');
            const lang = typeof checkbox.data('lang') != 'undefined' ? checkbox.data('lang') : false;
            const plugin = typeof checkbox.data('plugin') != 'undefined' ? checkbox.data('plugin') : false;

            let url_post = controller + '/change-boolean/' + id + '/' + field;
            if (plugin !== false) {
                url_post = plugin + '/' + url_post;
            }
            if (lang !== false) {
                url_post += '/' + lang;
            }
            url_post = ADMIN_PATH + url_post;

            $.post(url_post)
                .done(function (data, status, response) {
                    checkbox.toggleClass("checked");
                })
                .fail(function (response, status, error) {
                    Notification.show(response.responseJSON.status, response.responseJSON.message);
                })
                .always(function (response, status, error) {
                    AjaxStorage.unregister('boolean');
                });
        });
    }

    $(document).ready(() => {
        $(".boolean .check").checkbox();
    });
})(jQuery);

/**
 * Tabs
 */
(function ($) {
    $.fn.tabs = function () {
        this.each(function () {
            let tabs_header = $(this).find('.tabs-header');
            let tabs_content = $(this).find('.tabs-content');
            let first_tab = tabs_header.find('.tab:first');
            first_tab.addClass('current');
            let first_content = tabs_content.find('.tab[data-tab=' + first_tab.data().tab + ']');
            first_content.addClass('current');

            tabs_header.find('.tab').unbind('click');
            tabs_header.find('.tab').click(function () {
                let current_tab = tabs_header.find('.tab.current');
                let current_content = tabs_content.find('.tab[data-tab=' + current_tab.data().tab + ']');
                let next_tab = $(this);
                if (next_tab.hasClass('current')) {
                    return;
                }
                let next_content = tabs_content.find('.tab[data-tab=' + next_tab.data().tab + ']');

                current_tab.removeClass('current');
                current_content.removeClass('current');
                next_tab.addClass('current');
                next_content.addClass('current');
            });
        });
    }

    $(document).ready(() => {
        $(".tabs").tabs();
    });
})(jQuery);

/**
 * Load Google Maps to a map-canvas and the interaction to calculate
 * the coordinates based on a address
 */
(function ($) {
    $.fn.addressFinder = function () {
        this.each(function () {
            let address = $(this);
            address.find('.map-canvas').mapsLoader({
                'latitude': address.find('.latitude').val(),
                'longitude': address.find('.longitude').val(),
                'draggableMarker': true,
                'zoom': 15
            });

            address.find('.address-search').unbind('click');
            address.find('.address-search').click(function () {
                let addr = address.find('.addr').val();
                let city = address.find('.city').val();
                let region = address.find('.region').val();
                let country = address.find('.country').val();

                let full_address = addr != '' ? addr : '';
                full_address += city != '' ? ', ' + city : '';
                full_address += region != '' ? ', ' + region : '';
                full_address += country != '' ? ', ' + country : '';

                if (addr == '' ||
                    addr == 'undefined') {
                    address.find('.map-canvas').mapsLoader({});
                } else {
                    address.find('.map-canvas').mapsLoader({
                        'address': full_address,
                        'draggableMarker': true,
                        'zoom': 15
                    });
                }
            });
        });
    }
    $(document).ready(() => {
        $('.address').addressFinder();
    });
})(jQuery);

/**
 * Load draggable elements to allow to sort them with drag and drop
 */
(function ($) {
    $.fn.draggable = function () {
        this.each(function () {
            let draggable = $(this);
            draggable.find('.elements').sortable({
                containment: draggable,
                axis: 'y',
                placeholder: 'ui-placeholder',
                update: function (event, ui) {
                    let sortable = $(this);
                    let sort_events = [];
                    let start_index = 1;

                    if (typeof sortable.data('sort-start') != 'undefined') {
                        start_index = parseInt(sortable.data('sort-start'));
                    }

                    AjaxStorage.register("change_sort");
                    sortable.children().each(function () {
                        let row = $(this);
                        const controller = row.data('controller');
                        const id = row.data('id');
                        const sort_element = row.data('sort-element');
                        const sort_field = row.data('sort-field');
                        const index = start_index + row.index();
                        const old_index = row.find("." + sort_element).html().trim();

                        if (index != old_index) {
                            let url_post = controller + "/change-sort/" + id + "/" + index;
                            if (typeof sort_field !== "undefined") {
                                url_post += "/" + sort_field;
                            }
                            if (row.data().plugin) {
                                url_post = ADMIN_PATH + row.data().plugin + "/" + url_post;
                            } else {
                                url_post = ADMIN_PATH + url_post;
                            }

                            let sort_event = $.post(url_post)
                                .done(function (data, status, response) {
                                    row.find('.' + sort_element).html(index);
                                });

                            sort_events.push(sort_event);
                        }
                    });

                    $.when(...sort_events)
                        .fail(function (response, status, error) {
                            Notification.show(response.responseJSON.status, response.responseJSON.message);
                        })
                        .always(function (response, status, error) {
                            AjaxStorage.unregister('change_sort');
                        });
                }
            });
        });
    }
    $(document).ready(() => {
        $('.draggable').draggable();
    });
})(jQuery);

/**
 * Load the code editor
 */
(function ($) {
    $.fn.codeEditor = function (mode) {
        let editor = this;
        mode = mode != 'undefined' && mode != '' ? mode : 'text/html';

        CodeMirror.fromTextArea(editor[0], {
            mode: mode,
            extraKeys: { "Ctrl-Space": "autocomplete" },
            styleActiveLine: true,
            indentUnit: 4,
            lineNumbers: true,
            lineWrapping: true,
            showTrailingSpace: true,
            matchTags: { bothTags: true },
            autoCloseTags: true,
            gutters: ["CodeMirror-lint-markers"],
            lint: true,
            autoRefresh: true
        });
    }

    $(document).ready(() => {
        $('.codeeditor').each(function () {
            $(this).codeEditor({
                mode: $(this).data('mode')
            });
        });
    });
})(jQuery);

/**
 * Load collapsable blocks
 */
(function ($) {
    $.fn.collapsable = function () {
        this.each(function () {
            let collapsable = $(this);
            let collapse_header = collapsable.find('.collapse-header');

            if (collapsable.hasClass('active')) {
                collapsable.children('.collapse').css('overflow', 'visible');
            }

            let timeout = false;
            collapse_header.unbind('click');
            collapse_header.click(function () {
                collapsable.toggleClass('active');
                if (collapsable.hasClass('active')) {
                    timeout = setTimeout(() => {
                        collapsable.children('.collapse').css('overflow', 'visible');
                    }, 200);
                } else {
                    clearTimeout(timeout);
                    collapsable.children('.collapse').css('overflow', 'hidden');
                }
            });
        });
    };

    $(document).ready(() => {
        $('.collapsable').collapsable();
    });
})(jQuery);

(function ($) {
    $.fn.form = function (options) {
        let form = this;

        const settings = $.extend({
            colors: []
        }, options);

        initialize();
        function initialize() {
            initCollapsable();
            initSelect();
            initInputs();
            initAdvancedEditor();
        }

        /**
         * Load collapsable form blocks
         */
        function initCollapsable() {
            $('.collapsable').collapsable();
        }

        /**
         * Load a Select2 select element
         */
        function initSelect() {
            //Select 2 integration
            form.find('select').select2({
                width: '100%'
            });

            let color_template = (element) => {
                if (typeof settings.colors[element.id] == 'undefined') {
                    return $('<span class="color-text">' + element.text + '</span>');
                }
                return $('<span class="color-block" style="background-color: ' + settings.colors[element.id] + '"></span><span class="color-text">' + element.text + '</span>');
            };
            form.find('select.color').select2({
                templateResult: color_template,
                templateSelection: color_template
            });
        }

        /**
         * Load the different input events
         */
        function initInputs() {
            form.find(".input").each(function () {
                // Remove the helper if not needed
                let help = $(this).find(".help");
                if (help.find('.info').length > 0) {
                    if (help.find('.info > div').html().trim() == '') {
                        help.remove();
                    }
                }

                // Update the current letter count
                let max = $(this).find(".max");
                let max_number = parseInt(max.data("max"));

                if (!isNaN(max_number)) {
                    let input = $(this).find("input, textarea");
                    updateLetterCount(input, max);

                    input.keyup(function () {
                        updateLetterCount(input, max)
                    });
                }
            });

            /**
             * Update the element letter count
             *
             * @param  object  element the DOM element
             * @param  integer max     the max letters permitted
             */
            function updateLetterCount(element, max) {
                let max_number = parseInt(max.data().max);
                let strlength = element.val().length;

                let nleft = max_number - strlength;
                let max_class = "green";

                if (nleft <= 10 && nleft > 0) {
                    max_class = "yellow";
                } else if (nleft <= 0) {
                    max_class = "red";
                }
                max.removeClass().addClass('max').addClass(max_class);
                max.html(nleft);
            }
        }

        /**
         * Load TinyMCE textarea editors
         */
        function initAdvancedEditor() {
            tinymce.remove();

            initStandardEditor();
            initHeaderEditor();

            $("#bg-color").change(function (e) {
                for (let i = 0; i < tinymce.editors.length; i++) {
                    tinymce.get(i).contentDocument.body.style.backgroundColor = COLORS[$("#bg-color").val()];
                }
            });

            /**
             * Load a TinyMCE editor with standard configuration
             */
            function initStandardEditor() {
                tinymce.init({
                    selector: '.texteditor',
                    height: 400,
                    oninit: "setPlainText",
                    plugins: 'code link autosave image lists paste textcolor template',
                    toolbar: 'undo redo | cut copy paste | styleselect template | bold italic underline strikethrough | forecolor | link | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent superscript | removeformat code',
                    menubar: false,
                    convert_urls: false,
                    style_formats_merge: false,
                    init_instance_callback: function (editor) {
                        if ($(editor.targetElm).hasClass('little')) {
                            editor.theme.resizeTo("100%", 150);
                        }
                    }
                });
            }

            /**
             * Load a TinyMCE editor with header specific configuration
             */
            function initHeaderEditor() {
                tinymce.init({
                    selector: '.headereditor',
                    height: 400,
                    oninit: "setPlainText",
                    plugins: 'code link autosave image paste textcolor template',
                    toolbar: 'undo redo | cut copy paste | styleselect template | forecolor | link | alignleft aligncenter alignright alignjustify | removeformat code',
                    menubar: false,
                    convert_urls: false,
                    style_formats_merge: false,
                    init_instance_callback: function (editor) {
                        if ($(editor.targetElm).hasClass('little')) {
                            editor.theme.resizeTo("100%", 150);
                        }
                        editor.getBody().style.backgroundColor = COLORS[$("#bg-color").val()];
                    }
                });
            }
        }
    }

    $(document).ready(() => {
        $('form').form();
    });
})(jQuery);


/*******************************************************
 * UTILITY CLASSES
 ******************************************************/

/**
 * Class to store configuration variables
 */
(function () {
    class Configure {
        static storage = [];

        /**
         * Write a value in the Configure storage
         * @param {string} key the key of the value to write
         * @param {*} value the value to store
         */
        static write(key, value) {
            this.storage[key] = value;
        }

        /**
         * Read a value from the Configure storage
         * @param {string} key the key of the value to read
         */
        static read(key) {
            return this.storage[key];
        }
    }
    // register the class to access globally
    window.Configure = Configure;
})();

/**
 * Class to store the Ajax calls and show a loader until the unregister
 * method is called
 */
(function ($) {
    class AjaxStorage {
        static storage = [];

        /**
         * Register an AJAX action and show the loading screen
         *
         * @param {string} name the name of the action
         */
        static register(name) {
            this.storage.push(name);
            showPageLoader();
        }

        /**
         * Unregister an AJAX action and hide the loading screen
         * @param {string} name the name of the action
         */
        static unregister(name) {
            for (let i = 0; i < this.storage.length; i++) {
                if (this.storage[i] == name) {
                    // remove Ajax call from the stack
                    this.storage.splice(i, 1);
                    break;
                }
            }

            if (this.storage.length == 0) {
                hidePageLoader();
            }
        }
    }

    /**
     * Show the page loader
     *
     * @return void
     */
    function showPageLoader() {
        $('#page-loader').addClass('active');
    }
    /**
     * Hide the page loader
     *
     * @return void
     */
    function hidePageLoader() {
        $('#page-loader').removeClass('active');
    }

    // register the class to access globally
    window.AjaxStorage = AjaxStorage;
})(jQuery);

/**
 * Class to manage everything that is related with notifications
 */
(function ($) {
    class Notification {
        /**
         * Render a notification with the status of the operation
         *
         * @param  string status  notification type
         * @param  string message fo the notification
         *
         * @return void
         */
        static show(status, message) {
            let notification = getNotification();
            if (!notification.hasClass('hidden') &&
                !notification.hasClass(status)) {
                notification.addClass('hidden');
            }

            notification.find('.nt-content').html(message);
            notification.attr('class', 'notification hidden');
            notification.removeClass('hidden');
            notification.addClass(status);

            this.hide();
        }

        /**
         * Hide the notification after a number of miliseconds
         *
         * @param {int} time number of miliseconds after the notification hides
         *
         * @return void
         */
        static hide(time) {
            let notification = getNotification();
            time = typeof time != 'undefined' ? time : 6000;
            setTimeout(function () {
                notification.addClass('hidden');
            }, time);
        }
    }

    /**
     * Get the notification jQuery object
     *
     * @return {Object} the jQuery object of the notification
     */
    function getNotification() {
        return $('.notification');
    }

    /**
     * If there is a notification shown, call the hide method
     * to hide it after a number of seconds
     */
    $(document).ready(function () {
        Notification.hide();
    });

    // register the class to access globally
    window.Notification = Notification;
})(jQuery);
