import {ShoppingCart} from '../ShoppingCart'

export class Checkout {
	shoppingCart: ShoppingCart;
	template: Template;

	constructor(shoppingCart: ShoppingCart) {
		this.shoppingCart = shoppingCart;
		this.template = new Template();

		$('#checkout-btn').click(this.show.bind(this));
		$('#send-order').click(this.sendOrder.bind(this));
	}

	show() {
		this.orderBody().html('');
		this.shoppingCart.getItems().forEach((item) => {
			this.createOrderItem(item);
		});
	}

	orderBody() :JQuery {
		return $('.order-create .order-body');
	}

	createOrder() {
		return {
			order: {
				items: this.shoppingCart.getItems(),
				comment: $('#order-comment').val().trim(),
				address_id: $('#address').val(),
			}
		}
	}

	createOrderItem(item: IItem) {
		let row = $('<tr>').addClass(this.itemClassName(item));
		
		let nameItem = this.template.col('name', item.name);
		let sizeItem = this.template.col('size', item.size);
		let piecesItem = this.template.col('pieces', item.pieces);
		let priceItem = this.template.col('price', this.shoppingCart.itemPrice(item));
		row.append(nameItem, sizeItem, piecesItem, priceItem);

		this.orderBody().append(row);
	}

	itemClassName(item: IItem) {
		return 'order-item-' + item.id + '-' + item.size;
	}

	sendOrder(items: Array<IItem>) {
		$.ajax({
			method: 'post',
			data: this.createOrder(),
			dataType: 'json',
		}).done((response) => {
			if(response.redirect) {
				this.shoppingCart.removeCookies();
				window.location.href = response.redirect;
			}
		});
	}
}

class Template
{
	col(className: string, text: string | number) : JQuery
	{
		return $('<td>', {
			'class': className,
			'text': text
		});
	}
}