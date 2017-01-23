import {SideBarCart} from 'Modules/SideBarCart'
import {Checkout} from 'Modules/Checkout'

export class ShoppingCart {
	items: Array<IItem>;
	sideBar: SideBarCart;
	checkout: Checkout;

	constructor() {
		this.items = Cookies.getJSON('cartItems') || [];
		this.sideBar = new SideBarCart(this);
		this.checkout = new Checkout(this);

		for(let item of this.items) {
			this.sideBar.createCartItem(item);
		}
		this.sideBar.updatePrice();
	}

	addItem(id: number, size: number) {
		let oldItem = this.getItem(id, size);
		if(oldItem) {
			this.incrementPieces(id, size);
		} else {
			let item = {
				id: id,
				name: $('.pizza-item-' + id).find('.pizza-name').text().trim(),
				pieces: 1,
				size: size,
				price: parseInt($('.pizza-item-' + id)
								.find('.pizza-price-' + size)
								.text().trim())
			}
			
			this.addNewItem(item);
		}
	}

	addNewItem(item: IItem) {
		this.items.push(item);
		this.sideBar.createCartItem(item);
		this.updateCookies();
	}

	incrementPieces(id: number, size: number, increment = true) {
		let n = increment ? 1 : -1;
		let item = this.getItem(id, size);
		if(item.pieces + n <=0) {
			return;
		}
		item.pieces+= n;

		this.updateCookies();
		this.sideBar.updateItem(item);
	}

	getItem(id: number, size: number): IItem {
		let filtered = this.items.filter((item) => {
			return item.id == id && item.size == size;
		});

		return filtered[0] || null;
	}

	getItems(): Array<IItem> {
		return this.items;
	}

	updateCookies(){
		Cookies.set('cartItems', this.items, {expires: 1});
	}

	removeCookies() {
		Cookies.remove('cartItems');
	}

	removeItem(id: number, size: number) {
		this.items.some((item, index) => {
			if(item.id == id && item.size == size) {
				this.items.splice(index, 1);
				this.sideBar.removeItem(item);
				this.updateCookies();
			
				return true;
			}
		});
	}

	itemPrice(item: IItem): string {
		return item.pieces * item.price + ' Ft.';
	}

	totalPrice(): string {
		if(this.items.length === 0) return '0 Ft.';

		let total = 0;
		this.items.forEach((item) => {
			total+= item.pieces * item.price;
		})

		return total + ' Ft.';
	}
}

$(() => {
	window['shoppingCart'] = new ShoppingCart();
});