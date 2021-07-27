<?php

namespace backend\modules\seo\modules\directlink\controllers;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use thread\app\base\controllers\BackendController;
use thread\actions\AttributeSwitch;
use backend\modules\seo\modules\directlink\models\{
    Directlink, DirectlinkLang, search\Directlink as filterModel
};

/**
 * Class DirectlinkController
 *
 * @package backend\modules\seo\modules\directlink\controllers
 */
class DirectlinkController extends BackendController
{
    public $model = Directlink::class;
    public $modelLang = DirectlinkLang::class;
    public $filterModel = filterModel::class;
    public $title = 'Directlink';
    public $name = 'directlink';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'seo'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'add_to_sitemap' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'add_to_sitemap',
                'redirect' => $this->defaultAction,
            ],
            'dissallow_in_robotstxt' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'dissallow_in_robotstxt',
                'redirect' => $this->defaultAction,
            ],
        ]);
    }
}
