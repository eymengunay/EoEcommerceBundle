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
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Eo\EcommerceBundle\Twig\Extension\CartExtension
 */
class CartManager implements CartManagerInterface
{
    const SESSION_KEY = 'eo_ecommerce.cart';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * Class constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->session = $container->get('session');

        // Initialize session if not started already
        if (!$this->session->isStarted()) {
            $this->session->start();
        }
    }

    /**
     * Get bundle configuration
     *
     * @return array
     */
    private function getConfiguration()
    {
        return $this->container->getParameter('eo_ecommerce.config');
    }

    /**
     * Get document manager
     *
     * @return array
     */
    private function getDocumentManager()
    {
        return $this->container->get('doctrine.odm.mongodb.document_manager');
    }

    /**
     * Get document manager
     *
     * @return ObjectRepository
     */
    private function getRepository()
    {
        $config = $this->getConfiguration();
        $dm = $this->getDocumentManager();
        return $dm->getRepository($config['carts']['class']);
    }

    /**
     * Current user cart
     *
     * @return CartInterface
     */
    private function getCart()
    {
        $sessionCart = $this->session->get(self::SESSION_KEY, null);

        if (is_null($sessionCart)) {
            return null;
        }

        $repo = $this->getRepository();
        $cart = $repo->findOneBy(array('id' => $sessionCart));

        if (is_null($cart)) {
            return null;
        }

        return $cart;
    }

    /**
     * Create a new cart
     *
     * @return CartInterface
     */
    private function createCart()
    {
        // Cart class from bundle configuration
        $config = $this->getConfiguration();
        $cartClass = $config['carts']['class'];

        // Create new cart
        $cart = new $cartClass();

        // Set current user as holder of this cart
        $sc = $this->container->get('security.context');
        $user = $sc->getToken()->getUser();

        $cart->setUser($user);

        $dm = $this->getDocumentManager();
        $this->save($cart, true);

        $this->session->set(self::SESSION_KEY, $cart->getId());

        return $cart;
    }

    /**
     * Save cart
     *
     * @param  CartInterface $cart
     * @return self
     */
    private function save(CartInterface $cart, $flush = false)
    {
        $dm = $this->getDocumentManager();
        $dm->persist($cart);

        if ($flush) {
            $dm->flush($cart, array('safe' => true));
        }

        return $this;
    }

    /**
     * Gets current cart if exists otherwise
     * creates an empty cart
     *
     * @return CartInterface
     */
    public function getOrCreateCart()
    {
        $cart = $this->getCurrentCart();

        if (is_null($cart)) {
            $cart = $this->createCart();
        }

        return $cart;
    }
}
