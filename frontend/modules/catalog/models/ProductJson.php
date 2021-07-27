<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * Class ProductJson
 *
 * @package frontend\modules\catalog\models
 */
class ProductJson extends \common\modules\catalog\models\ProductJson
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public static function findBase()
    {
        $query = self::find()
            ->innerJoinWith(['parent', 'parent.factory'], false)
            ->andFilterWhere([
                Product::tableName() . '.removed' => '0',
                Factory::tableName() . '.published' => '1',
                Factory::tableName() . '.deleted' => '0',
            ]);

        return $query;
    }

    /**
     * @param $alias
     * @return mixed
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByAlias($alias)
    {
//        $result = self::getDb()->cache(function ($db) use ($alias) {
            $data = self::findBase()
                ->andWhere([Product::tableName() . '.' . Yii::$app->languages->getDomainAlias() => $alias])
                ->one();

            if ($data != null) {
                $data = $data->content;
            }

            return $data;
//        }, 3600);
//
//        return $result;
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        return (new search\ProductJson())->search($params);
    }
}
