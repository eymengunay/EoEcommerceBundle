<?php

namespace Eo\EcommerceBundle\Form\Type;

use Eo\EcommerceBundle\Condition\ConditionManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConditionChoiceType extends AbstractType
{
    /**
     * @var ConditionManagerInterface $cm
     */
    protected $cm;

    /**
     * Class constructor
     *
     * @param ConditionManagerInterface cm
     */
    public function __construct(ConditionManagerInterface $cm)
    {
        $this->cm = $cm;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'condition_choice';
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choice_list'   => function (Options $options) {
                return $this->getChoiceList($options);
            }
        ));
    }

    /**
     * Get choices
     *
     * @return array
     */
    public function getChoiceList()
    {
        $choices = array();
        $labels = array();
        foreach ($this->cm->getConditions() as $condition) {
            $choices[] = $condition->getName();
            $labels[] = $condition->getName();
        }
        return new ChoiceList($choices, $labels);
    }
}