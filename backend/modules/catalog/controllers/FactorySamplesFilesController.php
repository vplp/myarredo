<?php

namespace backend\modules\catalog\controllers;

use common\actions\upload\DeleteAction;
use common\actions\upload\UploadAction;
use backend\modules\catalog\models\{
    FactorySamplesFiles, Factory, search\FactorySamplesFiles as filterFactorySamplesFiles
};
use thread\actions\Create;
use thread\actions\Update;
use thread\app\base\controllers\BackendController;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class FactorySamplesFilesController extends BackendController
{
    public $model = FactorySamplesFiles::class;
    public $modelLang = false;
    public $filterModel = filterFactorySamplesFiles::class;
    public $title = 'Factory';
    public $name = 'factory';

    public $factory = null;

    public function behaviors(): array
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
    public function actions(): array
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
                'path' => $this->module->getFactorySamplesFilesUploadPath(),
                'uploadOnlyImage' => false,
                'unique' => false
            ],
            'one-file-delete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getFactorySamplesFilesUploadPath()
            ],
            'fileupload' => [
                'class' => UploadAction::class,
                'path' => $this->module->getFactorySamplesFilesUploadPath() . '/thumb'
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'path' => $this->module->getFactorySamplesFilesUploadPath() . '/thumb'
            ],
        ]);
    }

    /**
     * @param \yii\base\Action $action
     * 
     * @return bool
     * 
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeAction($action): bool
    {
        $factory_id = Yii::$app->request->get('factory_id', null);

        if (in_array($action->id, ['list', 'create', 'update', 'trash'])) {
            if ($factory_id === null) {
                throw new \yii\web\NotFoundHttpException;
            }
        }

        if ($factory_id !== null) {
            $this->factory = Factory::getById($factory_id);
        }

        return parent::beforeAction($action);
    }
}