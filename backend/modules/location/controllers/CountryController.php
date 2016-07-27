<?php
namespace backend\modules\location\controllers;

use backend\modules\location\models\search\Country;
use backend\modules\location\models\CountryLang;
use thread\app\base\controllers\BackendController;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class CountryController extends BackendController
{
    public $model = Country::class;
    public $modelLang = CountryLang::class;
    public $title = 'Country';
}
