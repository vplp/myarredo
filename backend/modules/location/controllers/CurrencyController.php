<?php
namespace backend\modules\location\controllers;

use backend\modules\location\models\search\Currency;
use backend\modules\location\models\CurrencyLang;
use thread\app\base\controllers\BackendController;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class CurrencyController extends BackendController
{
    public $model = Currency::class;
    public $modelLang = CurrencyLang::class;
    public $title = 'Currency';
}
