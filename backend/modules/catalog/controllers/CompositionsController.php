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
use backend\modules\catalog\models\{
    Collection, Category, Product, Composition, CompositionLang, search\Composition as filterComposition
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

            $model1 = Product::findBase()->asArray()->byID($selected_val_tovars)->all();

            $query = Product::findBase()->asArray();

            if ($selectedArray['factoryF']) {
                $query->andFilterWhere([Product::tableName() . '.factory_id' => $selectedArray['factoryF']]);
            }
            if ($selectedArray['typeF']) {
                $query->andFilterWhere([Product::tableName() . '.catalog_type_id' => $selectedArray['typeF']]);
            }

            $model2 = $query->all();

            $model = array_merge($model1, $model2);

            $response['tovars'] = ArrayHelper::map($model, 'id', function ($item) {
                return '[' . $item['article'] . '] ' . $item['lang']['title'];
            });
        }

        return $response;
    }
}
