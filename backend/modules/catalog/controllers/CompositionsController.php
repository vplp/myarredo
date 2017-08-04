<?php

namespace backend\modules\catalog\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Collection, Category, Product, Types, Composition, CompositionLang, search\Composition as filterComposition
};

/**
 * Class CompositionsController
 *
 * @package backend\modules\catalog\controllers
 */
class CompositionsController extends BackendController
{
    public $model = Composition::class;
    public $modelLang = CompositionLang::class;
    public $filterModel = filterComposition::class;
    public $title = 'Compositions';
    public $name = 'compositions';

    /**
     * @return array
     */
    public function actionAjaxGetProducts()
    {
        $response = [];

        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {

            $change = Yii::$app->request->post('change');
            $selectedArray = Yii::$app->request->post('selectedArray');
            $selected_val_tovars = Yii::$app->request->post('selected_val_tovars');

            if ($change === 'factoryF') {
                $response['collection'] = Collection::dropDownList(['factory_id' => $selectedArray['factoryF']]);
            }
            if ($change === 'typeF') {
                $response['category'] = Category::dropDownList(['type_id' => $selectedArray['typeF']]);
            }

            $model = Product::getByIds($selected_val_tovars);

            $model = ArrayHelper::map($model, 'id', function ($item) {
                return  '[' . $item['article'] . '] ' . $item['lang']['title'];
            });

            $response['tovars'] = $model;
        }

        return $response;
    }
}