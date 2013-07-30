<?php

namespace Eo\EcommerceBundle\Condition;

use Eo\EcommerceBundle\Document\Product\CustomProductInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConditionManager implements ConditionManagerInterface
{
    protected $conditions = array();

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Class constructor
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->config    = $this->container->getParameter('eo_ecommerce.config');
    }

    /**
     * {@inheritdoc}
     */
    public function addCondition(ConditionInterface $condition)
    {
        $this->conditions[$condition->getName()] = $condition;
    }

    /**
     * Get condition
     *
     * @param  string $name
     * @return ConditionInterface $condition
     */
    public function getCondition($name)
    {
        return isset($this->conditions[$name]) ? $this->conditions[$name] : null;
    }

    /**
     * Get conditions
     *
     * @return array $conditions
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Get conditions
     *
     * @param  CustomProductInterface $product
     * @return array                  $conditions
     */
    public function check(CustomProductInterface $product)
    {
        $dm = $this->container->get("doctrine.odm.mongodb.document_manager");
        $repo = $dm->getRepository($this->config['priceConditions']['class']);
        $qb = $repo->createQueryBuilder();
        $priceConditions = $qb
            ->field("variants.id")->equals($product->getId())
            ->getQuery()
            ->execute()
        ;
        if (!is_null($priceConditions)) {
            foreach ($priceConditions as $priceCondition) {
                $condition = $this->getCondition($priceCondition->getCondition());
                if ($condition && $condition->met($product)) {
                    return $priceCondition->getPrice();
                }
            }
        }

        return null;
    }
}