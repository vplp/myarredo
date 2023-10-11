<?php

namespace backend\modules\menu\controllers;

use Yii;
use yii\helpers\{
    ArrayHelper, Url
};
//
use thread\actions\EditableAttributeSaveLang;
use thread\app\base\controllers\BackendController;
//
use backend\modules\menu\models\{
    MenuItem, MenuItemLang, Menu, search\MenuItem as filterMenuItemModel
};

/**
 * Class ItemController
 *
 * @package backend\modules\menu\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ItemController extends BackendController
{
    public $model = MenuItem::class;
    public $modelLang = MenuItemLang::class;
    public $filterModel = filterMenuItemModel::class;
    public $group = null;
    public $parent = null;
    public $title = 'Items';
    public $name = 'item';

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
                    'layout' => 'list-item',
                ],
                'trash' => [
                    'layout' => 'list-item-trash',
                ],
                'create' => [
                    'layout' => 'create',
                    'redirect' => function () {
                        return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id,
                            'group_id' => $this->group->id
                        ];
                    }
                ],
                'update' => [
                    'layout' => 'update',
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
                'attribute-save' => [
                    'class' => EditableAttributeSaveLang::class,
                    'modelClass' => $this->modelLang,
                    'attribute' => 'title',
                ]
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
                throw new \yii\web\NotFoundHttpException();
            }
        }

        if ($groupId !== null) {
            $this->group = Menu::getById($groupId);
        }

        if ($parentId !== null) {
            $this->parent = MenuItem::getById($parentId);
        }

        return parent::beforeAction($action);
    }
}
