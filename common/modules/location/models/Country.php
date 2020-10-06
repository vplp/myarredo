<?php

namespace common\modules\location\models;

use yii\helpers\ArrayHelper;
use common\modules\shop\models\Order;
use common\modules\catalog\models\{
    Sale, Factory
};

/**
 * Class Country
 *
 * @property integer $bookId
 * @property integer $show_for_registration
 * @property integer $show_for_filter
 *
 * @property Order[] $order
 * @property Sale $sale
 *
 * @package common\modules\location\models
 */
class Country extends \thread\modules\location\models\Country
{
    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [['bookId'], 'integer'],
            [['bookId'], 'default', 'value' => 0],
            [['show_for_registration', 'show_for_filter'], 'in', 'range' => array_keys(static::statusKeyRange())],
        ];

        return ArrayHelper::merge($rules, parent::rules());
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = [
            'backend' => [
                'bookId',
                'show_for_registration',
                'show_for_filter'
            ],
            'show_for_registration' => ['show_for_registration'],
            'show_for_filter' => ['show_for_filter'],
        ];

        return ArrayHelper::merge($scenarios, parent::scenarios());
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            'bookId' => 'ID Адресной книги в SendPulse',
            'show_for_registration' => 'Выводим в форму регистрации фабрик',
            'show_for_filter' => 'Использовать в фильтре по стране',
        ];

        return ArrayHelper::merge($attributeLabels, parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasMany(Factory::class, ['producing_country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasMany(Sale::class, ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasMany(Order::class, ['country_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->orderBy(self::tableName() . '.position');
    }

    /**
     * @param string $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (isset($this->lang->title)) ? $this->lang->title : "{{$this->alias}}";
    }
}
