<?php

declare(strict_types=1);

namespace Kollarovic\ShoppingCart;


class Item
{
	/** @var mixed */
	private $id;

	/** @var string */
	private $name;

	/** @var string */
	private $link;

	/** @var mixed */
	private $linkArgs = [];

	/** @var float|null */
	private $price;

	/** @var float|null */
	private $priceWithoutVat;

	/** @var int */
	private $pricePrecision = 2;

	/** @var int */
	private $vatRate = 0;

	/** @var int */
	private $quantity;

	/** @var string */
	private $unit;

	/** @var string */
	private $availability;

	/** @var string */
	private $image;

	/** @var array */
	private $options = [];

	/** @var array */
	private $data = [];


	public function __construct($id, ?float $price = null, $quantity = 1, array $options = [])
	{
		$this->id = $id;
		$this->price = $price;
		$this->quantity = $quantity;
		$this->options = $options;
	}


	/********************************************************************************
	 *                                     Price                                    *
	 ********************************************************************************/


	public function getPrice(): float
	{
		if ($this->price) {
			return $this->price;
		}
		return round($this->priceWithoutVat + ($this->priceWithoutVat / 100 * $this->vatRate), $this->pricePrecision);
	}


	public function getPriceWithoutVat(): float
	{
		if ($this->priceWithoutVat) {
			return $this->priceWithoutVat;
		}
		return round(($this->price / (100 + $this->vatRate)) * 100, $this->pricePrecision);
	}


	public function setPriceWithoutVat(float $priceWithoutVat): self
	{
		$this->priceWithoutVat = $priceWithoutVat;
		return $this;
	}


	public function getTotal(): float
	{
		return $this->getPrice() * $this->quantity;
	}


	public function getTotalWithoutVat(): float
	{
		return $this->getPriceWithoutVat() * $this->quantity;
	}


	public function getPricePrecision(): int
	{
		return $this->pricePrecision;
	}


	public function setPricePrecision(int $pricePrecision): self
	{
		$this->pricePrecision = $pricePrecision;
		return $this;
	}


	public function getVatRate(): int
	{
		return $this->vatRate;
	}


	public function setVatRate(int $vatRate): self
	{
		$this->vatRate = $vatRate;
		return $this;
	}


	/********************************************************************************
	 *                                    Quantity                                  *
	 ********************************************************************************/


	public function addQuantity(int $quantity)
	{
		$this->quantity += $quantity;
		return $this;
	}


	public function getQuantity(): int
	{
		return $this->quantity;
	}


	public function setQuantity(int $quantity): self
	{
		$this->quantity = $quantity;
		return $this;
	}


	/********************************************************************************
	 *                                     Link                                     *
	 ********************************************************************************/


	public function getLink(): ?string
	{
		return $this->link;
	}


	public function setLink(string $link): self
	{
		$this->link = $link;
		return $this;
	}


	public function getLinkArgs()
	{
		return $this->linkArgs;
	}


	public function setLinkArgs($linkArgs): self
	{
		$this->linkArgs = $linkArgs;
		return $this;
	}


	/********************************************************************************
	 *                                   Attributes                                 *
	 ********************************************************************************/


	public function getId()
	{
		return $this->id;
	}


	public function getName(): ?string
	{
		return $this->name;
	}


	public function setName(string $name): self
	{
		$this->name = $name;
		return $this;
	}


	public function getImage(): ?string
	{
		return $this->image;
	}


	public function setImage(string $image): self
	{
		$this->image = $image;
		return $this;
	}


	public function getUnit(): ?string
	{
		return $this->unit;
	}


	public function setUnit(string $unit): self
	{
		$this->unit = $unit;
		return $this;
	}


	public function getAvailability(): ?string
	{
		return $this->availability;
	}


	public function setAvailability(string $availability)
	{
		$this->availability = $availability;
		return $this;
	}


	public function getOptions(): array
	{
		return $this->options;
	}


	/********************************************************************************
	 *                                     Data                                     *
	 ********************************************************************************/


	public function getData(): array
	{
		return $this->data;
	}


	public function setData(array $data): self
	{
		$this->data = $data;
		return $this;
	}
}
