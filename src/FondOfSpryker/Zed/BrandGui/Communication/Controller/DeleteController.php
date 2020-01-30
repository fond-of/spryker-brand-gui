<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Controller;

use Generated\Shared\Transfer\BrandTransfer;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \FondOfSpryker\Zed\BrandGui\Communication\BrandGuiCommunicationFactory getFactory()
 */
class DeleteController extends BrandAbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $idBrand = $this->castId($request->query->get(static::URL_PARAM_ID_BRAND));

        return $this->viewResponse([
            'idBrand' => $idBrand,
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function confirmAction(Request $request)
    {
        $defaultRedirectUrl = $this->getFactory()
            ->getConfig()
            ->getDefaultRedirectUrl();

        $redirectUrl = $request->query->get(
            static::URL_PARAM_REDIRECT_URL,
            $defaultRedirectUrl
        );

        $idBrand = $this->castId($request->query->get(static::URL_PARAM_ID_BRAND));
        $brandTransfer = (new BrandTransfer())->setIdBrand($idBrand);

        $brandResponseTransfer = $this->getFactory()
            ->getBrandFacade()
            ->removeBrand($brandTransfer);

        $this->addMessagesFromBrandResponseTransfer($brandResponseTransfer);

        return $this->redirectResponse($redirectUrl);
    }
}
