<?php

namespace frontend\modules\catalog\controllers;

use frontend\modules\location\models\City;
use Yii;
use yii\helpers\{
    ArrayHelper, Url
};
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
//
use frontend\components\BaseController;
use frontend\modules\catalog\models\{
    FactoryPromotion,
    search\FactoryPromotion as filterFactoryPromotionModel,
    FactoryProduct,
    search\FactoryProduct as filterFactoryProductModel,
    FactoryPromotionRelProduct
};
//
use thread\actions\{
    ListModel,
    AttributeSwitch
};

/**
 * Class FactoryPromotionController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryPromotionController extends BaseController
{
    public $title = '';

    public $defaultAction = 'list';

    protected $model = FactoryPromotion::class;
    protected $filterModel = filterFactoryPromotionModel::class;

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
                        'roles' => ['factory'],
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
        $this->title = Yii::t('app', 'Рекламная компания');

        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model,
                    'filterModel' => $this->filterModel,
                ],
                'intrash' => [
                    'class' => AttributeSwitch::class,
                    'modelClass' => $this->model,
                    'attribute' => 'deleted',
                    'redirect' => $this->defaultAction,
                ],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model = new FactoryPromotion();

        $modelFactoryProduct = new FactoryProduct();
        $filterModelFactoryProduct = new filterFactoryProductModel();

        $filterModelFactoryProduct->load(Yii::$app->getRequest()->get());

        $dataProviderFactoryProduct = $modelFactoryProduct->search(ArrayHelper::merge(Yii::$app->getRequest()->get(), ['pagination' => false]));
        $dataProviderFactoryProduct->sort = false;

        $model->scenario = 'frontend';

        if ($model->isNewRecord) {
            $model->count_of_months = 1;
            $model->daily_budget = 500;
        }

        if ($model->load(Yii::$app->getRequest()->post())) {
            $transaction = $model::getDb()->beginTransaction();
            try {

                $model->user_id = Yii::$app->user->identity->id;
                $model->status = 1;
                $model->published = 1;

                $save = $model->save();

                if ($save) {
                    $transaction->commit();

                    return $this->redirect(Url::toRoute(['/catalog/factory-promotion/update', 'id' => $model->id]));
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->render('_form', [
            'model' => $model,
            'dataProviderFactoryProduct' => $dataProviderFactoryProduct,
            'filterModelFactoryProduct' => $filterModelFactoryProduct,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $model = FactoryPromotion::findById($id);

        /** @var $model FactoryPromotion */

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $modelFactoryProduct = new FactoryProduct();
        $filterModelFactoryProduct = new filterFactoryProductModel();

        $filterModelFactoryProduct->load(Yii::$app->getRequest()->get());

        $dataProviderFactoryProduct = $modelFactoryProduct->search(ArrayHelper::merge(Yii::$app->getRequest()->get(), ['pagination' => false]));
        $dataProviderFactoryProduct->sort = false;

        $model->scenario = 'frontend';

        if ($model->load(Yii::$app->getRequest()->post())) {
            $transaction = $model::getDb()->beginTransaction();
            try {

                $save = $model->save();

                if ($save) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        $cities = [];
        foreach ($model->city_ids as $city_id) {
            $city = City::findById($city_id);

            $cities[$city->country_id][] = $city_id;
        }
        $model->city_ids = $cities;

        return $this->render('_form', [
            'model' => $model,
            'dataProviderFactoryProduct' => $dataProviderFactoryProduct,
            'filterModelFactoryProduct' => $filterModelFactoryProduct,
        ]);
    }

//    /**
//     * @inheritdoc
//     */
//    public function actionAjaxAddProduct()
//    {
//        if (Yii::$app->request->isAjax) {
//            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
//
//            $promotion_id = Yii::$app->getRequest()->post('promotion_id');
//            $catalog_item_id = Yii::$app->getRequest()->post('catalog_item_id');
//
//            $model = new FactoryPromotionRelProduct();
//
//            $model->setScenario('backend');
//
//            $model->promotion_id = $promotion_id;
//            $model->catalog_item_id = $catalog_item_id;
//
//            if ($model->save()) {
//                return true;
//            }
//
//            return false;
//        }
//    }

//    /**
//     * @inheritdoc
//     */
//    public function actionAjaxDelProduct()
//    {
//        if (Yii::$app->request->isAjax) {
//            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
//
//            $promotion_id = Yii::$app->getRequest()->post('promotion_id');
//            $catalog_item_id = Yii::$app->getRequest()->post('catalog_item_id');
//
//            $model = FactoryPromotionRelProduct::findBase()
//                ->where([
//                    'promotion_id' => $promotion_id,
//                    'catalog_item_id' => $catalog_item_id,
//                ])
//                ->one();
//
//            if ($model != null && $model->delete()) {
//                return true;
//            }
//
//            return false;
//        }
//    }
}
