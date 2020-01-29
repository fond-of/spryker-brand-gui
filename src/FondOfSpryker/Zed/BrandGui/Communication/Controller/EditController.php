<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Controller;

use Generated\Shared\Transfer\BrandTransfer;
use Spryker\Service\UtilText\Model\Url\Url;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \FondOfSpryker\Zed\BrandGui\Communication\BrandGuiCommunicationFactory getFactory()
 */
class EditController extends BrandAbstractController
{
    public const MESSAGE_BRAND_UPDATE_SUCCESS = 'Brand "%s" has been successfully updated.';

    protected const ROUTE_REDIRTECT = '/brand-gui/edit';

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

        if ($brandTransfer === null) {
            $brandTransfer = (new BrandTransfer())->setIdBrand(
                $this->castId($request->get(static::URL_PARAM_ID_BRAND))
            );

            return $this->viewResponse($this->executeEditAction($brandTransfer, $brandAggregateForm));
        }

        $brandResponseTransfer = $this->getFactory()
            ->getBrandFacade()
            ->updateBrand($brandTransfer);

        $this->addMessagesFromBrandResponseTransfer($brandResponseTransfer);

        if ($brandResponseTransfer->getIsSuccessful()) {
            $this->addSuccessMessage(static::MESSAGE_BRAND_UPDATE_SUCCESS, [
                '%s' => $brandTransfer->getTitle(),
            ]);
        }

        $redirectUrl = Url::generate(
            static::ROUTE_REDIRTECT,
            [static::URL_PARAM_ID_BRAND => $brandTransfer->getIdBrand()]
        )->build();

        return $this->redirectResponse($redirectUrl);
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Form\FormInterface $productListAggregateForm
     *
     * @return array
     */
    protected function executeEditAction(brandTransfer $brandTransfer, FormInterface $brandAggregateForm)
    {
        $data = $this->prepareTemplateVariables($brandAggregateForm);
        $data['idBrand'] = $brandTransfer->getIdBrand();

        $data['brandAggregationTabs'] = $this->getFactory()
        ->createBrandEditAggregationTabs()
        ->createView();

        return $data;
    }
}
