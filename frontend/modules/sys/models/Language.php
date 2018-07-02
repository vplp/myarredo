<?php

namespace frontend\modules\sys\models;

use common\modules\sys\models\Language as CommonLanguageModel;

class Language extends CommonLanguageModel
{
    /**
     * @return mixed
     * выводим только те языки, которые опубликованы
     */
    public function getLanguages():array
    {
        return self::findBase()->enabled()->asArray()->all();
    }

    /**
     * @return mixed
     */
    public static function getAllByLocate()
    {
        if ($data = self::findBase()->where(['published' => '1', 'deleted' => '0'])->indexBy('local')->asArray()->all()) {
            return $data;
        }
    }
}
