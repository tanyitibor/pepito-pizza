import {ShoppingCart} from '../ShoppingCart';

export class SideBarCart {
	shoppingCart: ShoppingCart;
	template: Template;

	constructor(shoppingCart: ShoppingCart) {
		this.shoppingCart = shoppingCart;
		this.template = new Template();
	}
	
	cartBody() :JQuery {
		return $('.shopping-cart .cart-body');
	}

	itemRow(item: IItem): JQuery {
		return this.cartBody().find('.' + this.itemClassName(item));
	}

	updateItem(item: IItem) {
		this.itemRow(item).find('.pieces span').text(item.pieces);
		this.updatePrice();
	}

	itemClassName(item: IItem): string {
		return 'cart-item-' + item.id + '-' + item.size;
	}

	createCartItem(item: IItem) {
		let row = $('<tr>').addClass(this.itemClassName(item));

		let nameItem = this.template.col('name', item.name);
		let sizeItem = this.template.col('size', item.size);
		let piecesItem = this.template.piecesCol(
			item,
			this.shoppingCart.incrementPieces.bind(this.shoppingCart)
		);
		let removeItem = this.template.col(
			'remove',
			this.template.removeButton(
				item,
				this.shoppingCart.removeItem.bind(this.shoppingCart))
			);
			
		row.append(nameItem, sizeItem, piecesItem, removeItem);

		this.cartBody().append(row);
	}

	removeItem(item: IItem) {
		this.cartBody()
			.find('.' + this.itemClassName(item))
			.remove();
			
		this.updatePrice();
	}

	updatePrice() {
		$('.total-price').text(this.shoppingCart.totalPrice());
	}
}

class Template
{
	col(className: string, html?: any): JQuery {
		return $('<td>', {
			'class': className,
			html: html
		});
	}

	removeButton(item: IItem, onClick: Function): JQuery {
		return $('<button>', {
			text: 'x',
			'class': 'remove-button btn btn-danger btn-sm',
			click: () => {
				onClick(item.id, item.size);
			}
		});
	}

	piecesButton(item: IItem, onClick: Function, increment = true): JQuery {
		return $('<button>', {
			text: increment ? '+' : '-',
			'class': 'btn btn-default btn-sm',
			click: () => {
				onClick(item.id, item.size, increment);
			}
		});
	}

	piecesCol(item: IItem, onClick: Function): JQuery {
		return this.col('pieces')
			.append(this.piecesButton(item, onClick, false))
			.append($('<span>').text(item.pieces))
			.append(this.piecesButton(item, onClick));
	}

}