<?php

namespace backend\modules\sys\modules\mailcarrier\controllers;

use yii\helpers\ArrayHelper;
//
use thread\actions\{
    EditableAttributeSave, EditableAttributeSaveLang
};
use thread\app\base\controllers\BackendController;
//
use backend\modules\sys\modules\mailcarrier\models\{
    MailCarrier, MailCarrierLang, search\MailCarrier as filterGrowlModel
};

/**
 * Class MailBoxController
 *
 * @package backend\modules\sys\modules\mailcarrier\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MailCarrierController extends BackendController
{
    public $model = MailCarrier::class;
    public $modelLang = MailCarrierLang::class;
    public $filterModel = filterGrowlModel::class;
    public $title = 'MailCarrier';
    public $name = 'mailcarrier';

    /**
     * @return array
     */
    public function actions()
    {

        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => 'list-mail-carrier',
            ],
            'attribute-save' => [
                'class' => EditableAttributeSaveLang::class,
                'modelClass' => $this->modelLang,
                'attribute' => 'title',
            ],
            'attribute-save-mailbox' => [
                'class' => EditableAttributeSave::class,
                'modelClass' => $this->model,
                'attribute' => 'mailbox_id',
                'returnValue' => function ($model) {
                    return $model['mailbox']['lang']['title']??'---';
                }
            ]
        ]);
    }
}
