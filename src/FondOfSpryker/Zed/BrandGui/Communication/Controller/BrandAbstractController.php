<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Controller;

use Generated\Shared\Transfer\BrandResponseTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \FondOfSpryker\Zed\BrandGui\Communication\BrandGuiCommunicationFactory getFactory()
 */
class BrandAbstractController extends AbstractController
{
    public const URL_PARAM_REDIRECT_URL = 'redirect-url';
    public const URL_PARAM_ID_BRAND = 'id-brand';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function createBrandAggregateForm(Request $request): FormInterface
    {
        $idBrand = $request->query->getInt(static::URL_PARAM_ID_BRAND);
        $aggregateFormDataProvider = $this
            ->getFactory()
            ->createBrandAggregateFormDataProvider();

        $aggregateForm = $this
            ->getFactory()
            ->getBrandAggregateForm(
                $aggregateFormDataProvider->getData($idBrand),
                $aggregateFormDataProvider->getOptions()
            );

        return $aggregateForm;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Form\FormInterface $aggregateForm
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|null
     */
    protected function findBrandTransfer(
        Request $request,
        FormInterface $aggregateForm
    ): ?BrandTransfer {
        $aggregateForm->handleRequest($request);

        if (!$aggregateForm->isSubmitted() || !$aggregateForm->isValid()) {
            return null;
        }

        /** @var \Generated\Shared\Transfer\BrandAggregateFormTransfer $aggregateFormTransfer */
        $aggregateFormTransfer = $aggregateForm->getData();

        $brandTransfer = $aggregateFormTransfer->getBrand();
        $brandTransfer
            ->setBrandCustomerRelation($aggregateFormTransfer->getBrandCustomerRelation())
            ->setBrandCompanyRelation($aggregateFormTransfer->getBrandCompanyRelation());

        return $brandTransfer;
    }

    /**
     * @return void
     */
    protected function addMessagesFromBrandResponseTransfer(BrandResponseTransfer $brandResponseTransfer): void
    {
        foreach ($brandResponseTransfer->getMessages() as $messageTransfer) {
            if ($brandResponseTransfer->getIsSuccessful()) {
                $this->addSuccessMessage($messageTransfer->getValue(), $messageTransfer->getParameters());

                continue;
            }

            $this->addErrorMessage($messageTransfer->getValue(), $messageTransfer->getParameters());
        }
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $productListAggregateForm
     *
     * @return array
     */
    protected function prepareTemplateVariables(FormInterface $brandAggregateForm): array
    {
        $assignedCustomerRelationTabs = $this->getFactory()->createAssignedCustomerRelationTabs();
        $availableCustomerRelationTabs = $this->getFactory()->createAvailableCustomerRelationTabs();
        $availableCustomerTable = $this->getFactory()->createAvailableCustomerTable();
        $assignedCustomerTable = $this->getFactory()->createAssignedCustomerTable();

        $assignedCompanyRelationTabs = $this->getFactory()->createAssignedCompanyRelationTabs();
        $availableCompanyRelationTabs = $this->getFactory()->createAvailableCompanyRelationTabs();
        $availableCompanyTable = $this->getFactory()->createAvailableCompanyTable();
        $assignedCompanyTable = $this->getFactory()->createAssignedCompanyTable();

        $assignedProductAbstractRelationTabs = $this->getFactory()->createAssignedProductAbstractRelationTabs();
        $availableProductAbstractRelationTabs = $this->getFactory()->createAvailableProductAbstractRelationTabs();
        $availableProductAbstractTable = $this->getFactory()->createAvailableProductAbstractTable();
        $assignedProductAbstractTable = $this->getFactory()->createAssignedProductAbstractTable();

        return [
            'aggregateForm' => $brandAggregateForm->createView(),
            'availableCustomerRelationTabs' => $availableCustomerRelationTabs->createView(),
            'assignedCustomerRelationTabs' => $assignedCustomerRelationTabs->createView(),
            'availableCustomerTable' => $availableCustomerTable->render(),
            'assignedCustomerTable' => $assignedCustomerTable->render(),
            'availableCompanyRelationTabs' => $availableCompanyRelationTabs->createView(),
            'assignedCompanyRelationTabs' => $assignedCompanyRelationTabs->createView(),
            'availableCompanyTable' => $availableCompanyTable->render(),
            'assignedCompanyTable' => $assignedCompanyTable->render(),
            'availableProductAbstractRelationTabs' => $availableProductAbstractRelationTabs->createView(),
            'assignedProductAbstractRelationTabs' => $assignedProductAbstractRelationTabs->createView(),
            'availableProductAbstractTable' => $availableProductAbstractTable->render(),
            'assignedProductAbstractTable' => $assignedProductAbstractTable->render(),
        ];
    }
}
