<?php

namespace backend\modules\location\controllers;

use thread\actions\AttributeSwitch;
use thread\app\base\controllers\BackendController;
//
use backend\modules\location\models\{
    Country,
    CountryLang,
    search\Country as filterCountryModel
};
use yii\helpers\ArrayHelper;

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

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'show-for-registration' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'show_for_registration',
                'redirect' => $this->defaultAction,
            ],
            'show-for-filter' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'show_for_filter',
                'redirect' => $this->defaultAction,
            ],
        ]);
    }
}
