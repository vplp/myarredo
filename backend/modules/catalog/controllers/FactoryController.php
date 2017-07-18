<?php

namespace backend\modules\catalog\controllers;

use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Factory, FactoryLang, search\Factory as filterFactory
};

/**
 * Class FactoryController
 *
 * @package backend\modules\catalog\controllers
 */
class FactoryController extends BackendController
{
    public $model = Factory::class;
    public $modelLang = FactoryLang::class;
    public $filterModel = filterFactory::class;
    public $title = 'Factory';
    public $name = 'factory';

}
