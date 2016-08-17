<?php
namespace backend\modules\configs\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\configs\Configs as ConfigsModule;
use backend\modules\configs\models\{
    Language as LanguageModel
};

class Language extends LanguageModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'local', 'label'], 'string', 'max' => 50],
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
     * @param ActiveQuery $query
     * @param array $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var ConfigsModule $module */
        $module = Yii::$app->getModule('configs');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $module->itemOnPage
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'local', $this->alias])
            ->andFilterWhere(['like', 'label', $this->alias])
            ->andFilterWhere(['like', 'published', $this->published]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LanguageModel::find()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = LanguageModel::find()->deleted();
        return $this->baseSearch($query, $params);
    }
}
