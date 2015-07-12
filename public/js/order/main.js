'use strict';
/**
 * Main
 *
 * @constructor
 */
var Main = function() {
    /**
     * @type {Object}
     */
    this.container;

    /**
     * @type {String}
     */
    this.url;

    /**
     * @type {Object}
     */
    this.bNotify = null;

    /**
     * Set container
     *
     * @param {String} element
     * @returns {Main}
     */
    this.setContainer = function(element) {
        this.container = $(element);

        return this;
    };

    /**
     * Get container
     *
     * @returns {Object}
     */
    this.getContainer = function() {
        return this.container;
    };

    /**
     * Set url
     *
     * @param {String} url
     * @returns {Main}
     */
    this.setUrl = function(url) {
        this.url = url;

        return this;
    };

    /**
     * Get url
     *
     * @returns {String}
     */
    this.getUrl = function() {
        return this.url;
    };

    /**
     * init()
     *
     * @param {String} url
     * @param {String} element
     */
    this.init = function(url, element) {
        var _this = this;

        this.setUrl(url)
            .setContainer(element);

        /**
         * AJAX: Setup
         */
        $.ajaxSetup({ cache: false });

        /**
         * Action: Add to cart
         */
        $('[data-add-to-cart]', this.getContainer()).on('click', function(event) {
            event.preventDefault();

            _this.addToCart($(this).data('add-to-cart'));
        });

        /**
         * Action: Remove from cart
         */
        $('[data-remove-from-cart]', this.getContainer()).on('click', function(event) {
            event.preventDefault();

            $(this).closest('tr').remove();

            _this.removeFromCart($(this).data('remove-from-cart'));
            _this.recalculateOrderTotal();
        });
    };

    /**
     * Add to cart
     *
     * This method will add a product to the users shopping cart.
     * Also it will show a message to the user with the status.
     *
     * @param {Number} productId
     */
    this.addToCart = function(productId) {
        var _this = this;

        $.ajax({
            type: 'POST',
            url: _this.getUrl() + 'add-to-cart',
            dataType: 'json',
            data: {
                id: productId
            }
        }).done(function(data) {
            _this.processDataMessage(data);
        });
    };

    /**
     * Add to cart
     *
     * This method will remove a product from the user shopping cart.
     * Also it will show a message to the user with the status.
     *
     * @param {Number} productId
     */
    this.removeFromCart = function(productId) {
        var _this = this;

        $.ajax({
            type: 'POST',
            url: _this.getUrl() + 'remove-from-cart',
            dataType: 'json',
            data: {
                id: productId
            }
        }).done(function(data) {
            _this.processDataMessage(data);
        });
    };

    /**
     * Process data message
     *
     * @param {Array} data
     */
    this.processDataMessage = function(data) {
        try {
            if (false === data['status']) {
                this.popMessage(data['message'], 'warning');
            } else if (true === data['status']) {
                this.popMessage(data['message'], 'success');
            }
        } catch (e) {
            this.popMessage('An unexpected error has occurred.', 'error');
        }
    };

    /**
     * Recalculate the order total after a product is removed from the check out page.
     */
    this.recalculateOrderTotal = function() {
        var orderTotal = 0;
        $('[data-total-cost]').each(function(index) {
            console.log(parseFloat($(this).data('total-cost')));
            orderTotal += parseFloat($(this).data('total-cost'));
        });
        orderTotal = parseFloat(orderTotal).toFixed(2);

        if (orderTotal == 0.00) {
            $('[data-shopping-cart-table]', this.getContainer()).remove();
            $('[data-no-products]', this.getContainer()).fadeIn();
        }

        $('[data-order-total]').html(orderTotal);
    };

    /**
     * Pop message
     *
     * @param {String} message
     * @param {String} type
     */
    this.popMessage = function(message, type) {
        if (this.bNotify === null) {
            this.bNotify = $.notify({ message: message }, { type: type });
        } else {
            this.bNotify.update({ message: message }, { type: type });
        }
    };
};

(new Main()).init(_ACTIONS_URL, '.container');