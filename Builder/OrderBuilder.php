<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Builder;


use Eo\EcommerceBundle\Document\Price\EmbeddedPrice;
use Eo\EcommerceBundle\Document\Price\EmbeddedPriceInterface;
use Eo\EcommerceBundle\Document\Price\PriceInterface;
use Eo\EcommerceBundle\Document\Product\ProductInterface;
use Eo\EcommerceBundle\Document\Order\OrderInterface;
use Eo\EcommerceBundle\Document\Order\OrderItemInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OrderBuilder extends BaseBuilder implements OrderBuilderInterface
{
	/**
	 * Creates a new order
	 *
	 * @return OrderInterface
	 */
	public function createNewOrder()
	{
		return $this->createNew($this->getOrderRepository()->getClassName());
	}

	/**
	 * Creates a new order item
	 *
	 * @return OrderInterface
	 */
	public function createNewOrderItem(ProductInterface $product, PriceInterface $price)
	{
		// Prices of order items are embedded by default
		// to avoid missing references in case a price gets deleted.
		if (!$price instanceof EmbeddedPriceInterface) {
			$config = $this->getConfiguration();
			$itemPrice = new $config['orders']['items']['prices']['class'];
			$price = $itemPrice->loadFromParent($price);
		}

		$item = $this->createNew($this->getOrderItemRepository()->getClassName());
		$item->setProduct($product);
		$item->setPrice($price);
		return $item;
	}

	/**
	 * Creates a new instance of given class
	 *
	 * @param  string $class
	 * @return object
	 */
	private function createNew($class)
	{
		return new $class();
	}

	/**
	 * Get order repository
	 *
	 * @return DocumentRepository $orderRepository
	 */
	public function getOrderRepository()
	{
		$config = $this->getConfiguration();
		return $this->getRepository($config['orders']['class']);
	}

	/**
	 * Get order item repository
	 *
	 * @return DocumentRepository $orderRepository
	 */
	public function getOrderItemRepository()
	{
		$config = $this->getConfiguration();
		return $this->getRepository($config['orders']['items']['class']);
	}

	/**
	 * Returns the document repository of given class
	 *
	 * @param  string 			  $class
	 * @return DocumentRepository
	 */
	private function getRepository($class)
	{
		$dm = $this->getDocumentManager();
		return $dm->getRepository($class);
	}

	/**
	 * Save order
	 *
	 * @param OrderInterface $order
	 * @param bool           $flush
	 */
	public function save(OrderInterface $order, $flush = false)
	{
		$dm = $this->getDocumentManager();
		$dm->persist($order);
		if ($flush) {
			$dm->flush(null, array('safe' => true));
		}
	}

    /**
     * Save orderItem
     *
     * @param ItemInterface  $item
     * @param OrderInterface $order
     * @param bool           $flush
     */
    public function saveItem(OrderItemInterface $item, OrderInterface $order, $flush = false)
    {
        $dm = $this->getDocumentManager();
        $item->setOrder($order);
        $dm->persist($item);
        if ($flush) {
            $dm->flush(null, array('safe' => true));
        }
    }
}