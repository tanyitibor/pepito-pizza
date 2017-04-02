define("Modules/SideBarCart", ["require", "exports"], function (require, exports) {
    "use strict";
    var SideBarCart = (function () {
        function SideBarCart(shoppingCart) {
            this.shoppingCart = shoppingCart;
            this.template = new Template();
        }
        SideBarCart.prototype.cartBody = function () {
            return $('.shopping-cart .cart-body');
        };
        SideBarCart.prototype.itemRow = function (item) {
            return this.cartBody().find('.' + this.itemClassName(item));
        };
        SideBarCart.prototype.updateItem = function (item) {
            this.itemRow(item).find('.pieces span').text(item.pieces);
            this.updatePrice();
        };
        SideBarCart.prototype.itemClassName = function (item) {
            return 'cart-item-' + item.id + '-' + item.size;
        };
        SideBarCart.prototype.createCartItem = function (item) {
            var row = $('<tr>').addClass(this.itemClassName(item));
            var nameItem = this.template.col('name', item.name);
            var sizeItem = this.template.col('size', item.size);
            var piecesItem = this.template.piecesCol(item, this.shoppingCart.incrementPieces.bind(this.shoppingCart));
            var removeItem = this.template.col('remove', this.template.removeButton(item, this.shoppingCart.removeItem.bind(this.shoppingCart)));
            row.append(nameItem, sizeItem, piecesItem, removeItem);
            this.cartBody().append(row);
            this.updatePrice();
        };
        SideBarCart.prototype.removeItem = function (item) {
            this.cartBody()
                .find('.' + this.itemClassName(item))
                .remove();
            this.updatePrice();
        };
        SideBarCart.prototype.updatePrice = function () {
            $('.total-price').text(this.shoppingCart.totalPrice());
        };
        return SideBarCart;
    }());
    exports.SideBarCart = SideBarCart;
    var Template = (function () {
        function Template() {
        }
        Template.prototype.col = function (className, html) {
            return $('<td>', {
                'class': className,
                html: html
            });
        };
        Template.prototype.removeButton = function (item, onClick) {
            return $('<button>', {
                text: 'x',
                'class': 'remove-button btn btn-danger btn-sm',
                click: function () {
                    onClick(item.id, item.size);
                }
            });
        };
        Template.prototype.piecesButton = function (item, onClick, increment) {
            if (increment === void 0) { increment = true; }
            return $('<button>', {
                text: increment ? '+' : '-',
                'class': 'btn btn-default btn-sm',
                click: function () {
                    onClick(item.id, item.size, increment);
                }
            });
        };
        Template.prototype.piecesCol = function (item, onClick) {
            return this.col('pieces')
                .append(this.piecesButton(item, onClick, false))
                .append($('<span>').text(item.pieces))
                .append(this.piecesButton(item, onClick));
        };
        return Template;
    }());
});
define("Modules/Checkout", ["require", "exports"], function (require, exports) {
    "use strict";
    var Checkout = (function () {
        function Checkout(shoppingCart) {
            this.shoppingCart = shoppingCart;
            this.template = new Template();
            $('#checkout-btn').click(this.show.bind(this));
            $('#send-order').click(this.sendOrder.bind(this));
        }
        Checkout.prototype.show = function () {
            var _this = this;
            this.orderBody().html('');
            this.shoppingCart.getItems().forEach(function (item) {
                _this.createOrderItem(item);
            });
        };
        Checkout.prototype.orderBody = function () {
            return $('.order-create .order-body');
        };
        Checkout.prototype.createOrder = function () {
            return {
                order: {
                    items: this.shoppingCart.getItems(),
                    comment: $('#order-comment').val().trim(),
                    address_id: $('#address').val(),
                }
            };
        };
        Checkout.prototype.createOrderItem = function (item) {
            var row = $('<tr>').addClass(this.itemClassName(item));
            var nameItem = this.template.col('name', item.name);
            var sizeItem = this.template.col('size', item.size);
            var piecesItem = this.template.col('pieces', item.pieces);
            var priceItem = this.template.col('price', this.shoppingCart.itemPrice(item));
            row.append(nameItem, sizeItem, piecesItem, priceItem);
            this.orderBody().append(row);
        };
        Checkout.prototype.itemClassName = function (item) {
            return 'order-item-' + item.id + '-' + item.size;
        };
        Checkout.prototype.sendOrder = function (items) {
            var _this = this;
            $.ajax({
                method: 'post',
                data: this.createOrder(),
                dataType: 'json',
            }).done(function (response) {
                if (response.redirect) {
                    _this.shoppingCart.removeCookies();
                    window.location.href = response.redirect;
                }
            });
        };
        return Checkout;
    }());
    exports.Checkout = Checkout;
    var Template = (function () {
        function Template() {
        }
        Template.prototype.col = function (className, text) {
            return $('<td>', {
                'class': className,
                'text': text
            });
        };
        return Template;
    }());
});
define("ShoppingCart", ["require", "exports", "Modules/SideBarCart", "Modules/Checkout"], function (require, exports, SideBarCart_1, Checkout_1) {
    "use strict";
    var ShoppingCart = (function () {
        function ShoppingCart() {
            this.items = Cookies.getJSON('cartItems') || [];
            this.sideBar = new SideBarCart_1.SideBarCart(this);
            this.checkout = new Checkout_1.Checkout(this);
            for (var _i = 0, _a = this.items; _i < _a.length; _i++) {
                var item = _a[_i];
                this.sideBar.createCartItem(item);
            }
            this.sideBar.updatePrice();
        }
        ShoppingCart.prototype.addItem = function (id, size) {
            var oldItem = this.getItem(id, size);
            if (oldItem) {
                this.incrementPieces(id, size);
            }
            else {
                var item = {
                    id: id,
                    name: $('.pizza-item-' + id).find('.pizza-name').text().trim(),
                    pieces: 1,
                    size: size,
                    price: parseInt($('.pizza-item-' + id)
                        .find('.pizza-price-' + size + ' .price')
                        .text().trim())
                };
                this.addNewItem(item);
            }
        };
        ShoppingCart.prototype.addNewItem = function (item) {
            this.items.push(item);
            this.sideBar.createCartItem(item);
            this.updateCookies();
        };
        ShoppingCart.prototype.incrementPieces = function (id, size, increment) {
            if (increment === void 0) { increment = true; }
            var n = increment ? 1 : -1;
            var item = this.getItem(id, size);
            if (item.pieces + n <= 0) {
                return;
            }
            item.pieces += n;
            this.updateCookies();
            this.sideBar.updateItem(item);
        };
        ShoppingCart.prototype.getItem = function (id, size) {
            var filtered = this.items.filter(function (item) {
                return item.id == id && item.size == size;
            });
            return filtered[0] || null;
        };
        ShoppingCart.prototype.getItems = function () {
            return this.items;
        };
        ShoppingCart.prototype.updateCookies = function () {
            Cookies.set('cartItems', this.items, { expires: 1 });
        };
        ShoppingCart.prototype.removeCookies = function () {
            Cookies.remove('cartItems');
        };
        ShoppingCart.prototype.removeItem = function (id, size) {
            var _this = this;
            this.items.some(function (item, index) {
                if (item.id == id && item.size == size) {
                    _this.items.splice(index, 1);
                    _this.sideBar.removeItem(item);
                    _this.updateCookies();
                    return true;
                }
            });
        };
        ShoppingCart.prototype.itemPrice = function (item) {
            return item.pieces * item.price + ' Ft.';
        };
        ShoppingCart.prototype.totalPrice = function () {
            if (this.items.length === 0)
                return '0 Ft.';
            var total = 0;
            this.items.forEach(function (item) {
                total += item.pieces * item.price;
            });
            return total + ' Ft.';
        };
        return ShoppingCart;
    }());
    exports.ShoppingCart = ShoppingCart;
    $(function () {
        window['shoppingCart'] = new ShoppingCart();
    });
});
