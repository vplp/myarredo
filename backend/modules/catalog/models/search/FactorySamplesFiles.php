<?php

namespace backend\modules\catalog\models\search;

use backend\modules\catalog\Catalog;
use backend\modules\catalog\models\FactorySamplesFiles as FactorySamplesFilesModel;
use thread\app\model\interfaces\BaseBackendModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FactorySamplesFiles extends FactorySamplesFilesModel implements BaseBackendModel
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['factory_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['file_type'], 'in', 'range' => [1, 2, 3]],
        ];
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ],
        ]);
        

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.factory_id' => $this->factory_id
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = FactorySamplesFilesModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params): ActiveDataProvider
    {
        $query = FactorySamplesFilesModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}