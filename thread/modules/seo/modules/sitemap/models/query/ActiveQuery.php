<?php

namespace thread\modules\seo\modules\sitemap\models\query;

use thread\app\base\models\ActiveRecord;

/**
 * Class ActiveQuery
 *
 * @package thread\modules\seo\modules\sitemap\models\query
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
    public function add_to_sitemap()
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.add_to_sitemap = :add_to_sitemap', [':add_to_sitemap' => ActiveRecord::STATUS_KEY_ON]);
        return $this;
    }

    /**
     * @return $this
     */
    public function dissallow_in_robotstxt()
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.dissallow_in_robotstxt = :dissallow_in_robotstxt', [':dissallow_in_robotstxt' => ActiveRecord::STATUS_KEY_ON]);
        return $this;
    }
}