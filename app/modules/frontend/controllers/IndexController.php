<?php
declare(strict_types=1);

namespace Test1\Modules\Frontend\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction($param ='test' )
    {
    $this->view->setVar('hello',$param);
    }

}

