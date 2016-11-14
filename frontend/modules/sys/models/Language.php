<?php

namespace frontend\modules\sys\models;

use Yii;
//
use common\modules\sys\models\Language as CommonLanguageModel;

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
