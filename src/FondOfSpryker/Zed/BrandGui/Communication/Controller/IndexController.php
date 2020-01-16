<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \FondOfSpryker\Zed\BrandGui\Communication\BrandGuiCommunicationFactory getFactory()
 */
class IndexController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array Twig variables
     */
    public function indexAction(Request $request): array
    {
        $table = $this->getFactory()->createBrandTable();

        return [
            'brandTable' => $table->render(),
        ];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction(): JsonResponse
    {
        $brandTable = $this->getFactory()->createBrandTable();

        return $this->jsonResponse(
            $brandTable->fetchData()
        );
    }
}
