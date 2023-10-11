<?php

namespace thread\modules\seo\modules\directlink\models\query;

/**
 * Class ActiveQuery
 *
 * @package thread\modules\seo\modules\directlink\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ActiveQuery extends \thread\app\base\models\query\ActiveQuery
{

    /**
     * @param string $url
     * @return $this
     */
    public function url(string $url)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.url = :url', [':url' => $url]);
        return $this;
    }

}