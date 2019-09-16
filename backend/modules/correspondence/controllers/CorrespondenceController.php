<?php

namespace backend\modules\correspondence\controllers;

use yii\helpers\ArrayHelper;
//
use thread\actions\{
    Create, Update
};
use thread\app\base\controllers\BackendController;
//
use backend\modules\correspondence\models\{
    Correspondence, search\Correspondence as filterCorrespondenceModel
};

/**
 * Class СorrespondenceController
 *
 * @package backend\modules\news\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class CorrespondenceController extends BackendController
{
    public $model = Correspondence::class;
    public $filterModel = filterCorrespondenceModel::class;
    public $title = 'Сorrespondence';
    public $name = 'correspondence';

    public function actions()
    {

        return ArrayHelper::merge(parent::actions(), [
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ],
        ]);
    }
}
