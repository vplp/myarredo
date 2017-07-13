<?php
namespace backend\modules\sys\modules\messages\controllers;

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\sys\modules\messages\models\{
    Messages, MessagesLang, search\Messages as filterMessagesModel
};

/**
 * Class MessagesController
 *
 * @package backend\modules\sys\modules\messages\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MessagesController extends BackendController
{
    public $model = Messages::class;
    public $modelLang = MessagesLang::class;
    public $filterModel = filterMessagesModel::class;
    public $title = 'Messages';
    public $name = 'messages';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => '//iframe'
            ],
            'update' => [
                'layout' => '//iframe'
            ]
        ]);
    }
}
