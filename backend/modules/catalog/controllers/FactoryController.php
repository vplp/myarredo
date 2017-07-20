<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\actions\AttributeSwitch;
//
use backend\modules\catalog\models\{
    Factory, FactoryLang, search\Factory as filterFactory
};

/**
 * Class FactoryController
 *
 * @package backend\modules\catalog\controllers
 */
class FactoryController extends BackendController
{
    public $model = Factory::class;
    public $modelLang = FactoryLang::class;
    public $filterModel = filterFactory::class;
    public $title = 'Factory';
    public $name = 'factory';

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'popular' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'popular',
                'redirect' => $this->defaultAction,
            ],
            'popular_by' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'popular_by',
                'redirect' => $this->defaultAction,
            ],
            'popular_ua' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'popular_ua',
                'redirect' => $this->defaultAction,
            ],
        ]);
    }
}
