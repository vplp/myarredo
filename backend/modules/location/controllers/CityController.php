<?php

namespace backend\modules\location\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\location\models\{
    City,
    CityLang,
    search\City as filterCityModel
};

/**
 * Class CityController
 *
 * @package backend\modules\location\controllers
 */
class CityController extends BackendController
{
    public $model = City::class;
    public $modelLang = CityLang::class;
    public $filterModel = filterCityModel::class;
    public $title = 'City';
    public $name = 'city';
}
