<?php

namespace backend\modules\seo\modules\info\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\seo\modules\info\models\{
    Info, InfoLang, search\Info as filterModel
};

/**
 * Class InfoController
 *
 * @package backend\modules\seo\modules\info\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class InfoController extends BackendController
{
    public $model = Info::class;
    public $modelLang = InfoLang::class;
    public $filterModel = filterModel::class;
    public $title = 'Info';
    public $name = 'info';

    public function actions()
    {

        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => 'list-group',
            ],
        ]);
    }
}
