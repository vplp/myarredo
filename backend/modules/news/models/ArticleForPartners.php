<?php

namespace backend\modules\news\models;

use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\news\models\ArticleForPartners as CommonArticleForPartnersModel;

/**
 * Class Article
 *
 * @package backend\modules\news\models
 */
class ArticleForPartners extends CommonArticleForPartnersModel implements BaseBackendModel
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\ArticleForPartners())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\ArticleForPartners())->trash($params);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'group_id' => ['group_id'],
        ]);
    }
}
