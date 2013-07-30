<?php

/*
 * This file is part of the EoEcommerceBundle package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eo\EcommerceBundle\Generator;

use \DateTime;
use Eo\EcommerceBundle\Document\Product\CustomProductInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class VariantGenerator implements VariantGeneratorInterface
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
	 * {@inheritdoc}
	 */
	public function generate(CustomProductInterface $product)
	{
        $config = $this->container->getParameter('eo_ecommerce.config');
        $dm = $this->container->get('doctrine.odm.mongodb.document_manager');
        $repo = $dm->getRepository($config['variants']['class']);

		$options = $product->getOptions();
        if (count($options) > 0) {
            foreach ($options as $option) {
                $method = $option->getMethod();
                $values = $product->$method();
                foreach ($values as $value) {
                    $sku = implode("-", array($product->getSku(), $value->getSku()));
                    if ($sku)
                    // Search variant
                    $variant = $repo->findOneBy(array('sku' => $sku));
                    if (is_null($variant)) {
                        // Create variant
                        $class = $repo->getClassName();
                        $variant = new $class();
                        $variant->setCreatedAt(new DateTime());
                    }
                    // Update variant
                    $variant->setSku($sku);
                    $variant->setSlug($value->getSlug());
                    $variant->setName(implode(' ', array($product->getName(), $value->getName())));
                    $variant->setDescription($value->getDescription());
                    $variant->setProduct($product);
                    $variant->setUpdatedAt(new DateTime());
                    // Check for variant prices
                    $variantPrices = $value->getVariantPrices();
                    if (!is_null($variantPrices) && !empty($variantPrices)) {
                        $variant->clearPrices();
                        $variant->setPrices($variantPrices);
                    }
                    // Persist variant
                    $dm->persist($variant);
                    $dm->flush(null, array('safe' => true));
                    // Add variant to given product
                    $product->addVariant($variant);
                }
            }
        }
 	}

    /**
     * Merge products
     *
     * @param  array            $products
     * @return ProductInterface $product
     */
    private function mergeProducts(array $products)
    {

    }
}