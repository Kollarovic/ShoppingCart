<?php

declare(strict_types=1);

namespace Kollarovic\ShoppingCart;

use ArrayAccess;
use IteratorAggregate;
use Nette\InvalidArgumentException;


class Cart
{
	/** @var Item[]|mixed */
	private $items;


	public function __construct($items = [])
	{
		if (!($items instanceof ArrayAccess and $items instanceof IteratorAggregate) and !is_array($items)) {
			throw new InvalidArgumentException('Items must be array or ArrayAccess and IteratorAggregate.');
		}
		$this->items = $items;
	}


	/********************************************************************************
	 *                               Items management                               *
	 ********************************************************************************/


	public function addItem($id, $price, int $quantity = 1, array $options = []): Item
	{
		$key = $this->createKey($id, $options);
		$item = $this->getItem($key);
		if ($item) {
			$item->addQuantity($quantity);
		} else {
			$item = new Item($id, $price, $quantity, $options);
			$this->items[$key] = $item;
		}
		return $item;
	}


	public function update(string $key, int $quantity): void
	{
		if ($quantity <= 0) {
			$this->delete($key);
		} else {
			$item = isset($this->items[$key]) ? $this->items[$key] : null;
			if ($item) {
				$item->setQuantity($quantity);
			}
		}
	}


	public function delete(string $key): void
	{
		unset($this->items[$key]);
	}


	public function clear(): void
	{
		foreach ($this->items as $key => $item) {
			$this->delete($key);
		}
	}


	/********************************************************************************
	 *                              Getters and Setters                             *
	 ********************************************************************************/


	public function isEmpty(): bool
	{
		return $this->getQuantity() > 0 ? false : true;
	}


	public function getItems()
	{
		return $this->items;
	}


	public function getItem(string $key): ?Item
	{
		return isset($this->items[$key]) ? $this->items[$key] : null;
	}


	public function getTotal(): float
	{
		$total = 0;
		foreach ($this->items as $item) {
			$total += $item->getTotal();
		}
		return $total;
	}


	public function getTotalWithoutVat(): float
	{
		$total = 0;
		foreach ($this->items as $item) {
			$total += $item->getTotalWithoutVat();
		}
		return $total;
	}


	public function getQuantity()
	{
		$quantity = 0;
		foreach ($this->items as $key => $item) {
			$quantity += $item->getQuantity();
		}
		return $quantity;
	}


	/********************************************************************************
	 *                                     Other                                    *
	 ********************************************************************************/


	private function createKey($id, $options = []): string
	{
		$options = (array) $options;
		sort($options);
		return md5($id . '-' . serialize($options));
	}
}
