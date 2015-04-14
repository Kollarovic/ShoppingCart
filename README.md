Shopping Cart
=============

![Alt text](https://raw.githubusercontent.com/Kollarovic/AdminDemo/master/www/images/cart.png "Shopping Cart")


Live Demo
=============

[Live Demo](http://demo.kollarovic.sk/)

[Demo – source code](https://github.com/Kollarovic/AdminDemo)


Installation
=============

composer.json

```json
{
    "require":{
        "kollarovic/shopping-cart": "dev-master"
    }
}

```

config.neon

```yaml


extensions:
	cart: Kollarovic\ShoppingCart\DI\Extension
	thumbnail: Kollarovic\Thumbnail\DI\Extension

```

presenter

```php

namespace App\FrontendModule\Presenters;

use Kollarovic\ShoppingCart\Cart;
use Kollarovic\ShoppingCart\ICartControlFactory;
use Nette\Database\Context;


class CartPresenter extends BasePresenter
{

	/** @var Cart @inject */
	public $cart;

	/** @var ICartControlFactory @inject */
	public $cartControlFactory;

	/** @var Context @inject */
	public $database;


	public function actionAdd($id)
	{
		$product = $this->database->table('product')->get($id);

		if (!$product) $this->error();

		$this->cart->addItem($product->id, $product->price)
			->setName($product->name)
			->setImage($product->image)
			->setUnit($product->unit)
			->setVatRate($product->vat)
			->setLink('Product:default')
			->setLinkArgs($product->id);

		$this->redirect('default');
	}


	protected function createComponentCartControl()
	{
		$cartControl = $this->cartControlFactory->create();

		$cartControl->onClickContinue[] = function() {
			$this->redirect('Homepage:default');
		};

		$cartControl->onClickNext[] = function() {
			$this->redirect('Order:default');
		};
		return $cartControl;
	}

}

```

default.latte

```php

{control cartControl}


```

Optional settings
=============

config.neon

```yaml

cart:
	columns:
		image: yes
		name: yes
		price: no
		quantity: yes
		totalWithoutVat: yes
		total: yes
		delete: yes
	price:
		currency: €
		decimals: 2
		decimalPoint: ','
		thousandsSep: ' '
		priceFormat: '{price} {currency}'
	buttons:
		next: Checkout
		continue: Continue shopping
		update: Update
	image:
		width: 80
		height: 80
	

```

