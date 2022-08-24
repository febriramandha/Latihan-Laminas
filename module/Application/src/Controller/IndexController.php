<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function tentangAction()
    {
        return new ViewModel();
    }

    public function kontakAction()
    {
        return new ViewModel();
    }
}
