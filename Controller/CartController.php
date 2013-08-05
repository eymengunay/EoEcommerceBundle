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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CartController extends Controller
{
    /**
     * Add item action
     */
    public function addItemAction(Request $request, ProductInterface $item)
    {
        $cm = $this->get('eo_ecommerce.cart_manager');
        $cart = $cm->getCreateCart();
        $cm->save($cart, true);

        return new RedirectResponse($request->headers->get('referer'));
    }
}
