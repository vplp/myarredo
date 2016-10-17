<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
//
use thread\actions\fileapi\{
    DeleteAction, UploadAction
};
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\catalog\models\{
    Product, ProductLang, search\Product as filterProductModel
};

/**
 * Class ProductController
 *
 * @package backend\modules\catalog\controllers
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class ProductController extends BackendController
{
    public $model = Product::class;
    public $modelLang = ProductLang::class;
    public $filterModel = filterProductModel::class;
    public $title = 'Product';
    public $name = 'product';

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'fileupload' => [
                    'class' => UploadAction::class,
                    'path' => $this->module->getBaseProductUploadPath()
                ],
                'filedelete' => [
                    'class' => DeleteAction::class,
                    'path' => $this->module->getBaseProductUploadPath()
                ],
            ]
        );
    }

    /**
     * @param $id
     * @return string
     */
    public function actionGroup($id)
    {
        $model = Product::findOne(['id' => $id]);

        if ($model === null) {
            die();
        }
        $this->layout = 'product-group';

        return $this->render('parts/_group', ['model' => $model]);
    }
}