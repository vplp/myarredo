<?php

namespace frontend\modules\banner\models;

use Yii;

/**
 * Class BannerItem
 *
 * @package frontend\modules\banner\models
 */
class BannerItem extends \common\modules\banner\models\BannerItem
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        $query = parent::findBase();

        if (Yii::$app->controller->id == 'factory-banner') {
            $query
                ->andWhere([self::tableName() . '.user_id' => Yii::$app->user->identity->id])
                ->undeleted();
        } else {
            $query
                ->enabled();
        }

        return $query;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()
            ->byID($id)
            ->one();
    }

    /**
     * @param $factory_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findByFactoryId($factory_id)
    {
        return self::findBase()
            ->andWhere([
                self::tableName() . '.factory_id' => $factory_id,
                self::tableName() . '.type' => 'factory'
            ])
            ->all();
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\BannerItem())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\BannerItem())->trash($params);
    }
}
