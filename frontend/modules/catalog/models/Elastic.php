<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\elasticsearch\ActiveRecord;

class Elastic extends ActiveRecord
{
    public function attributes()
    {
        return ['name', 'email'];
    }
}