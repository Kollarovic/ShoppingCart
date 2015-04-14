Installation
-----------

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