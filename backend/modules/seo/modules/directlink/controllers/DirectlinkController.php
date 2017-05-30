<?php

namespace backend\modules\seo\modules\directlink\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, Update, AttributeSwitch
};
//
use backend\modules\seo\modules\directlink\models\{
    Directlink, search\Directlink as filterModel
};

/**
 * Class InfoController
 *
 * @package backend\modules\seo\modules\info\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class DirectlinkController extends BackendController
{
    public $model = Directlink::class;
    public $filterModel = filterModel::class;
    public $title = 'Directlink';
    public $name = 'directlink';

    public function actions()
    {

        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => 'list-group',
            ],
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ],
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
