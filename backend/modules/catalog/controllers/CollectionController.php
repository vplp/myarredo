<?php

namespace backend\modules\catalog\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\web\NotFoundHttpException;
use thread\actions\{
    Create, Update
};
use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Collection, Factory, search\Collection as filterCollection
};

/**
 * Class CollectionController
 *
 * @package backend\modules\catalog\controllers
 */
class CollectionController extends BackendController
{
    public $model = Collection::class;
    public $filterModel = filterCollection::class;
    public $title = 'Collection';
    public $name = 'collection';

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
                throw new NotFoundHttpException();
            }
        }

        if ($factory_id !== null) {
            $this->factory = Factory::getById($factory_id);
        }

        return parent::beforeAction($action);
    }
}
