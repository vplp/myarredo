<?php

namespace backend\modules\news\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
//
use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\news\models\Article as CommonArticleModel;
//
use backend\modules\sys\modules\logbook\behaviors\LogbookBehavior;

/**
 * Class Article
 *
 * @package backend\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
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

    /**
     * @return array
     */

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'LogbookBehavior' => [
                    'class' => LogbookBehavior::class,
                    'category' => 'Новости',
                    'updateMessage' => function () {
                        return "<a href='/core-cms/web/backend/news/article/update?id=" . $this->owner->id . "'>Обновлена новость " . $this->owner->lang->title . "</a>";
                    }
                ]
            ]
        );
    }
}
