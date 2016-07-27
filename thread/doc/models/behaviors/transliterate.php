<?php

/**
use yii\helpers\Inflector;
use yii\behaviors\AttributeBehavior;

public function behaviors()
{
    return ArrayHelper::merge(parent::behaviors(), [
        [
            'class' => AttributeBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => 'alias',
                ActiveRecord::EVENT_BEFORE_UPDATE => 'alias',
            ],
            'value' => function ($event) {
                return Inflector::slug($this->alias);
            },
        ],
    ]);
}
**/