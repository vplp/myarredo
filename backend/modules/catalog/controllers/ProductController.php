<?php

namespace backend\modules\catalog\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use common\actions\upload\{
    DeleteAction, UploadAction
};
use thread\app\base\controllers\BackendController;
use thread\actions\AttributeSwitch;
use backend\modules\catalog\models\{
    Collection,
    Category,
    Product,
    ProductLang,
    search\Product as filterProduct,
    SubTypes
};

/**
 * Class ProductController
 *
 * @package backend\modules\catalog\controllers
 */
class ProductController extends BackendController
{
    public $model = Product::class;
    public $modelLang = ProductLang::class;
    public $filterModel = filterProduct::class;
    public $title = 'Product';
    public $name = 'product';

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
        return ArrayHelper::merge(parent::actions(), [
            'popular' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'popular',
                'redirect' => $this->defaultAction,
            ],
            'novelty' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'novelty',
                'redirect' => $this->defaultAction,
            ],
            'bestseller' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'bestseller',
                'redirect' => $this->defaultAction,
            ],
            'onmain' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'onmain',
                'redirect' => $this->defaultAction,
            ],
            'removed' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'removed',
                'redirect' => $this->defaultAction,
            ],
            'fileupload' => [
                'class' => UploadAction::class,
                'useHashPath' => true,
                'path' => $this->module->getProductUploadPath()
            ],
            'filedelete' => [
                'class' => DeleteAction::class,
                'useHashPath' => true,
                'path' => $this->module->getProductUploadPath()
            ],
        ]);
    }

    /**
     * @return array
     */
    public function actionAjaxGetCollection()
    {
        $response = [];
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax && $factory_id = Yii::$app->request->post('factory_id')) {
            $response['collection'] = Collection::dropDownList(['factory_id' => $factory_id]);
        }

        return $response;
    }

    /**
     * @return array
     */
    public function actionAjaxGetCategory()
    {
        $response = [];
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax && $type_id = Yii::$app->request->post('type_id')) {
            $response['category'] = Category::dropDownList(['type_id' => $type_id]);
            $response['subtypes'] = SubTypes::dropDownList(['parent_id' => $type_id]);
        }

        return $response;
    }
}
