<?php

namespace frontend\modules\location\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * Class City
 *
 * @package frontend\modules\location\models
 */
class City extends \common\modules\location\models\City
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
     * @param int $country_id
     * @return mixed
     */
    public static function dropDownList($country_id = 0)
    {
        $query = self::findBase();

        $query->andFilterWhere(['country_id' => $country_id]);

        $data = $query->all();

        return ArrayHelper::map($data, 'id', 'lang.title');
    }

    public function getSubDomainUrl()
    {
        $url = (!in_array($this->id, array(4, 2, 1)))
            ? 'http://' . $this->alias . '.myarredo2017.dev'
            : 'http://' . 'www.myarredo2017.dev';

        return $url;
    }
}