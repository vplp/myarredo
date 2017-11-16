<?php

namespace backend\modules\seo\modules\directlink\controllers;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, Update, AttributeSwitch
};
//
use backend\modules\seo\modules\directlink\models\{
    Directlink, search\Directlink as filterModel
};

/**
 * Class DirectlinkController
 *
 * @package backend\modules\seo\modules\directlink\controllers
 */
class DirectlinkController extends BackendController
{
    public $model = Directlink::class;
    public $filterModel = filterModel::class;
    public $title = 'Directlink';
    public $name = 'directlink';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'layout' => 'list-group',
            ],
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ],
            'add_to_sitemap' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'add_to_sitemap',
                'redirect' => $this->defaultAction,
            ],
            'dissallow_in_robotstxt' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'dissallow_in_robotstxt',
                'redirect' => $this->defaultAction,
            ],
        ]);
    }

    public function actionImport()
    {
        Directlink::deleteAll();

        /**
         * Urlmap
         */

        $rows = (new \yii\db\Query())
            ->from("c1myarredo_old.urlmap")
            ->leftJoin("c1myarredo_old.urlmap_lang", "urlmap_lang.rid = urlmap.id AND urlmap_lang.language_code = 'ru'")
            ->all();

        Yii::$app->db->createCommand('ALTER TABLE ' . Directlink::tableName() . ' AUTO_INCREMENT = 1')->execute();

        foreach ($rows as $row) {

            $model = new Directlink();
            $model->setScenario('backend');

            $model->url = "/catalog/" . $row['url'];
            $model->title = $row['h1'];
            $model->description = $row['h1'] ?? "";
            $model->keywords = "";
            $model->text = $row['text_ru'] ?? "";
            $model->image_url = "";
            $model->published = 1;

            /** @var PDO $transaction */
            $transaction = $model::getDb()->beginTransaction();
            try {

                if (!$model->save()) {
                    /* !!! */
                    echo '<pre style="color:red;">';
                    print_r($model->getErrors());
                    echo '</pre>';
                    /* !!! */
                    die();
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }


        /**
         * Seo
         */

        $rows = (new \yii\db\Query())
            ->from("c1myarredo_old.seo")
            ->leftJoin("c1myarredo_old.seo_lang", "seo_lang.rid = seo.id AND seo_lang.language_code = 'ru'")
            ->where("seo.city_id = 1")
            ->all();

        foreach ($rows as $row) {

            $model = new Directlink();
            $model->setScenario('backend');

            $model->url = $row['url'];
            $model->title = $row['h1'];
            $model->description = $row['description'] ?? "";
            $model->keywords = $row['keywords'] ?? "";
            $model->text = $row['text'] ?? "";
            $model->image_url = "";
            $model->published = 1;

            /** @var PDO $transaction */
            $transaction = $model::getDb()->beginTransaction();
            try {

                if (!$model->save()) {
                    /* !!! */
                    echo '<pre style="color:red;">';
                    print_r($model->getErrors());
                    echo '</pre>';
                    /* !!! */
                    die();
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }
}
