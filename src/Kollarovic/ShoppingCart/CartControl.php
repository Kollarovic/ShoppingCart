<?php

declare(strict_types=1);

namespace Kollarovic\ShoppingCart;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Localization\ITranslator;
use Nette\UnexpectedValueException;


class CartControl extends Control
{
	/** @var array */
	public $onClickUpdate;

	/** @var array */
	public $onClickNext;

	/** @var array */
	public $onClickContinue;

	/** @var ITranslator|null */
	private $translator;

	/** @var string */
	private $templateFile;

	/** @var Cart */
	private $cart;

	/** @var bool */
	private $showImage = true;

	/** @var bool */
	private $showName = true;

	/** @var bool */
	private $showPrice = false;

	/** @var bool */
	private $showQuantity = true;

	/** @var bool */
	private $showTotalWithoutVat = true;

	/** @var bool */
	private $showTotal = true;

	/** @var bool */
	private $showDelete = true;

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


	public function __construct(Cart $cart, ITranslator $translator = null)
	{
		$this->cart = $cart;
		$this->translator = $translator;
		$this->templateFile = __DIR__ . '/templates/CartControl.latte';
	}


	/********************************************************************************
	 *                                    Render                                    *
	 ********************************************************************************/


	public function getTemplateFile(): string
	{
		return $this->templateFile;
	}


	public function setTemplateFile(string $templateFile): self
	{
		$this->templateFile = $templateFile;
		return $this;
	}


	public function render(array $options = []): void
	{
		$template = $this->getTemplate();

		if (!$template instanceof Template) {
			throw new UnexpectedValueException();
		}

		if ($this->translator) {
			$template->setTranslator($this->translator);
		} else {
			$template->addFilter('translate', function ($str) {return $str;});
		}

		$template->setFile($this->templateFile);
		$template->showImage = $this->showImage;
		$template->showName = $this->showName;
		$template->showPrice = $this->showPrice;
		$template->showQuantity = $this->showQuantity;
		$template->showTotalWithoutVat = $this->showTotalWithoutVat;
		$template->showTotal = $this->showTotal;
		$template->showDelete = $this->showDelete;
		$template->imageWidth = $this->imageWidth;
		$template->imageHeight = $this->imageHeight;
		$template->nextName = $this->nextName;
		$template->continueName = $this->continueName;
		$template->updateName = $this->updateName;

		foreach ($options as $key => $value) {
			$template->$key = $value;
		}

		$template->cart = $this->cart;
		$template->render();
	}


	/********************************************************************************
	 *                                   Signals                                    *
	 ********************************************************************************/


	public function handleDelete(string $key): void
	{
		$this->cart->delete($key);
		$this->presenter->redirect('this');
	}


	/********************************************************************************
	 *                                  Components                                  *
	 ********************************************************************************/


	protected function createComponentUpdateForm(): Form
	{
		$form = new Form();
		foreach ($this->cart->getItems() as $key => $item) {
			$form->addText($key)
				->setHtmlType('number')
				->setValue($item->getQuantity())
				->setRequired();
		}

		$form->addSubmit('update', 'Update')->onClick[] = function ($submit) {
			$this->updateCart($submit->form);
			$this->onClickUpdate($this->cart);
			$this->presenter->redirect('this');
		};

		$form->addSubmit('next', 'Checkout')->onClick[] = function ($submit) {
			$this->updateCart($submit->form);
			$this->onClickNext($this->cart);
		};

		$form->addSubmit('continue', 'Continue shopping')->onClick[] = function ($submit) {
			$this->updateCart($submit->form);
			$this->onClickContinue($this->cart);
		};

		return $form;
	}


	private function updateCart(Form $form): void
	{
		foreach ($form->values as $key => $quantity) {
			$this->cart->update((string) $key, (int) $quantity);
		}
	}


	/********************************************************************************
	 *                              Getters and Setters                             *
	 ********************************************************************************/


	public function getCart(): Cart
	{
		return $this->cart;
	}


	public function setCart(Cart $cart): self
	{
		$this->cart = $cart;
		return $this;
	}


	public function isShowImage(): bool
	{
		return $this->showImage;
	}


	public function setShowImage(bool $showImage): self
	{
		$this->showImage = $showImage;
		return $this;
	}


	public function isShowName(): bool
	{
		return $this->showName;
	}


	public function setShowName(bool $showName): self
	{
		$this->showName = $showName;
		return $this;
	}


	public function isShowPrice(): bool
	{
		return $this->showPrice;
	}


	public function setShowPrice(bool $showPrice): self
	{
		$this->showPrice = $showPrice;
		return $this;
	}


	public function isShowQuantity(): bool
	{
		return $this->showQuantity;
	}


	public function setShowQuantity(bool $showQuantity): self
	{
		$this->showQuantity = $showQuantity;
		return $this;
	}


	public function isShowTotalWithoutVat(): bool
	{
		return $this->showTotalWithoutVat;
	}


	public function setShowTotalWithoutVat(bool $showTotalWithoutVat): self
	{
		$this->showTotalWithoutVat = $showTotalWithoutVat;
		return $this;
	}


	public function isShowTotal(): bool
	{
		return $this->showTotal;
	}


	public function setShowTotal(bool $showTotal): self
	{
		$this->showTotal = $showTotal;
		return $this;
	}


	public function isShowDelete(): bool
	{
		return $this->showDelete;
	}


	public function setShowDelete(bool $showDelete): self
	{
		$this->showDelete = $showDelete;
		return $this;
	}


	public function getImageWidth(): int
	{
		return $this->imageWidth;
	}


	public function setImageWidth(int $imageWidth): self
	{
		$this->imageWidth = $imageWidth;
		return $this;
	}


	public function getImageHeight(): int
	{
		return $this->imageHeight;
	}


	public function setImageHeight(int $imageHeight): self
	{
		$this->imageHeight = $imageHeight;
		return $this;
	}


	public function getNextName(): string
	{
		return $this->nextName;
	}


	public function setNextName(string $nextName): self
	{
		$this->nextName = $nextName;
		return $this;
	}


	public function getContinueName(): string
	{
		return $this->continueName;
	}


	public function setContinueName(string $continueName): self
	{
		$this->continueName = $continueName;
		return $this;
	}


	public function getUpdateName(): string
	{
		return $this->updateName;
	}


	public function setUpdateName(string $updateName): self
	{
		$this->updateName = $updateName;
		return $this;
	}
}
