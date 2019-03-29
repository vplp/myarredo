<?php

namespace backend\modules\sys\modules\translation\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use backend\modules\sys\modules\translation\Translation;
use backend\modules\sys\modules\translation\models\Message;
use backend\modules\sys\modules\translation\models\Source as SourceModel;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;

/**
 * Class Source
 *
 * @package backend\modules\sys\modules\translation\models\search
 */
class Source extends SourceModel implements BaseBackendSearchModel
{
    public $translation;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['key', 'category', 'translation'], 'string', 'max' => 255],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $query
     * @param $params
     * @return mixed
     */
    public function baseSearch($query, $params)
    {
        /** @var Translation $module */
        $module = Yii::$app->getModule('sys/translation');
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => $module->itemOnPage
                ]
            ]
        );

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'published', $this->published]);
        $query->andFilterWhere(['like', 'key', $this->key]);
        $query->andFilterWhere(['like', 'category', $this->category]);
        $query->andFilterWhere(['like', Message::tableName() . '.translation', $this->translation]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SourceModel::findBase()->undeleted();

        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return mixed|ActiveDataProvider
     */
    public function trash($params)
    {
        $query = SourceModel::findBase()->deleted();

        return $this->baseSearch($query, $params);
    }
}