<?php

namespace backend\modules\location\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\location\models\{
    Currency,
    CurrencyLang,
    search\Currency as filterCurrencyModel
};

/**
 * Class CurrencyController
 *
 * @package backend\modules\location\controllers
 */
class CurrencyController extends BackendController
{
    public $model = Currency::class;
    public $modelLang = CurrencyLang::class;
    public $filterModel = filterCurrencyModel::class;
    public $title = 'Currency';
    public $name = 'currency';
}
