<?php

namespace thread\modules\seo\modules\modellink\models\query;

/**
 * Class ActiveQuery
 *
 * @package thread\modules\seo\modules\modellink\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActiveQuery extends \thread\app\base\models\query\ActiveQuery
{

    /**
     * @param int $model_id
     * @return $this
     */
    public function model_id(int $model_id)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.model_id = :model_id', [':model_id' => $model_id]);
        return $this;
    }

    /**
     * @param string $model_key
     * @return $this
     */
    public function model_key(string $model_key)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.model_key = :model_key', [':model_key' => $model_key]);
        return $this;
    }

    /**
     * @return $this
     */
    public function currency_language()
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.lang = :currency_language', [':currency_language' => \Yii::$app->language]);
        return $this;
    }

}