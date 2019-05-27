<?php

namespace Kollarovic\ShoppingCart;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;


class CartControl extends Control
{

	/** @var array */
	public $onClickUpdate;

	/** @var array */
	public $onClickNext;

	/** @var array */
	public $onClickContinue;

    /** @var ITranslator */
    private $translator;

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


	function __construct(Cart $cart, ITranslator $translator = null)
	{
		$this->cart = $cart;
		$this->translator = $translator;
		$this->templateFile = __DIR__ . '/templates/CartControl.latte';
	}


    public function getTemplateFile()
    {
        return $this->templateFile;
    }


    public function setTemplateFile($templateFile)
    {
        $this->templateFile = $templateFile;
        return $this;
    }


    public function getCart()
    {
        return $this->cart;
    }


    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }


    public function isShowImage()
    {
        return $this->showImage;
    }


    public function setShowImage($showImage)
    {
        $this->showImage = $showImage;
        return $this;
    }


    public function isShowName()
    {
        return $this->showName;
    }


    public function setShowName($showName)
    {
        $this->showName = $showName;
        return $this;
    }


    public function isShowPrice()
    {
        return $this->showPrice;
    }


    public function setShowPrice($showPrice)
    {
        $this->showPrice = $showPrice;
        return $this;
    }


    public function isShowQuantity()
    {
        return $this->showQuantity;
    }


    public function setShowQuantity($showQuantity)
    {
        $this->showQuantity = $showQuantity;
        return $this;
    }


    public function isShowTotalWithoutVat()
    {
        return $this->showTotalWithoutVat;
    }


    public function setShowTotalWithoutVat($showTotalWithoutVat)
    {
        $this->showTotalWithoutVat = $showTotalWithoutVat;
        return $this;
    }


    public function isShowTotal()
    {
        return $this->showTotal;
    }


    public function setShowTotal($showTotal)
    {
        $this->showTotal = $showTotal;
        return $this;
    }


    public function isShowDelete()
    {
        return $this->showDelete;
    }


    public function setShowDelete($showDelete)
    {
        $this->showDelete = $showDelete;
        return $this;
    }


    public function getImageWidth()
    {
        return $this->imageWidth;
    }


    public function setImageWidth($imageWidth)
    {
        $this->imageWidth = $imageWidth;
        return $this;
    }


    public function getImageHeight()
    {
        return $this->imageHeight;
    }


    public function setImageHeight($imageHeight)
    {
        $this->imageHeight = $imageHeight;
        return $this;
    }


    public function getNextName()
    {
        return $this->nextName;
    }


    public function setNextName($nextName)
    {
        $this->nextName = $nextName;
        return $this;
    }


    public function getContinueName()
    {
        return $this->continueName;
    }


    public function setContinueName($continueName)
    {
        $this->continueName = $continueName;
        return $this;
    }


    public function getUpdateName()
    {
        return $this->updateName;
    }


    public function setUpdateName($updateName)
    {
        $this->updateName = $updateName;
        return $this;
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
		if ($this->translator) {
            $template->addFilter('translate', [$this->translator, 'translate']);
        } else {
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