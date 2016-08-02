<?php
namespace backend\modules\location\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\location\models\{
    Country, CountryLang
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class CountryController extends BackendController
{
    public $model = Country::class;
    public $modelLang = CountryLang::class;
    public $title = 'Country';
}
