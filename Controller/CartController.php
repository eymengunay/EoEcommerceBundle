<?php

/*
 * This file is part of the JuliusAdminBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Controller;

use Eo\EcommerceBundle\Document\Product\ProductInterface;
use Eo\EcommerceBundle\Form\Type\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CartController extends Controller
{
    /**
     * View cart
     */
    public function indexAction()
    {
        $cartManager = $this->get('eo_ecommerce.cart_manager');
        $cart = $cartManager->getOrCreateCart();

        return $this->render('EoEcommerceBundle:Cart:index.html.twig', array(
            'cart' => $cart
        ));
    }

    public function addAction()
    {
        // Managers
        $ecommerceManager = $this->get('eo_ecommerce.manager');
        $cartManager = $this->get('eo_ecommerce.cart_manager');
        // Cart
        $cart = $cartManager->getOrCreateCart();

        // Form
        $form = $this->createForm(new ProductType());
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $added = 0;
            foreach ($form->get('products') as $product) {
                $sku = $product->get('sku')->getData();
                $quantity = $product->get('quantity')->getData();
                if ($quantity > 0) {
                    $product = $ecommerceManager->findOneBySku($sku);
                    // If no product found
                    if (!$product) {
                        throw new \Exception(sprintf("Product %s not found", $sku));
                    }
                    $item = $ecommerceManager->createNewCartItem();
                    $item->setProduct($product);
                    $item->setQuantity($quantity);
                    $cart->addItem($item);
                    $added++;
                }
            }
            $ecommerceManager->saveCart($cart, true);
            if ($added > 0) {
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans("add.cart.success", array(), 'ecommerce') );
            } else {
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans("add.cart.empty", array(), 'ecommerce') );
            }
        } else {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans("add.cart.error", array(), 'ecommerce') );
        }

        return $this->redirect($this->getRequest()->headers->get('referer', $this->generateUrl('Eo_EcommerceBundle_Cart_View')));
    }

    /**
     * Remove item action
     *
     * @param string $itemId
     */
    public function removeAction($itemId)
    {
        // Managers
        $ecommerceManager = $this->get('eo_ecommerce.manager');
        $cartManager = $this->get('eo_ecommerce.cart_manager');

        $cart = $cartManager->getCart();
        if (is_null($cart)) {
            return false;
        }

        if ($remove = $cartManager->removeItem($itemId)) {
            $ecommerceManager->saveCart($cart, true);
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans("remove.cart.success", array(), 'ecommerce') );
        } else {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans("remove.cart.success", array(), 'ecommerce') );
        }

        return $this->redirect($this->generateUrl('Eo_EcommerceBundle_Cart_View'));
    }

    /**
     * Checkout
     */
    public function checkoutAction()
    {
        $paymentName = 'eo_ecommerce_payment';

        $storage = $this->get('payum')->getStorageForClass(
            'Acme\DemoBundle\Entity\PaypalExpressPaymentDetails',
            $paymentName
        );

        /** @var PaypalExpressPaymentDetails */
        $paymentDetails = $storage->createModel();
        $paymentDetails->setPaymentrequestCurrencycode(0, 'USD');
        $paymentDetails->setPaymentrequestAmt(0,  1.23);

        $storage->updateModel($paymentDetails);

        $captureToken = $this->get('payum.token_manager')->createTokenForCaptureRoute(
            $paymentName,
            $paymentDetails,
            'acme_payment_done' // the route to redirect after capture;
        );

        $paymentDetails->setInvnum($paymentDetails->getId());
        $paymentDetails->setReturnurl($captureToken->getTargetUrl());
        $paymentDetails->setCancelurl($captureToken->getTargetUrl());

        $storage->updateModel($paymentDetails);

        return $this->redirect($captureToken->getTargetUrl());
    }
}
