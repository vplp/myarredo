<?php

namespace common\modules\location\models;

use yii\helpers\ArrayHelper;

/**
 * Class Country
 *
 * @property int $bookId
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
            ]
        ];

        return ArrayHelper::merge($scenarios, parent::scenarios());
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            'bookId'  => 'bookId',
        ];

        return ArrayHelper::merge($attributeLabels, parent::attributeLabels());
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->orderBy(self::tableName(). '.position');
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
}
