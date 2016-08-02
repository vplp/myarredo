<?php
namespace backend\modules\location\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\location\models\{
    Currency, CurrencyLang
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class CurrencyController extends BackendController
{
    public $model = Currency::class;
    public $modelLang = CurrencyLang::class;
    public $title = 'Currency';
}
