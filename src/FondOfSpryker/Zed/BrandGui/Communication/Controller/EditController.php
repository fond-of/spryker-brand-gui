<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Controller;

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

    protected const ROUTE_REDIRTECT = '/product-brand/edit';

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
            return $this->viewResponse($this->executeEditAction($request, $brandAggregateForm));
        }

        exit('5');
        $productListResponseTransfer = $this->getFactory()
            ->getProductListFacade()
            ->updateProductList($productListTransfer);

        $this->addMessagesFromProductListResponseTransfer($productListResponseTransfer);

        if ($productListResponseTransfer->getIsSuccessful()) {
            $this->addSuccessMessage(static::MESSAGE_PRODUCT_LIST_UPDATE_SUCCESS, [
                '%s' => $productListTransfer->getTitle(),
            ]);
        }

        $redirectUrl = Url::generate(
            static::ROUTE_REDIRTECT,
            [static::URL_PARAM_ID_PRODUCT_LIST => $productListTransfer->getIdProductList()]
        )->build();

        return $this->redirectResponse($redirectUrl);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function availableProductConcreteTableAction(): JsonResponse
    {
        $availableProductConcreteTable = $this->getFactory()->createAvailableProductConcreteTable();

        return $this->jsonResponse(
            $availableProductConcreteTable->fetchData()
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function assignedProductConcreteTableAction(): JsonResponse
    {
        $assignedProductConcreteTable = $this->getFactory()->createAssignedProductConcreteTable();

        return $this->jsonResponse(
            $assignedProductConcreteTable->fetchData()
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Form\FormInterface $productListAggregateForm
     *
     * @return array
     */
    protected function executeEditAction(Request $request, FormInterface $productListAggregateForm)
    {
        $idBrand = $this->castId($request->get(static::URL_PARAM_ID_BRAND));
        $data = $this->prepareTemplateVariables($productListAggregateForm);
        $data['idBrand'] = $idBrand;

        return $data;
    }
}
