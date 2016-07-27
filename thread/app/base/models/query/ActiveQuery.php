<?php

namespace thread\app\base\models\query;

use thread\app\base\models\ActiveRecord;

/**
 * class CommonQuery
 *
 * @package thread\app\base\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class ActiveQuery extends \yii\db\ActiveQuery
{

    /**
     * @param string $alias
     * @return $this
     */
    public function alias($alias)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.alias = :alias', [':alias' => $alias]);
        return $this;
    }

    /**
     * @return ActiveQuery
     */
    public function enabled()
    {
        return $this->published()->undeleted();
    }

    /**
     * @return $this
     */
    public function published()
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.published = :published', [':published' => ActiveRecord::STATUS_KEY_ON]);
        return $this;
    }

    /**
     * @return $this
     */
    public function unpublished()
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.published = :published', [':published' => ActiveRecord::STATUS_KEY_OFF]);
        return $this;
    }

    /**
     * @return $this
     */
    public function deleted()
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.deleted = :deleted', [':deleted' => ActiveRecord::STATUS_KEY_ON]);
        return $this;
    }

    /**
     * @return $this
     */
    public function undeleted()
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.deleted = :deleted', [':deleted' => ActiveRecord::STATUS_KEY_OFF]);
        return $this;
    }

    /**
     * @return $this
     */
    public function readonly()
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.readonly = :readonly', [':readonly' => ActiveRecord::STATUS_KEY_OFF]);
        return $this;
    }

    /**
     * @return $this
     */
    public function _lang()
    {
        return $this->joinWith('lang')->andWhere(['lang' => \Yii::$app->language]);
    }

    /**
     * @param $group_id
     * @return $this
     */
    public function group_id($group_id)
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.group_id = :group_id', [':group_id' => $group_id]);
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function byID($id)
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        if (is_array($id)) {
            $this->andWhere(['in', $modelClass::tableName() . '.id', $id]);
        } else {
            $this->andWhere($modelClass::tableName() . '.id = :id', [':id' => $id]);
        }


        return $this;
    }

    /**
     * @return $this
     */
    public function lang()
    {
        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass . "Lang";
        $this->leftJoin($modelClass::tableName(), 'rid = id')->_lang();
        return $this;
    }
}
