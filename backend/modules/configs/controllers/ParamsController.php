<?php
namespace backend\modules\configs\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\configs\models\{
    Params, ParamsLang, search\Params as filterParamsModel
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class ParamsController extends BackendController
{
    public $model = Params::class;
    public $modelLang = ParamsLang::class;
    public $filterModel = filterParamsModel::class;
    public $title = 'Params';
}
