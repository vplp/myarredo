<?php

namespace backend\modules\catalog\controllers;

use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Samples, SamplesLang, search\Samples as filterSamples
};

/**
 * Class SamplesController
 *
 * @package backend\modules\catalog\controllers
 */
class SamplesController extends BackendController
{
    public $model = Samples::class;
    public $modelLang = SamplesLang::class;
    public $filterModel = filterSamples::class;
    public $title = 'Samples';
    public $name = 'samples';

}
