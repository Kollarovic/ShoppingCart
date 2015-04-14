<?php

namespace Kollarovic\ShoppingCart\DI;

use Nette\DI\CompilerExtension;
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
				'image' => TRUE,
				'name' => TRUE,
				'price' => FALSE,
				'quantity' => TRUE,
				'totalWithoutVat' => TRUE,
				'total' => TRUE,
				'delete' => TRUE,
			],
			'buttons' => [
				'next' => 'Checkout',
				'continue' => 'Continue shopping',
				'update' => 'Update',
			],
			'image' => [
				'width' => 80,
				'height' => 80,
			]
		];
	}


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->getDefaultConfig());
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('cart'))
			->setClass('Kollarovic\ShoppingCart\Cart', [$config['items']]);

		$builder->addDefinition($this->prefix('cartControlFactory'))
			->setImplement('Kollarovic\ShoppingCart\ICartControlFactory')
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
			->setClass('Kollarovic\ShoppingCart\PriceHelper', [
				'currency' => $priceConfig['currency'],
				'decimals' => $priceConfig['decimals'],
				'decimalPoint' => $priceConfig['decimalPoint'],
				'thousandsSep' => $priceConfig['thousandsSep'],
				'priceFormat' => $priceConfig['priceFormat'],
			]);

		if ($builder->hasDefinition('nette.latteFactory')) {
			$definition = $builder->getDefinition('nette.latteFactory');
			$definition->addSetup('addFilter', array($config['price']['filterName'], array($this->prefix('@priceHelper'), 'format')));
		}
	}

}
