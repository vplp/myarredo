<?php

namespace backend\modules\catalog\controllers;

use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Composition, CompositionLang, search\Composition as filterComposition
};

/**
 * Class CompositionsController
 *
 * @package backend\modules\catalog\controllers
 */
class CompositionsController extends BackendController
{
    public $model = Composition::class;
    public $modelLang = CompositionLang::class;
    public $filterModel = filterComposition::class;
    public $title = 'Compositions';
    public $name = 'compositions';
}