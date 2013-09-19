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
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @var EcommerceManager
     */
    protected $ecommerceManager;

    /**
     * Class constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->session = $container->get('session');
        $this->ecommerceManager = $container->get('eo_ecommerce.manager');

        // Initialize session if not started already
        if (!$this->session->isStarted()) {
            $this->session->start();
        }
    }

    /**
     * Remove cart item
     *
     * @param string $itemId
     */
    public function removeItem($itemId)
    {
        $cart = $this->getCart();
        if (is_null($cart)) {
            return false;
        }

        $i = 0;
        foreach ($cart->getItems() as $item) {
            if ($item->getId() == $itemId) {
                $cart->removeItem($i);
                return true;
            }
            $i++;
        }

        return false;
    }
}
