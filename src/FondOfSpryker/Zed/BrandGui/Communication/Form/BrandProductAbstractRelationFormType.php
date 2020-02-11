<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Form;

use Generated\Shared\Transfer\BrandAggregateFormTransfer;
use Generated\Shared\Transfer\BrandProductAbstractRelationTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \FondOfSpryker\Zed\BrandGui\BrandGuiConfig getConfig()
 * @method \FondOfSpryker\Zed\BrandGui\Communication\BrandGuiCommunicationFactory getFactory()
 */
class BrandProductAbstractRelationFormType extends AbstractType
{
    public const FIELD_ID_BRAND = BrandProductAbstractRelationTransfer::ID_BRAND;
    public const FIELD_ASSIGNED_PRODUCT_ABSTRACT_IDS = BrandAggregateFormTransfer::ASSIGNED_PRODUCT_ABSTRACT_IDS;
    public const FIELD_PRODUCT_ABSTRACT_IDS_TO_BE_ASSIGNED = BrandAggregateFormTransfer::PRODUCT_ABSTRACT_IDS_TO_BE_ASSIGNED;
    public const FIELD_PRODUCT_ABSTRACT_IDS_TO_BE_DEASSIGNED = BrandAggregateFormTransfer::PRODUCT_ABSTRACT_IDS_TO_BE_DE_ASSIGNED;

    public const PRODUCT_ABSTRACT_IDS = BrandProductAbstractRelationTransfer::PRODUCT_ABSTRACT_IDS;
    public const BLOCK_PREFIX = 'brandProductAbstractRelationTransfer';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => BrandProductAbstractRelationTransfer::class,
            'label' => false,
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
        $this->addIdBrandField($builder)
            ->addProductAbstractIdsField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdBrandField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_ID_BRAND,
            HiddenType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addProductAbstractIdsField(FormBuilderInterface $builder)
    {
        $builder->add(static::PRODUCT_ABSTRACT_IDS, HiddenType::class);

        return $this;
    }
}
