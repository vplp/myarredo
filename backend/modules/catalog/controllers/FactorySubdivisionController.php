<?php

namespace backend\modules\catalog\controllers;

use backend\modules\user\models\User;
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
    FactorySubdivision, Factory, search\FactorySubdivision as filterFactorySubdivision
};

/**
 * Class FactorySubdivisionController
 *
 * @package backend\modules\catalog\controllers
 */
class FactorySubdivisionController extends BackendController
{
    public $model = FactorySubdivision::class;
    public $modelLang = false;
    public $filterModel = filterFactorySubdivision::class;
    public $title = 'FactorySubdivision';
    public $name = 'FactorySubdivision';

    public $user_id = null;

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
                    '/user/profile/update',
                    'id' => ($this->user_id !== null) ? $this->user_id : 0,
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
                            '/user/profile/update',
                            'id' => $this->user_id,
                        ]
                        : [
                            'update',
                            'user_id' => $this->user_id,
                            'id' => $this->action->getModel()->id,
                        ];
                }
            ],
            'update' => [
                'class' => Update::class,
                'redirect' => function () {
                    return ($_POST['save_and_exit'])
                        ? [
                            '/user/profile/update',
                            'id' => $this->user_id,
                        ]
                        : [
                            'update',
                            'user_id' => $this->user_id,
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
        $user_id = Yii::$app->request->get('user_id', null);

        if (in_array($action->id, ['list', 'create', 'update', 'trash'])) {
            if ($user_id === null) {
                throw new \yii\web\NotFoundHttpException();
            }
        }

        if ($user_id !== null) {
            $this->user_id = $user_id;
        }

        return parent::beforeAction($action);
    }
}
