<?php

namespace Kollarovic\ShoppingCart;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;


/**
 * @method CartControl setShowImage($showImage)
 * @method CartControl setShowName($showName)
 * @method CartControl setShowPrice($showPrice)
 * @method CartControl setShowQuantity($showQuantity)
 * @method CartControl setShowTotalWithoutVat($showTotalWithoutVat)
 * @method CartControl setShowTotal($showTotal)
 * @method CartControl setShowDelete($showDelete)
 * @method CartControl setImageWidth(int $imageWidth)
 * @method CartControl setImageHeight(int $imageHeight)
 * @method CartControl setNextName(string $nextName)
 * @method CartControl setContinueName(string $continueName)
 * @method CartControl setUpdateName(string $updateName)
 *
 * @method boolean isShowImage($showImage)
 * @method boolean isShowName($showName)
 * @method boolean isShowPrice($showPrice)
 * @method boolean isShowQuantity($showQuantity)
 * @method boolean isShowTotalWithoutVat($showTotalWithoutVat)
 * @method boolean isShowTotal($showTotal)
 * @method boolean isShowDelete($showDelete)
 * @method int getImageWidth()
 * @method int getImageHeight()
 * @method string getNextName()
 * @method string getContinueName()
 * @method string getUpdateName()
 */
class CartControl extends Control
{

	/** @var array */
	public $onClickUpdate;

	/** @var array */
	public $onClickNext;

	/** @var array */
	public $onClickContinue;

	/** @var string */
	private $templateFile;

	/** @var Cart */
	private $cart;

	/** @var boolean */
	private $showImage = TRUE;

	/** @var boolean */
	private $showName = TRUE;

	/** @var boolean */
	private $showPrice = FALSE;

	/** @var boolean */
	private $showQuantity = TRUE;

	/** @var boolean */
	private $showTotalWithoutVat = TRUE;

	/** @var boolean */
	private $showTotal = TRUE;

	/** @var boolean */
	private $showDelete = TRUE;

	/** @var int */
	private $imageWidth = 80;

	/** @var int */
	private $imageHeight = 80;

	/** @var string */
	private $nextName = 'Checkout';

	/** @var string */
	private $continueName = 'Continue shopping';

	/** @var string */
	private $updateName = 'Update';


	function __construct(Cart $cart)
	{
		$this->cart = $cart;
		$this->templateFile = __DIR__ . '/templates/CartControl.latte';
	}


	public function render(array $options = [])
	{
		$this->template->setFile($this->templateFile);
		$this->template->showImage = $this->showImage;
		$this->template->showName = $this->showName;
		$this->template->showPrice = $this->showPrice;
		$this->template->showQuantity = $this->showQuantity;
		$this->template->showTotalWithoutVat = $this->showTotalWithoutVat;
		$this->template->showTotal = $this->showTotal;
		$this->template->showDelete = $this->showDelete;
		$this->template->imageWidth = $this->imageWidth;
		$this->template->imageHeight = $this->imageHeight;
		$this->template->nextName = $this->nextName;
		$this->template->continueName = $this->continueName;
		$this->template->updateName = $this->updateName;

		foreach ($options as $key => $value) {
			$this->template->$key = $value;
		}

		$this->template->cart = $this->cart;
		$this->template->render();
	}


	public function handleDelete($key)
	{
		$this->cart->delete($key);
		$this->presenter->redirect('this');
	}


	protected function createTemplate($class = NULL)
	{
		$template = parent::createTemplate($class);
		if (!array_key_exists('translate', $template->getLatte()->getFilters())) {
			$template->addFilter('translate', function($str){return $str;});
		}
		return $template;
	}


	protected function createComponentUpdateForm()
	{
		$form = new Form();
		foreach($this->cart->getItems() as $key => $item) {
			$form->addText($key)//->setType('number')
				->setType('number')
				->setValue($item->getQuantity())
				->setRequired();
		}

		$form->addSubmit('update', 'Update')->onClick[] = function($submit) {
			$this->updateCart($submit->form);
			$this->onClickUpdate($this->cart);
			$this->presenter->redirect('this');
		};

		$form->addSubmit('next', 'Checkout')->onClick[] = function($submit) {
			$this->updateCart($submit->form);
			$this->onClickNext($this->cart);
		};

		$form->addSubmit('continue', 'Continue shopping')->onClick[] = function($submit) {
			$this->updateCart($submit->form);
			$this->onClickContinue($this->cart);
		};

		return $form;
	}


	private function updateCart($form)
	{
		foreach($form->values as $key => $quantity) {
			$this->cart->update($key, (int)$quantity);
		}
	}

}