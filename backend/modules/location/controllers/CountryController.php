<?php

namespace backend\modules\location\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\location\models\{
    Country,
    CountryLang,
    search\Country as filterCountryModel
};

/**
 * Class CountryController
 *
 * @package backend\modules\location\controllers
 */
class CountryController extends BackendController
{
    public $model = Country::class;
    public $modelLang = CountryLang::class;
    public $filterModel = filterCountryModel::class;
    public $title = 'Country';
    public $name = 'country';
}
