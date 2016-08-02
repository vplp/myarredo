<?php
namespace backend\modules\location\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\location\models\{
    City, CityLang
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class CityController extends BackendController
{
    public $model = City::class;
    public $modelLang = CityLang::class;
    public $title = 'City';
}
