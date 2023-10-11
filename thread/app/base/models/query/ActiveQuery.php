<?php

namespace thread\app\base\models\query;

use thread\app\base\models\ActiveRecord;

/**
 * Class ActiveQuery
 *
 * @package thread\app\base\models\query
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $user_id
     * @return $this
     */
    public function user_id(int $user_id)
    {
        $modelClass = $this->modelClass;

        $this->andWhere($modelClass::tableName() . '.user_id = :user_id', [':user_id' => $user_id]);

        return $this;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function byAlias($alias)
    {
        $modelClass = $this->modelClass;

        if (is_array($alias)) {
            $this->andWhere(['IN', $modelClass::tableName() . '.alias', $alias]);
        } else {
            $this->andWhere($modelClass::tableName() . '.alias = :alias', [':alias' => $alias]);
        }

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
    public function group_id(int $group_id)
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
            $this->andWhere(['IN', $modelClass::tableName() . '.id', $id]);
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
