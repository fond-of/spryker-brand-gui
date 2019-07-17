<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Controller;

use Exception;
use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandForm;
use Generated\Shared\Transfer\BrandTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/**
 * @method \FondOfSpryker\Zed\BrandGui\Communication\BrandGuiCommunicationFactory getFactory()
 */
class BrandController extends AbstractController
{
    public const URL_PARAMETER_ID_BRAND = 'id-brand';
    public const URL_LIST_BRAND = '/brand-gui/brand/index';
    public const URL_UPDATE_BRAND = '/brand-gui/brand/update?id-brand=%d';

    protected const MESSAGE_BRAND_NOT_FOUND = "Brand couldn't be found";

    /**
     * @return array
     */
    public function indexAction()
    {
        $brandTable = $this->getFactory()->createBrandTable();

        return $this->viewResponse([
            'brandTable' => $brandTable->render(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction()
    {
        $brandTable = $this->getFactory()->createBrandTable();

        return $this->jsonResponse(
            $brandTable->fetchData()
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Exception
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $brandForm = $this->getFactory()
            ->createBrandForm()
            ->handleRequest($request);

        if ($brandForm->isSubmitted() && $brandForm->isValid()) {
            $formData = $brandForm->getData();

            try {
                $brandTransfer = (new BrandTransfer())->fromArray($formData, true);

                $brandResponseTransfer = $this->getFactory()->getBrandFacade()
                    ->addBrand($brandTransfer);

                if ($brandResponseTransfer->getIsSuccess() !== true) {
                    throw new Exception(
                        sprintf('Brand "%s" couldn\'t be added.', $formData[BrandForm::FIELD_NAME])
                    );
                }

                $this->addSuccessMessage(
                    sprintf('Brand "%s" successfully added.', $formData[BrandForm::FIELD_NAME])
                );

                $brandTransfer = $brandResponseTransfer->getBrandTransfer();

                return $this->redirectResponse(
                    sprintf(static::URL_UPDATE_BRAND, $brandTransfer->getIdBrand())
                );
            } catch (Exception $e) {
                $this->addErrorMessage($e->getMessage());
            }
        }

        return $this->viewResponse([
            'brandForm' => $brandForm->createView(),
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Exception
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request)
    {
        $idBrand = $this->castId($request->query->get(static::URL_PARAMETER_ID_BRAND));

        if (empty($idBrand)) {
            $this->addErrorMessage('Missing brand id!');

            return $this->redirectResponse(static::URL_LIST_BRAND);
        }

        $dataProvider = $this->getFactory()->createBrandFormDataProvider();
        $formData = $dataProvider->getData($idBrand);

        if (!$formData) {
            $this->addErrorMessage(static::MESSAGE_BRAND_NOT_FOUND);

            return $this->redirectResponse(static::URL_LIST_BRAND);
        }

        $brandForm = $this->getFactory()
            ->createBrandForm($formData)
            ->handleRequest($request);

        $brandTransfer = (new BrandTransfer())->fromArray($brandForm->getData(), true);

        if ($brandForm->isSubmitted() && $brandForm->isValid()) {
            try {
                $brandResponseTransfer = $this->getFactory()->getBrandFacade()
                    ->updateBrand($brandTransfer);

                if ($brandResponseTransfer->getIsSuccess() !== true) {
                    throw new Exception(
                        sprintf('Brand "%s" couldn\'t be updated.', $formData[BrandForm::FIELD_NAME])
                    );
                }

                $this->addSuccessMessage(
                    sprintf('Brand "%s" successfully updated.', $formData[BrandForm::FIELD_NAME])
                );

                $brandTransfer = $brandResponseTransfer->getBrandTransfer();

                return $this->redirectResponse(
                    sprintf(static::URL_UPDATE_BRAND, $brandTransfer->getIdBrand())
                );
            } catch (Exception $e) {
                $this->addErrorMessage($e->getMessage());
            }
        }

        return [
            'brandForm' => $brandForm->createView(),
            'brandTransfer' => $brandTransfer,
        ];
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        if (!$request->isMethod(Request::METHOD_DELETE)) {
            throw new MethodNotAllowedHttpException(
                [Request::METHOD_DELETE],
                'This action requires a DELETE request.'
            );
        }

        $idBrand = $this->castId($request->get(static::URL_PARAMETER_ID_BRAND));

        if (empty($idBrand)) {
            $this->addErrorMessage('Missing brand id!');

            return $this->redirectResponse(static::URL_LIST_BRAND);
        }

        $brandTransfer = (new BrandTransfer())->setIdBrand($idBrand);

        try {
            $this->getFactory()->getBrandFacade()->deleteBrand($brandTransfer);

            $this->addSuccessMessage('Brand was successfully removed.');
        } catch (Exception $e) {
            $this->addErrorMessage($e->getMessage());
        }

        return $this->redirectResponse(static::URL_LIST_BRAND);
    }
}
