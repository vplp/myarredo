<?php

namespace backend\modules\rules\controllers;

use backend\modules\rules\models\{
    Rules, RulesLang, search\Rules as filterRulesModel
};
//
use thread\app\base\controllers\BackendController;

/**
 * Class RulesController
 *
 * @package backend\modules\rules\controllers
 */
class RulesController extends BackendController
{
    public $model = Rules::class;
    public $modelLang = RulesLang::class;
    public $filterModel = filterRulesModel::class;
    public $title = 'General rules';
    public $name = 'rules';
}
