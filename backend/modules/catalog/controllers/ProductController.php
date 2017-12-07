<?php

namespace backend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
//
use common\actions\upload\{
    DeleteAction, UploadAction
};
//
use thread\app\base\controllers\BackendController;
use thread\actions\AttributeSwitch;
//
use backend\modules\catalog\models\{
    Collection, Category, Product, ProductLang, search\Product as filterProduct
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
        }

        return $response;
    }

//    /**
//     * Import Gallery photo
//     * @throws \Exception
//     */
//    public function actionImportGallery()
//    {
//        $models = Product::findBase()
//            ->limit(10)
//            ->where(['picpath' => '0'])
//            ->all();
//
//        foreach ($models as $model) {
//
//            if ($model->gallery_id) {
//
//                $photo = (new \yii\db\Query())
//                    ->from('c1myarredo_old.photo')
//                    ->where(['gallery_id' => $model->gallery_id])
//                    ->all();
//
//                /** @var PDO $transaction */
//                /** @var $model Product */
//                $transaction = $model::getDb()->beginTransaction();
//                try {
//                    $model->setScenario('gallery_image');
//
//                    $gallery_image = implode(',', ArrayHelper::map($photo, 'id', 'photopath'));
//                    $model->gallery_image = $gallery_image;
//                    $model->picpath = '1';
//
//                    if ($model->save()) {
//                        $transaction->commit();
//                    } else {
//                        $transaction->rollBack();
//                    }
//                } catch (\Exception $e) {
//                    $transaction->rollBack();
//                    throw new \Exception($e);
//                }
//            }
//        }
//    }

}
