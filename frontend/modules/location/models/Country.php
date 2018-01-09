<?php

namespace frontend\modules\location\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * Class Country
 *
 * @package frontend\modules\location\models
 */
class Country extends \common\modules\location\models\Country
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

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return parent::findBase()->enabled();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this
            ->hasMany(City::class, ['country_id' => 'id'])
            ->andFilterWhere([
                City::tableName() . '.published' => '1',
                City::tableName() . '.deleted' => '0',
            ])
            ->innerJoinWith(['lang'])
            ->orderBy(CityLang::tableName() . '.title');
    }

    /**
     * Get by alias
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }

    /**
     * Drop down list
     *
     * @return mixed
     */
    public static function dropDownList()
    {
        $query = self::findBase();

        $data = $query->all();

        return ArrayHelper::map($data, 'id', 'lang.title');
    }
}