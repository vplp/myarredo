<?php

namespace frontend\modules\configs\models;

use Yii;
use yii\helpers\ArrayHelper;
//
//
use common\modules\configs\models\Language as CommonLanguageModel;

class Language extends CommonLanguageModel
{
    /**
     * @return mixed
     * выводим только те языки, которые опубликованы
     */
    public function getLanguages():array
    {
        return self::findBase()->enabled()->all();
    }

}
