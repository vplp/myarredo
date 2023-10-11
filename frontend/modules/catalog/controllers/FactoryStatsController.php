<?php

namespace frontend\modules\catalog\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
//
use frontend\modules\catalog\models\Factory;
use frontend\modules\catalog\models\{
    Product, ProductStats, ProductStatsDays, FactoryStatsDays
};
use frontend\components\BaseController;

/**
 * Class FactoryStatsController
 *
 * @package frontend\modules\catalog\controllers
 */
class FactoryStatsController extends BaseController
{
    public $label = '';
    public $title = '';

    public $defaultAction = 'list';

    /**
     * @return array
     * @throws ForbiddenHttpException
     * @throws \Throwable
     */
    public function behaviors()
    {
        if (!Yii::$app->getUser()->isGuest &&
            Yii::$app->user->identity->group->role == 'factory' &&
            !Yii::$app->user->identity->profile->factory_id) {
            throw new ForbiddenHttpException(Yii::t('app', 'Access denied without factory id.'));
        }

        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get', 'post'],
                    'test' => ['get', 'post'],
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'factory'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionTest()
    {
        ini_set("memory_limit", "-1");
        set_time_limit(0);

        $model = new FactoryStatsDays();

        $params = Yii::$app->request->get() ?? [];

        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $params['factory_id'] = Yii::$app->user->identity->profile->factory_id;
        }

        $start_date = mktime(0, 0, 0, date("m"), date("d") - 30, date("Y"));
        $end_date = mktime(23, 59, 0, date("m"), date("d"), date("Y"));


        if (!isset($params['start_date'])) {
            $params['start_date'] = date('d-m-Y', $start_date);
        }

        if (!isset($params['end_date'])) {
            $params['end_date'] = date('d-m-Y', $end_date);
        }

        if (!isset($params['country_id'])) {
            $params['country_id'] = 0;
        }

        if (!isset($params['city_id'])) {
            $params['city_id'] = 0;
        }

        if (!isset($params['factory_id'])) {
            $params['factory_id'] = 0;
        }

        if (!isset($params['type'])) {
            $params['type'] = null;
        }

        $params['action'] = 'list';
        $factory_id = 21;
        $models = FactoryStatsDays::find()->where([
                'between',
                'date',
                strtotime($params['start_date'] . ' 0:00'),
                strtotime($params['end_date'] . ' 23:59')
            ])->andWhere(['factory_id'=>$factory_id])->all(); //$model->search($params);
        $q=array();
        foreach ($models as $key => $value) {
            if (!isset($q[$value->city_id])){
                $q[$value->city_id] = $value->views;
            } else {
                $q[$value->city_id] += $value->views;
            }
        }
        $models = ProductStatsDays::find()->where([
                'between',
                'date',
                strtotime($params['start_date'] . ' 0:00'),
                strtotime($params['end_date'] . ' 23:59')
            ])->andWhere(['factory_id'=>$factory_id])->all(); //$model->search($params);
        $w=array();
        foreach ($models as $key => $value) {
            if (!isset($w[$value->city_id])){
                $w[$value->city_id] = $value->views;
            } else {
                $w[$value->city_id] += $value->views;
            }
        }
        $keys = array();
        foreach ($q as $key => $value) {
            if ($value != $w[$key]) array_push($keys,$key);
        }
        $factory = $products = $f = $p = array();
        foreach ($keys as $key) {
            $models = FactoryStatsDays::find()->where([
                'between',
                'date',
                strtotime($params['start_date'] . ' 0:00'),
                strtotime($params['end_date'] . ' 23:59')
            ])->andWhere(['factory_id'=>$factory_id])->andWhere(['city_id'=>$key])->all();
            $factory[$key]=$models;
            $f[$key] = array();
            foreach ($models as $value) {
                if (!isset($f[$key][$value->date])){
                    $f[$key][$value->date] = $value->views;
                } else {
                    $f[$key][$value->date] += $value->views;
                }
            }
            
            $models = ProductStatsDays::find()->where([
                'between',
                'date',
                strtotime($params['start_date'] . ' 0:00'),
                strtotime($params['end_date'] . ' 23:59')
            ])->andWhere(['factory_id'=>$factory_id])->andWhere(['city_id'=>$key])->all();
            $products[$key]=$models;
            $p[$key] = array();
            foreach ($models as $value) {
                if (!isset($p[$key][$value->date])){
                    $p[$key][$value->date] = $value->views;
                } else {
                    $p[$key][$value->date] += $value->views;
                }
            }
        }
        $dates = array();
        foreach ($f as $city => $d) {
            $dates[$city] = array();
            foreach ($d as $date => $value) {
                if ($value != $p[$city][$date]) array_push($dates[$city],$date);
            }
            
        }
        /*$factory = $products = $f = $p = array();
        foreach ($dates as $date) {
            $models = FactoryStatsDays::find()->where(['date'=>$date])->andWhere(['factory_id'=>$factory_id])->andWhere(['city_id'=>$key])->all();
            $factory[$key]=$models;
            foreach ($models as $value) {
                if (!isset($f[$value->date])){
                    $f[$value->date] = $value->views;
                } else {
                    $f[$value->date] += $value->views;
                }
            }
            
            $models = ProductStatsDays::find()->where([
                'between',
                'date',
                strtotime($params['start_date'] . ' 0:00'),
                strtotime($params['end_date'] . ' 23:59')
            ])->andWhere(['factory_id'=>$factory_id])->andWhere(['city_id'=>$key])->all();
            $products[$key]=$models;
            foreach ($models as $value) {
                if (!isset($p[$value->date])){
                    $p[$value->date] = $value->views;
                } else {
                    $p[$value->date] += $value->views;
                }
            }
        }*/
        echo "<pre>"; var_dump($keys);echo "</pre>";
        echo "<pre>"; var_dump($dates);echo "</pre>";
        echo "<pre  111111111111111111111111 style='display:flex'><div style='width:50%'>"; var_dump($f);echo "</div><div style='width:50%'>";var_dump($p);echo "</div>";echo "</pre>";//echo "<pre>"; var_dump($models);echo "</pre>";
}
        public function actionList()
    {
        ini_set("memory_limit", "-1");
        set_time_limit(0);

        $model = new FactoryStatsDays();

        $params = Yii::$app->request->get() ?? [];

        if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->group->role == 'factory') {
            $params['factory_id'] = Yii::$app->user->identity->profile->factory_id;
        }

        $start_date = mktime(0, 0, 0, date("m"), date("d") - 30, date("Y"));
        $end_date = mktime(23, 59, 0, date("m"), date("d"), date("Y"));


        if (!isset($params['start_date'])) {
            $params['start_date'] = date('d-m-Y', $start_date);
        }

        if (!isset($params['end_date'])) {
            $params['end_date'] = date('d-m-Y', $end_date);
        }

        if (!isset($params['country_id'])) {
            $params['country_id'] = 0;
        }

        if (!isset($params['city_id'])) {
            $params['city_id'] = 0;
        }

        if (!isset($params['factory_id'])) {
            $params['factory_id'] = 0;
        }

        if (!isset($params['type'])) {
            $params['type'] = null;
        }

        $params['action'] = 'list';

        $models = $model->search($params);

        echo "<pre style='display:none' 111111111111111111111111>";var_dump($models->query->createCommand()->sql);echo "</pre>";
        $this->title = Yii::t('app', 'Factory statistics');

        return $this->render('list', [
            'model' => $model,
            'models' => $models->getModels(),
            'pages' => $models->getPagination(),
            'params' => $params,
        ]);
    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionView($alias)
    {
        $model = Factory::findByAlias($alias);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $modelProductStatsDays = new ProductStatsDays();

        $params = Yii::$app->request->get() ?? [];

        $params['factory_id'] = $model['id'];

        $start_date = mktime(0, 0, 0, date("m"), date("d") - 30, date("Y"));
        $end_date = mktime(23, 59, 0, date("m"), date("d"), date("Y"));

        if (!isset($params['start_date'])) {
            $params['start_date'] = date('d-m-Y', $start_date);
        }

        if (!isset($params['end_date'])) {
            $params['end_date'] = date('d-m-Y', $end_date);
        }

        if (!isset($params['country_id'])) {
            $params['country_id'] = 0;
        }

        if (!isset($params['city_id'])) {
            $params['city_id'] = 0;
        }

        if (!isset($params['type'])) {
            $params['type'] = null;
        }

        $params['action'] = 'view';

        $stats = $modelProductStatsDays->factorySearch($params);

        $this->title = Yii::t('app', 'Factory statistics');

        return $this->render('view', [
            'model' => $model,
            'params' => $params,
            'modelProductStatsDays' => $modelProductStatsDays,
            'modelsStats' => $stats->getModels(),
        ]);
    }
}
