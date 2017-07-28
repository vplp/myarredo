<?php

namespace backend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\catalog\models\{
    FactoryFile as FactoryFileModel, FactoryFileLang
};

/**
 * Class FactoryFile
 *
 * @package backend\modules\catalog\models\search
 */
class FactoryFile extends FactoryFileModel implements BaseBackendSearchModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['factory_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['file_type'], 'in', 'range' => [1, 2]],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
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
                'pageSize' => $module->itemOnPage
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'factory_id' => $this->factory_id
        ]);

        $query->andFilterWhere(['like', 'published', $this->published]);

        $query->andFilterWhere(['like', 'file_type', $this->file_type]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FactoryFileModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = FactoryFileModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
