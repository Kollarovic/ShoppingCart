<?php

namespace Kollarovic\ShoppingCart;

use Nette\InvalidArgumentException;


class Cart
{

	/** @var Item[] */
	private $items;


	public function __construct($items = [])
	{
		if (!($items instanceof \ArrayAccess and $items instanceof \IteratorAggregate) and !is_array($items)) {
			throw new InvalidArgumentException('Items must be array or ArrayAccess and IteratorAggregate.');
		}
		$this->items = $items;
	}


	public function addItem($id, $price, $quantity = 1, array $options = [])
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


	public function update($key, $quantity)
	{
		if ($quantity <= 0) {
			$this->delete($key);
		} else {
			$item = isset($this->items[$key]) ? $this->items[$key] : NULL;
			if ($item) {
				$item->setQuantity($quantity);
			}
		}
	}


	public function delete($key)
	{
		unset($this->items[$key]);
	}
	

	public function clear()
	{
		foreach($this->items as $key => $item) {
			$this->delete($key);
		}
	}


	public function isEmpty()
	{
		return $this->getQuantity() > 0 ? FALSE : TRUE;
	}


	public function getItem($key)
	{
		return isset($this->items[$key]) ? $this->items[$key] : NULL;
	}

	
	public function getTotal()
	{
		$total = 0;
		foreach($this->items as $item) {
			$total += $item->getTotal();
		}
		return $total;
	}


	public function getTotalWithoutVat()
	{
		$total = 0;
		foreach($this->items as $item) {
			$total += $item->getTotalWithoutVat();
		}
		return $total;
	}


	public function getQuantity()
	{
		$quantity = 0;
		foreach($this->items as $key => $item) {
			$quantity += $item->getQuantity();
		}
		return $quantity;
	}


	public function getItems()
	{
		return $this->items;
	}


	private function createKey($id, $options = [])
	{
		$options = (array)$options;
		sort($options);
		return md5($id . '-' . serialize($options));
	}

}