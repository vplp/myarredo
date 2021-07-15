<?php

namespace backend\modules\articles\models;

use common\modules\articles\models\Article as CommonArticleModel;
use thread\modules\seo\behaviors\SeoBehavior;
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class Article
 *
 * @package backend\modules\articles\models
 */
class Article extends CommonArticleModel implements BaseBackendModel
{
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Article())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Article())->trash($params);
    }
}
