<?php

declare(strict_types=1);

namespace Kollarovic\ShoppingCart\DI;

use Kollarovic\ShoppingCart\Cart;
use Kollarovic\ShoppingCart\ICartControlFactory;
use Kollarovic\ShoppingCart\PriceHelper;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\FactoryDefinition;
use Nette\DI\Statement;


class Extension extends CompilerExtension
{
	private function getDefaultConfig()
	{
		return [
			'items' => new Statement('@session::getSection', [__CLASS__]),
			'price' => [
				'currency' => '€',
				'decimals' => 2,
				'decimalPoint' => ',',
				'thousandsSep' => ' ',
				'priceFormat' => '{price} {currency}',
				'filterName' => 'price',
			],
			'columns' => [
				'image' => true,
				'name' => true,
				'price' => false,
				'quantity' => true,
				'totalWithoutVat' => true,
				'total' => true,
				'delete' => true,
			],
			'buttons' => [
				'next' => 'Checkout',
				'continue' => 'Continue shopping',
				'update' => 'Update',
			],
			'image' => [
				'width' => 80,
				'height' => 80,
			],
		];
	}


	public function loadConfiguration(): void
	{
		$config = $this->validateConfig($this->getDefaultConfig());
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('cart'))
			->setFactory(Cart::class, [$config['items']]);

		$builder->addFactoryDefinition($this->prefix('cartControlFactory'))
			->setImplement(ICartControlFactory::class)
			->getResultDefinition()
			->addSetup('setShowImage', [$config['columns']['image']])
			->addSetup('setShowName', [$config['columns']['name']])
			->addSetup('setShowPrice', [$config['columns']['price']])
			->addSetup('setShowQuantity', [$config['columns']['quantity']])
			->addSetup('setShowTotalWithoutVat', [$config['columns']['totalWithoutVat']])
			->addSetup('setShowTotal', [$config['columns']['total']])
			->addSetup('setShowDelete', [$config['columns']['delete']])
			->addSetup('setNextName', [$config['buttons']['next']])
			->addSetup('setContinueName', [$config['buttons']['continue']])
			->addSetup('setUpdateName', [$config['buttons']['update']])
			->addSetup('setImageWidth', [$config['image']['width']])
			->addSetup('setImageHeight', [$config['image']['height']]);

		$priceConfig = $config['price'];
		$builder->addDefinition($this->prefix('priceHelper'))
			->setFactory(PriceHelper::class, [
				'currency' => $priceConfig['currency'],
				'decimals' => $priceConfig['decimals'],
				'decimalPoint' => $priceConfig['decimalPoint'],
				'thousandsSep' => $priceConfig['thousandsSep'],
				'priceFormat' => $priceConfig['priceFormat'],
			]);

		if ($builder->hasDefinition('nette.latteFactory')) {
			/** @var FactoryDefinition $definition  */
			$definition = $builder->getDefinition('nette.latteFactory');
			$definition->getResultDefinition()->addSetup('addFilter', [$config['price']['filterName'], [$this->prefix('@priceHelper'), 'format']]);
		}
	}
}
