<?php

namespace backend\modules\location\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\location\models\{
    City,
    CityLang,
    search\City as filterCityModel
};

/**
 * Class CityController
 *
 * @package backend\modules\location\controllers
 */
class CityController extends BackendController
{
    public $model = City::class;
    public $modelLang = CityLang::class;
    public $filterModel = filterCityModel::class;
    public $title = 'City';
    public $name = 'city';


    public function actionImport()
    {
        $rows = (new \yii\db\Query())
            ->from('city')
            ->all();


        City::deleteAll();

        foreach ($rows as $row) {

            $model = new City();
            $model->setScenario('backend');

            $model->id = $row['id'];

            /** @var PDO $transaction */
            $transaction = $model::getDb()->beginTransaction();
            try {
                $model->alias = $row['alias'];
                $model->country_id = $row['country_id'];

                $geo_position = explode(';', $row['geo_position']);

                $model->lat = isset($geo_position[0]) ? $geo_position[0] : 0;
                $model->lng = isset($geo_position[1]) ? $geo_position[1] : 0;
                $model->published = $row['enabled'];
                $model->deleted = $row['deleted'];
                $model->position = $row['order'];

                $save = $model->save();

                if ($save) {
                    $modelLang = new CityLang([
                        'rid' => $model->id,
                        'lang' => 'ru-RU',
                        'scenario' => 'backend',
                        'title' => $row['name'],
                        'title_where' => $row['name_where'],
                    ]);

                    $modelLang->save();
                }

                if ($save) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
        }
    }
}
