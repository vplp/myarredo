<?php
namespace backend\modules\location\controllers;

use backend\modules\location\models\search\City;
use backend\modules\location\models\CityLang;
use thread\app\base\controllers\BackendController;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class CityController extends BackendController
{
    public $model = City::class;
    public $modelLang = CityLang::class;
    public $title = 'City';
}
