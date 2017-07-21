<?php

namespace backend\modules\catalog\controllers;

use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Specification, SpecificationLang, search\Specification as filterSpecification
};

/**
 * Class SpecificationController
 *
 * @package backend\modules\catalog\controllers
 */
class SpecificationController extends BackendController
{
    public $model = Specification::class;
    public $modelLang = SpecificationLang::class;
    public $filterModel = filterSpecification::class;
    public $title = 'Specification';
    public $name = 'specification';

}
