<?php
namespace backend\modules\menu\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\menu\models\{
    MenuItem, MenuItemLang, Menu
};

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 */
class ItemController extends BackendController
{
    public $model = MenuItem::class;
    public $modelLang = MenuItemLang::class;
    public $group = null;
    public $parent = null;
    public $title = 'Menu items';

    /**
     * Actions
     *
     * @return array
     */
    public function actions()
    {
        $link = function () {
            return Url::to(
                [
                    'list',
                    'group_id' => ($this->group !== null) ? $this->group->id : 0,
                    'parent_id' => ($this->parent !== null) ? $this->parent->id : 0
                ]
            );
        };

        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'layout' => 'crud',
                ],
                'trash' => [
                    'layout' => 'list-item-trash',
                ],
                'create' => [
                    'redirect' => function () {
                        return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id,
                            'group_id' => $this->group->id
                        ];
                    }
                ],
                'update' => [
                    'redirect' => function () {
                        return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id,
                            'group_id' => $this->group->id
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
//                'delete' => [
//                    'redirect' => $link
//                ],
            ]
        );
    }

    /**
     * Before actions
     *
     * @param $action
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeAction($action)
    {
        $groupId = Yii::$app->request->get('group_id', null);
        $parentId = Yii::$app->request->get('parent_id', null);

        if (in_array($action->id, ['list', 'create', 'update', 'trash'])) {
            if ($groupId === null) {
                throw new \yii\web\NotFoundHttpException;
            }
        }

        if ($groupId !== null) {
            $this->group = Menu::find()->byID($groupId)->one();
        }


        if ($parentId !== null) {
            $this->parent = MenuItem::find()->byID($parentId)->one();
        }

        return parent::beforeAction($action);
    }


}
