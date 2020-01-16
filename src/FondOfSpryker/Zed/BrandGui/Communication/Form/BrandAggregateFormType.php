<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Form;

use Generated\Shared\Transfer\BrandAggregateFormTransfer;
use Generated\Shared\Transfer\BrandCustomerRelationTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Spryker\Zed\ProductListGui\ProductListGuiConfig getConfig()
 * @method \Spryker\Zed\ProductListGui\Communication\ProductListGuiCommunicationFactory getFactory()
 */
class BrandAggregateFormType extends AbstractType
{
    public const OPTION_CUSTOMER_IDS = BrandCustomerRelationTransfer::CUSTOMER_IDS;

    public const BLOCK_PREFIX = 'brandAggregate';

    public const FIELD_ASSIGNED_CUSTOMER_IDS = BrandAggregateFormTransfer::ASSIGNED_CUSTOMER_IDS;
    public const FIELD_CUSTOMER_IDS_TO_BE_ASSIGNED = BrandAggregateFormTransfer::CUSTOMER_IDS_TO_BE_ASSIGNED;
    public const FIELD_CUSTOMER_IDS_TO_BE_DEASSIGNED = BrandAggregateFormTransfer::CUSTOMER_IDS_TO_BE_DE_ASSIGNED;

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setRequired(static::OPTION_CUSTOMER_IDS);

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
            ->addAssignedCustomerIdsField($builder)
            ->addCustomerIdsToBeAssignedField($builder)
            ->addCustomerIdsToBeDeassignedField($builder)
            ->addBrandSubForm($builder)
            ->addBrandCustomerRelationSubForm($builder, $options);

        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPreSubmit']);
    }

    /**
     * @param \Symfony\Component\Form\FormEvent $formEvent
     *
     * @return void
     */
    public function onPreSubmit(FormEvent $formEvent): void
    {
        $data = $formEvent->getData();
        $assignedCustomerIds = $data[static::FIELD_ASSIGNED_CUSTOMER_IDS_IDS]
            ? preg_split('/,/', $data[static::FIELD_ASSIGNED_CUSTOMER_IDS_IDS], null, PREG_SPLIT_NO_EMPTY)
            : [];
        $customerIdsToBeAssigned = $data[static::FIELD_CUSTOMER_IDS_TO_BE_ASSIGNED]
            ? preg_split('/,/', $data[static::FIELD_CUSTOMER_IDS_TO_BE_ASSIGNED], null, PREG_SPLIT_NO_EMPTY)
            : [];
        $customerIdsToBeDeassigned = $data[static::FIELD_CUSTOMER_IDS_TO_BE_DEASSIGNED]
            ? preg_split('/,/', $data[static::FIELD_CUSTOMER_IDS_TO_BE_DEASSIGNED], null, PREG_SPLIT_NO_EMPTY)
            : [];

        $assignedProductIds = array_unique(array_merge($assignedCustomerIds, $customerIdsToBeAssigned));
        $assignedProductIds = array_diff($assignedProductIds, $customerIdsToBeDeassigned);

        $formEvent->setData($data);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addAssignedCustomerIdsField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_ASSIGNED_CUSTOMER_IDS,
            HiddenType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCustomerIdsToBeAssignedField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_CUSTOMER_IDS_TO_BE_ASSIGNED,
            HiddenType::class
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCustomerIdsToBeDeassignedField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_CUSTOMER_IDS_TO_BE_DEASSIGNED,
            HiddenType::class
        );

        return $this;
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
     * @param array $options
     *
     * @return $this
     */
    protected function addBrandCustomerRelationSubForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            BrandAggregateFormTransfer::BRAND_CUSTOMER_RELATION,
            BrandCustomerRelationFormType::class,
            $this->getCustomerIdsOptions($options)
        );

        return $this;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function getCustomerIdsOptions(array $options): array
    {
        return [static::OPTION_CUSTOMER_IDS => $options[static::OPTION_CUSTOMER_IDS]];
    }
}
