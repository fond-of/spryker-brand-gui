<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Controller;

use Spryker\Service\UtilText\Model\Url\Url;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \FondOfSpryker\Zed\BrandGui\Communication\BrandGuiCommunicationFactory getFactory()
 */
class CreateController extends BrandAbstractController
{
    public const MESSAGE_BRAND_CREATE_SUCCESS = 'Brand "%s" has been successfully created.';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $brandAggregateForm = $this->createBrandAggregateForm($request);
        $brandTransfer = $this->findBrandTransfer(
            $request,
            $brandAggregateForm
        );

        $viewData = $this->prepareTemplateVariables($brandAggregateForm);
        $viewData['brandAggregationTabs'] = $this->getFactory()
            ->createBrandCreateAggregationTabs()
            ->createView();

        if ($brandTransfer === null) {
            return $this->viewResponse($viewData);
        }

        $brandResponseTransfer = $this->getFactory()
            ->getBrandFacade()
            ->createBrand($brandTransfer);

        $this->addMessagesFromBrandResponseTransfer($brandResponseTransfer);

        if ($brandResponseTransfer->getIsSuccessful()) {
            $this->addSuccessMessage(static::MESSAGE_BRAND_CREATE_SUCCESS, [
                '%s' => $brandTransfer->getName(),
            ]);

            return $this->redirectResponse($this->getEditUrl($brandResponseTransfer->getBrand()->getIdBrand()));
        }

        $viewData = $this->prepareTemplateVariables($brandAggregateForm);
        $viewData['brandAggregationTabs'] = $this->getFactory()
            ->createBrandCreateAggregationTabs()
            ->createView();

        return $this->viewResponse();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function availableCustomerTableAction(): JsonResponse
    {
        $availableCustomerTable = $this->getFactory()->createAvailableCustomerTable();

        return $this->jsonResponse(
            $availableCustomerTable->fetchData()
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function assignedCustomerTableAction(): JsonResponse
    {
        $assignedCustomerTable = $this->getFactory()->createAssignedCustomerTable();

        return $this->jsonResponse(
            $assignedCustomerTable->fetchData()
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function availableCompanyTableAction(): JsonResponse
    {
        $availableCompanyTable = $this->getFactory()->createAvailableCompanyTable();

        return $this->jsonResponse(
            $availableCompanyTable->fetchData()
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function assignedCompanyTableAction(): JsonResponse
    {
        $assignedCompanyTable = $this->getFactory()->createAssignedCompanyTable();

        return $this->jsonResponse(
            $assignedCompanyTable->fetchData()
        );
    }

    /**
     * @param int $idBrand
     *
     * @return string
     */
    protected function getEditUrl(int $idBrand): string
    {
        $query = [
            static::URL_PARAM_ID_BRAND => $idBrand,
        ];

        return Url::generate(RoutingConstants::URL_EDIT, $query, [])->build();
    }
}
