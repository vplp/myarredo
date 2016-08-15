<?php
namespace backend\modules\configs\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\configs\models\{
    Params, ParamsLang, search\Params as filterParamsModel
};

/**
 * Class ParamsController
 *
 * @package backend\modules\configs\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ParamsController extends BackendController
{
    public $model = Params::class;
    public $modelLang = ParamsLang::class;
    public $filterModel = filterParamsModel::class;
    public $title = 'Params';
}
