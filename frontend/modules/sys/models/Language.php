<?php

namespace frontend\modules\sys\models;

use common\modules\sys\models\Language as CommonLanguageModel;

class Language extends CommonLanguageModel
{
    /**
     * @return mixed
     * выводим только те языки, которые опубликованы
     */
    public function getLanguages(): array
    {
        return self::findBase()
            ->andFilterWhere(['IN', 'id', [3, 4]])
            ->enabled()
            ->asArray()
            ->all();
    }

    /**
     * @return mixed
     */
    public static function getAllByLocate()
    {
        return $data = self::findBase()
            ->enabled()
            ->indexBy('local')
            ->asArray()
            ->all();
    }
}
