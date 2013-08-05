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

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class BaseBuilder
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
}