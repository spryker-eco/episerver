<?php

namespace SprykerEco\Zed\Optivo\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \SprykerEco\Zed\Optivo\Business\OptivoFacade getFacade()
 * @method \SprykerEco\Zed\Optivo\Communication\OptivoCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoQueryContainer getQueryContainer()
 */
class IndexController extends AbstractController
{

    /**
     * @return array
     */
    public function indexAction()
    {
        return $this->viewResponse([
            'test' => 'Greetings!',
        ]);
    }

}
