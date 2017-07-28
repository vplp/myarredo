<?php

namespace backend\modules\catalog\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Url
};
//
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Update, Create
};
use backend\modules\catalog\models\{
    FactoryFile, Factory, search\FactoryFile as filterFactoryFile
};

/**
 * Class FactoryFileController
 *
 * @package backend\modules\catalog\controllers
 */
class FactoryFileController extends BackendController
{
    public $model = FactoryFile::class;
    public $modelLang = false;
    public $filterModel = filterFactoryFile::class;
    public $title = 'Factory file';
    public $name = 'Factory file';

    public $factory = null;
    public $file_type = null;

    /**
     * @return array
     */
    public function actions()
    {
        $link = function () {
            return Url::to(
                [
                    '/catalog/factory/update',
                    'id' => ($this->factory !== null) ? $this->factory->id : 0,
                ]
            );
        };

        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'redirect' => $link
            ],
            'trash' => [
                'redirect' => $link
            ],
            'create' => [
                'class' => Create::class,
                'redirect' => function () {
                    return ($_POST['save_and_exit'])
                        ? [
                            '/catalog/factory/update',
                            'id' => $this->factory->id,
                        ]
                        : [
                            'update',
                            'factory_id' => $this->factory->id,
                            'id' => $this->action->getModel()->id,
                        ];
                }
            ],
            'update' => [
                'class' => Update::class,
                'redirect' => function () {
                    return ($_POST['save_and_exit'])
                        ? [
                            '/catalog/factory/update',
                            'id' => $this->factory->id,
                        ]
                        : [
                            'update',
                            'factory_id' => $this->factory->id,
                            'id' => $this->action->getModel()->id,
                        ];
                }
            ],
            'published' => [
                'redirect' => $link
            ],
            'intrash' => [
                'redirect' => $link
            ],
            'outtrash' => [
                'redirect' => $link
            ],
        ]);
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeAction($action)
    {
        $factory_id = Yii::$app->request->get('factory_id', null);
        $file_type = Yii::$app->request->get('file_type', null);

        if (in_array($action->id, ['list', 'create', 'update', 'trash'])) {
            if (($factory_id === null && $file_type === null) || !in_array($file_type, [1, 2])) {
                throw new \yii\web\NotFoundHttpException;
            }
        }

        if ($factory_id !== null) {
            $this->factory = Factory::getById($factory_id);
        }

        if ($file_type !== null && in_array($file_type, [1, 2])) {
            $this->file_type = $file_type;
        }

        return parent::beforeAction($action);
    }
}