<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Expander;

use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandCompanyRelationFormType;
use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandCustomerRelationFormType;
use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandProductAbstractRelationFormType;
use Generated\Shared\Transfer\BrandAggregateFormTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class BrandAggregateFormExpander implements BrandAggregateFormExpanderInterface
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    public function expandWithBrandAssignmentForms(FormBuilderInterface $builder): void
    {
        $this->addBrandCustomerRelationForm($builder)
            ->addBrandCompanyRelationForm($builder)
            ->addBrandProductAbstractRelationForm($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormEvent $formEvent
     *
     * @return void
     */
    public function postSubmitEventHandler(FormEvent $formEvent): void
    {
        $data = $formEvent->getData();

        $this->getCustomerData($formEvent);
        $this->getCompanyData($formEvent);
        $this->getProductAbstractData($formEvent);

        $formEvent->setData($data);
    }

    /**
     * @return void
     */
    protected function getCustomerData(FormEvent $formEvent): void
    {
        $assignedCustomerIdsData = $this->getFieldValue(BrandCustomerRelationFormType::FIELD_ASSIGNED_CUSTOMER_IDS, $formEvent);
        $customerIdsToBeAssignedData = $this->getFieldValue(BrandCustomerRelationFormType::FIELD_CUSTOMER_IDS_TO_BE_ASSIGNED, $formEvent);
        $customerIdsToBeDeassignedData = $this->getFieldValue(BrandCustomerRelationFormType::FIELD_CUSTOMER_IDS_TO_BE_DEASSIGNED, $formEvent);

        $assignedCustomerIds = $assignedCustomerIdsData
            ? preg_split('/,/', $assignedCustomerIdsData, null, PREG_SPLIT_NO_EMPTY)
            : [];

        $customerIdsToBeAssigned = $customerIdsToBeAssignedData
            ? preg_split('/,/', $customerIdsToBeAssignedData, null, PREG_SPLIT_NO_EMPTY)
            : [];
        $customerIdsToBeDeassigned = $customerIdsToBeDeassignedData
            ? preg_split('/,/', $customerIdsToBeDeassignedData, null, PREG_SPLIT_NO_EMPTY)
            : [];

        $assignedCustomerIds = array_unique(array_merge($assignedCustomerIds, $customerIdsToBeAssigned));
        $assignedCustomerIds = array_diff($assignedCustomerIds, $customerIdsToBeDeassigned);

        /** @var \Generated\Shared\Transfer\BrandAggregateFormTransfer $brandCustomerRelationTransfer */
        $brandCustomerRelationTransfer = $this->getFieldValue(BrandAggregateFormTransfer::BRAND_CUSTOMER_RELATION, $formEvent);
        $brandCustomerRelationTransfer->offsetSet(BrandCustomerRelationFormType::CUSTOMER_IDS, $assignedCustomerIds);
    }

    /**
     * @return void
     */
    protected function getCompanyData(FormEvent $formEvent): void
    {
        $assignedCompanyIdsData = $this->getFieldValue(BrandCompanyRelationFormType::FIELD_ASSIGNED_COMPANY_IDS, $formEvent);
        $companyIdsToBeAssignedData = $this->getFieldValue(BrandCompanyRelationFormType::FIELD_COMPANY_IDS_TO_BE_ASSIGNED, $formEvent);
        $companyIdsToBeDeassignedData = $this->getFieldValue(BrandCompanyRelationFormType::FIELD_COMPANY_IDS_TO_BE_DEASSIGNED, $formEvent);

        $assignedCompanyIds = $assignedCompanyIdsData
            ? preg_split('/,/', $assignedCompanyIdsData, null, PREG_SPLIT_NO_EMPTY)
            : [];

        $companyIdsToBeAssigned = $companyIdsToBeAssignedData
            ? preg_split('/,/', $companyIdsToBeAssignedData, null, PREG_SPLIT_NO_EMPTY)
            : [];
        $companyIdsToBeDeassigned = $companyIdsToBeDeassignedData
            ? preg_split('/,/', $companyIdsToBeDeassignedData, null, PREG_SPLIT_NO_EMPTY)
            : [];

        $assignedCompanyIds = array_unique(array_merge($assignedCompanyIds, $companyIdsToBeAssigned));
        $assignedCompanyIds = array_diff($assignedCompanyIds, $companyIdsToBeDeassigned);

        /** @var \Generated\Shared\Transfer\BrandAggregateFormTransfer $brandCompanyRelationTransfer */
        $brandCompanyRelationTransfer = $this->getFieldValue(BrandAggregateFormTransfer::BRAND_COMPANY_RELATION, $formEvent);
        $brandCompanyRelationTransfer->offsetSet(BrandCompanyRelationFormType::COMPANY_IDS, $assignedCompanyIds);
    }

    /**
     * @return void
     */
    protected function getProductAbstractData(FormEvent $formEvent): void
    {
        $assignedProductAbstractIdsData = $this->getFieldValue(BrandProductAbstractRelationFormType::FIELD_ASSIGNED_PRODUCT_ABSTRACT_IDS, $formEvent);
        $productAbstractIdsToBeAssignedData = $this->getFieldValue(BrandProductAbstractRelationFormType::FIELD_PRODUCT_ABSTRACT_IDS_TO_BE_ASSIGNED, $formEvent);
        $productAbstractIdsToBeDeassignedData = $this->getFieldValue(BrandProductAbstractRelationFormType::FIELD_PRODUCT_ABSTRACT_IDS_TO_BE_DEASSIGNED, $formEvent);

        $assignedProductAbstractIds = $assignedProductAbstractIdsData
            ? preg_split('/,/', $assignedProductAbstractIdsData, null, PREG_SPLIT_NO_EMPTY)
            : [];

        $productAbstractIdsToBeAssigned = $productAbstractIdsToBeAssignedData
            ? preg_split('/,/', $productAbstractIdsToBeAssignedData, null, PREG_SPLIT_NO_EMPTY)
            : [];
        $productAbstractIdsToBeDeassigned = $productAbstractIdsToBeDeassignedData
            ? preg_split('/,/', $productAbstractIdsToBeDeassignedData, null, PREG_SPLIT_NO_EMPTY)
            : [];

        $assignedProductAbstractIds = array_unique(array_merge($assignedProductAbstractIds, $productAbstractIdsToBeAssigned));
        $assignedProductAbstractIds = array_diff($assignedProductAbstractIds, $productAbstractIdsToBeDeassigned);

        /** @var \Generated\Shared\Transfer\BrandAggregateFormTransfer $brandProductAbstractRelationTransfer */
        $brandProductAbstractRelationTransfer = $this->getFieldValue(BrandAggregateFormTransfer::BRAND_PRODUCT_ABSTRACT_RELATION, $formEvent);
        $brandProductAbstractRelationTransfer->offsetSet(BrandProductAbstractRelationFormType::PRODUCT_ABSTRACT_IDS, $assignedProductAbstractIds);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBrandCustomerRelationForm(FormBuilderInterface $builder)
    {
        $builder->add(
            BrandAggregateFormTransfer::BRAND_CUSTOMER_RELATION,
            BrandCustomerRelationFormType::class
        );

        $this->addBrandCustomerRelationFormHelperFields($builder);
        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'postSubmitEventHandler']);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    protected function addBrandCustomerRelationFormHelperFields(FormBuilderInterface $builder): void
    {
        $builder->add(
            BrandCustomerRelationFormType::FIELD_ASSIGNED_CUSTOMER_IDS,
            HiddenType::class
        );

        $builder->add(
            BrandCustomerRelationFormType::FIELD_CUSTOMER_IDS_TO_BE_ASSIGNED,
            HiddenType::class
        );

        $builder->add(
            BrandCustomerRelationFormType::FIELD_CUSTOMER_IDS_TO_BE_DEASSIGNED,
            HiddenType::class
        );
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBrandCompanyRelationForm(FormBuilderInterface $builder)
    {
        $builder->add(
            BrandAggregateFormTransfer::BRAND_COMPANY_RELATION,
            BrandCompanyRelationFormType::class
        );

        $this->addBrandCompanyRelationFormHelperFields($builder);
        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'postSubmitEventHandler']);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    protected function addBrandCompanyRelationFormHelperFields(FormBuilderInterface $builder): void
    {
        $builder->add(
            BrandCompanyRelationFormType::FIELD_ASSIGNED_COMPANY_IDS,
            HiddenType::class
        );

        $builder->add(
            BrandCompanyRelationFormType::FIELD_COMPANY_IDS_TO_BE_ASSIGNED,
            HiddenType::class
        );

        $builder->add(
            BrandCompanyRelationFormType::FIELD_COMPANY_IDS_TO_BE_DEASSIGNED,
            HiddenType::class
        );
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBrandProductAbstractRelationForm(FormBuilderInterface $builder)
    {
        $builder->add(
            BrandAggregateFormTransfer::BRAND_PRODUCT_ABSTRACT_RELATION,
            BrandProductAbstractRelationFormType::class
        );

        $this->addBrandProductAbstractRelationFormHelperFields($builder);
        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'postSubmitEventHandler']);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    protected function addBrandProductAbstractRelationFormHelperFields(FormBuilderInterface $builder): void
    {
        $builder->add(
            BrandProductAbstractRelationFormType::FIELD_ASSIGNED_PRODUCT_ABSTRACT_IDS,
            HiddenType::class
        );

        $builder->add(
            BrandProductAbstractRelationFormType::FIELD_PRODUCT_ABSTRACT_IDS_TO_BE_ASSIGNED,
            HiddenType::class
        );

        $builder->add(
            BrandProductAbstractRelationFormType::FIELD_PRODUCT_ABSTRACT_IDS_TO_BE_DEASSIGNED,
            HiddenType::class
        );
    }

    /**
     * @param string $fieldName
     * @param \Symfony\Component\Form\FormEvent $formEvent
     *
     * @return mixed
     */
    protected function getFieldValue(string $fieldName, FormEvent $formEvent)
    {
        return $this->getFieldValueByPropertyPath(
            $formEvent->getData(),
            $formEvent->getForm()
                ->get($fieldName)
                ->getPropertyPath()
                ->__toString()
        );
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $abstractTransfer
     * @param string $propertyPath
     *
     * @return mixed
     */
    protected function getFieldValueByPropertyPath(AbstractTransfer $abstractTransfer, string $propertyPath)
    {
        $current = $abstractTransfer;

        foreach (explode('.', $propertyPath) as $key) {
            $current = $current->offsetGet($key);
        }

        return $current;
    }
}
