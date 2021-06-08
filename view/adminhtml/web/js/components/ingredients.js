/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Ui/js/form/element/ui-select'
], function (Select) {
    'use strict';

    return Select.extend({
        /**
         * Check selected elements
         *
         * @returns {Boolean}
         */
        hasData: function () {
            if (!this.value()) {
                this.value([]);
            }
            if (typeof this.value() == 'string'){
                this.value(this.value().split(','));
            }
            return this.value() ? !!this.value().length : false;
        }
    });
});
