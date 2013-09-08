<?php

/*
 * This file is part of the JuliusEventBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Manager;

use Eo\EcommerceBundle\Document\Cart\CartInterface;
use Eo\EcommerceBundle\Document\Cart\CartItemInterface;
use Eo\EcommerceBundle\Document\Order\OrderInterface;
use Eo\EcommerceBundle\Document\Order\OrderItemInterface;
use Eo\EcommerceBundle\Document\Variant\VariantInterface;
use Eo\EcommerceBundle\Document\Price\PriceConditionInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Eo\EcommerceBundle\Manager\EcommerceManager
 */
class EcommerceManager implements EcommerceManagerInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Class constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get bundle configuration
     *
     * @return array
     */
    public function getConfiguration()
    {
        return $this->container->getParameter('eo_ecommerce.config');
    }

    /**
     * Get document manager
     *
     * @return array
     */
    public function getDocumentManager()
    {
        return $this->container->get('doctrine.odm.mongodb.document_manager');
    }

    /**
     * Persist and flush
     *
     * @param mixed $object
     * @param bool  $flush
     */
    protected function persistAndFlush($object, $flush = false)
    {
        $dm = $this->getDocumentManager();
        $dm->persist($object);
        if ($flush) {
            $dm->flush();
        }
    }

    /**
     * Find one by sku
     *
     * @param  string           $sku
     * @return ProductInterface
     */
    public function findOneBySku($sku)
    {
        $product = $this->getProductRepository()->findOneBySku($sku);

        if (!$product) {
            $product = $this->getVariantRepository()->findOneBySku($sku);
        }

        return $product;
    }

    /**
     * Get product repository
     */
    public function getProductRepository()
    {
        $config = $this->getConfiguration();
        return $this->getDocumentManager()->getRepository($config['products']['class']);
    }

    /**
     * Create new product
     *
     * @return ProductInterface $product
     */
    public function createNewProduct()
    {
        $class = $this->getProductRepository()->getClassName();
        return new $class();
    }

    /**
     * Get product repository
     */
    public function getCustomProductRepository()
    {
        $config = $this->getConfiguration();
        return $this->getDocumentManager()->getRepository($config['customProducts']['class']);
    }

    /**
     * Create new custom product
     *
     * @return CustomProductInterface $customProduct
     */
    public function createNewCustomProduct()
    {
        $class = $this->getCustomProductRepository()->getClassName();
        return new $class();
    }

    /**
     * Get order repository
     */
    public function getOrderRepository()
    {
        $config = $this->getConfiguration();
        return $this->getDocumentManager()->getRepository($config['orders']['class']);
    }

    /**
     * Create new order
     *
     * @return OrderInterface $order
     */
    public function createNewOrder()
    {
        $class = $this->getOrderRepository()->getClassName();
        return new $class();
    }

    /**
     * Save order
     *
     * @param OrderInterface $order
     * @param bool           $flush
     */
    public function saveOrder(OrderInterface $order, $flush = false)
    {
        $this->persistAndFlush($order, $flush);
    }

    /**
     * Get order item repository
     */
    public function getOrderItemRepository()
    {
        $config = $this->getConfiguration();
        return $this->getDocumentManager()->getRepository($config['orders']['items']['class']);
    }

    /**
     * Create new order item
     *
     * @return OrderItemInterface $orderitem
     */
    public function createNewOrderItem()
    {
        $class = $this->getOrderItemRepository()->getClassName();
        return new $class();
    }

    /**
     * Save order item
     *
     * @param OrderInterface $order
     * @param OrderItemInterface $orderItem
     * @param bool               $flush
     */
    public function saveOrderItem(OrderInterface $order, OrderItemInterface $orderItem, $flush = false)
    {
        $orderItem->setOrder($order);
        $this->persistAndFlush($orderItem, $flush);
    }

    /**
     * Get order item price repository
     */
    public function getOrderItemPriceRepository()
    {
        $config = $this->getConfiguration();
        return $this->getDocumentManager()->getRepository($config['orders']['items']['prices']['class']);
    }

    /**
     * Create new order item
     *
     * @return OrderItemInterface $orderitem
     */
    public function createNewOrderItemPrice()
    {
        $class = $this->getOrderItemPriceRepository()->getClassName();
        return new $class();
    }

    /**
     * Get price condition repository
     */
    public function getPriceConditionRepository()
    {
        $config = $this->getConfiguration();
        return $this->getDocumentManager()->getRepository($config['priceConditions']['class']);
    }

    /**
     * Create new price condition
     *
     * @return PriceConditionInterface $priceCondition
     */
    public function createNewPriceCondition()
    {
        $class = $this->getPriceConditionRepository()->getClassName();
        return new $class();
    }

    /**
     * Get cart repository
     */
    public function getCartRepository()
    {
        $config = $this->getConfiguration();
        return $this->getDocumentManager()->getRepository($config['carts']['class']);
    }

    /**
     * Create new cart
     *
     * @return CartInterface $cart
     */
    public function createNewCart()
    {
        $class = $this->getCartRepository()->getClassName();
        return new $class();
    }

    /**
     * Save cart
     *
     * @param CartInterface  $cart
     * @param bool           $flush
     */
    public function saveCart(CartInterface $cart, $flush = false)
    {
        $this->persistAndFlush($cart, $flush);
    }

    /**
     * Get cart repository
     */
    public function getCartItemRepository()
    {
        $config = $this->getConfiguration();
        return $this->getDocumentManager()->getRepository($config['carts']['items']['class']);
    }

    /**
     * Create new cart item
     *
     * @return CartItemInterface $cartItem
     */
    public function createNewCartItem()
    {
        $class = $this->getCartItemRepository()->getClassName();
        return new $class();
    }

    /**
     * Get variant repository
     */
    public function getVariantRepository()
    {
        $config = $this->getConfiguration();
        return $this->getDocumentManager()->getRepository($config['variants']['class']);
    }

    /**
     * Create new variant
     *
     * @return VariantInterface $variant
     */
    public function createNewVariant()
    {
        $class = $this->getVariantRepository()->getClassName();
        return new $class();
    }
}
