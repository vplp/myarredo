<?php
namespace backend\modules\news\models;

use yii\helpers\ArrayHelper;
//
use thread\modules\seo\behaviors\SeoBehavior;
use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\news\models\Article as CommonArticleModel;
use common\modules\seo\models\Seo;

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
                'SeoBehavior' => [
                    'class' => SeoBehavior::class,
                    'modelNamespace' => self::COMMON_NAMESPACE
                ],
            ]
        );
    }

    //TODO Что с этим делать
    /**
     * @return $this
     */
    public function getSeo()
    {
        return $this->hasOne(Seo::class, ['model_id' => 'id'])->andWhere(['model_namespace' => self::COMMON_NAMESPACE]);
    }
}
