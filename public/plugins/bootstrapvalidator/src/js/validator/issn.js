(function($) {
    $.fn.bootstrapValidator.i18n.issn = $.extend($.fn.bootstrapValidator.i18n.issn || {}, {
        'default': 'Please enter a valid ISSN number'
    });

    $.fn.bootstrapValidator.validators.issn = {
        /**
         * Validate ISSN (International Standard Serial Number)
         * Examples:
         * - Valid: 0378-5955, 0024-9319, 0032-1478
         * - Invalid: 0032-147X
         *
         * @see http://en.wikipedia.org/wiki/International_Standard_Serial_Number
         * @param {BootstrapValidator} validator The validator plugin instance
         * @param {jQuery} $field Field element
         * @param {Object} options Can consist of the following keys:
         * - message: The invalid message
         * @returns {Boolean}
         */
        validate: function(validator, $field, options) {
            var value = $field.val();
            if (value === '') {
                return true;
            }

            // Groups are separated by a hyphen or a space
            if (!/^\d{4}\-\d{3}[\dX]$/.test(value)) {
                return false;
            }

            // Replace all special characters except digits and X
            value = value.replace(/[^0-9X]/gi, '');
            var chars  = value.split(''),
                length = chars.length,
                sum    = 0;

            if (chars[7] === 'X') {
                chars[7] = 10;
            }
            for (var i = 0; i < length; i++) {
                sum += parseInt(chars[i], 10) * (8 - i);
            }
            return (sum % 11 === 0);
        }
    };
}(window.jQuery));
