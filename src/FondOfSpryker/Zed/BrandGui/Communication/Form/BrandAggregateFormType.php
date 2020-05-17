<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Form;

use Generated\Shared\Transfer\BrandAggregateFormTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \FondOfSpryker\Zed\BrandGui\BrandGuiConfig getConfig()
 * @method \FondOfSpryker\Zed\BrandGui\Communication\BrandGuiCommunicationFactory getFactory()
 */
class BrandAggregateFormType extends AbstractType
{
    public const BLOCK_PREFIX = 'brandAggregate';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => BrandAggregateFormTransfer::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return static::BLOCK_PREFIX;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this
            ->addBrandSubForm($builder)
            ->expandWithBrandAssignmentForms($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBrandSubForm(FormBuilderInterface $builder)
    {
        $builder->add(
            BrandAggregateFormTransfer::BRAND,
            BrandFormType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function expandWithBrandAssignmentForms(FormBuilderInterface $builder)
    {
        $this->getFactory()
            ->createBrandAggregateFormExpander()
            ->expandWithBrandAssignmentForms($builder);

        return $this;
    }
}
