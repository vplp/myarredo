<?php

namespace backend\modules\sys\modules\mailcarrier\controllers;

use yii\helpers\ArrayHelper;
//
use thread\actions\EditableAttributeSaveLang;
use thread\app\base\controllers\BackendController;
//
use backend\modules\sys\modules\mailcarrier\models\{
    MailBox, MailBoxLang, search\MailBox as filterGrowlModel
};

/**
 * Class MailBoxController
 *
 * @package backend\modules\sys\modules\mailcarrier\controllers
 */
class MailBoxController extends BackendController
{
    public $model = MailBox::class;
    public $modelLang = MailBoxLang::class;
    public $filterModel = filterGrowlModel::class;
    public $title = 'MailBox';
    public $name = 'mailbox';

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => 'list-mail-box',
            ],
            'attribute-save' => [
                'class' => EditableAttributeSaveLang::class,
                'modelClass' => $this->modelLang,
                'attribute' => 'title',
            ]
        ]);
    }
}
