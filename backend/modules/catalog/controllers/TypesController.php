<?php

namespace backend\modules\catalog\controllers;

use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Types, TypesLang, search\Types as filterTypes
};

/**
 * Class TypesController
 *
 * @package backend\modules\catalog\controllers
 */
class TypesController extends BackendController
{
    public $model = Types::class;
    public $modelLang = TypesLang::class;
    public $filterModel = filterTypes::class;
    public $title = 'Types';
    public $name = 'types';

}
