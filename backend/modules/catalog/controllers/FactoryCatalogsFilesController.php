<?php

namespace backend\modules\catalog\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\{
    ArrayHelper, Url
};
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Update, Create
};
use common\actions\upload\{
    DeleteAction, UploadAction
};
use backend\modules\catalog\models\{
    FactoryCatalogsFiles, Factory, search\FactoryCatalogsFiles as filterFactoryCatalogsFiles
};

/**
 * Class FactoryCatalogsFilesController
 *
 * @package backend\modules\catalog\controllers
 */
class FactoryCatalogsFilesController extends BackendController
{
    public $model = FactoryCatalogsFiles::class;
    public $modelLang = false;
    public $filterModel = filterFactoryCatalogsFiles::class;
    public $title = 'Factory';
    public $name = 'factory';

    public $factory = null;

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
                        'roles' => ['admin', 'catalogEditor'],
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
            'one-file-upload' => [
                'class' => UploadAction::class,
                'path' => $this->module->getFactoryCatalogsFilesUploadPath(),
                'uploadOnlyImage' => false,
                'unique' => false
            ],
            'one-file-delete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getFactoryCatalogsFilesUploadPath()
            ],
            'fileupload' => [
                'class' => UploadAction::class,
                'path' => $this->module->getFactoryCatalogsFilesUploadPath() . '/thumb'
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getFactoryCatalogsFilesUploadPath() . '/thumb'
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

        if (in_array($action->id, ['list', 'create', 'update', 'trash'])) {
            if ($factory_id === null) {
                throw new \yii\web\NotFoundHttpException();
            }
        }

        if ($factory_id !== null) {
            $this->factory = Factory::getById($factory_id);
        }

        return parent::beforeAction($action);
    }
}
