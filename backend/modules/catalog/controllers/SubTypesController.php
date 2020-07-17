<?php

namespace backend\modules\catalog\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Types, SubTypes, SubTypesLang, search\SubTypes as filterSubTypes
};

/**
 * Class SubTypesController
 *
 * @package backend\modules\catalog\controllers
 */
class SubTypesController extends BackendController
{
    public $model = SubTypes::class;

    public $modelLang = SubTypesLang::class;

    public $filterModel = filterSubTypes::class;

    public $title = 'Типы';

    public $name = 'subjects';

    public $parent = null;

    /**
     * @return array
     */
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
                    'list',
                    'parent_id' => ($this->parent !== null) ? $this->parent->id : 0
                ]
            );
        };

        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'layout' => (isset($_GET['parent_id']))  ? 'list-types' : '/list',
                ],
                'create' => [
                    'redirect' => function () {
                        return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id,
                            'parent_id' => $this->parent->id
                        ];
                    }
                ],
                'update' => [
                    'redirect' => function () {
                        return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id,
                            'parent_id' => $this->parent->id
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
            ]
        );
    }

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $parentId = Yii::$app->request->get('parent_id', null);

        if ($parentId !== null) {
            $this->parent = Types::getById($parentId);
        }

        return parent::beforeAction($action);
    }
}
