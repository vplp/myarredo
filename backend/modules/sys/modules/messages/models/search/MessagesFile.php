<?php
namespace backend\modules\sys\modules\messages\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use thread\app\base\models\query\ActiveQuery;
//
use backend\modules\sys\modules\messages\models\MessagesFile as MessagesFileModel;
use backend\modules\sys\modules\messages\Messages as MessagesModule;

/**
 * Class MessagesFile
 *
 * @package backend\modules\sys\modules\messages\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MessagesFile extends MessagesFileModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['messagefilepath', 'title'], 'string', 'max' => 512],
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
        /** @var MessagesModule $module */
        $module = Yii::$app->getModule('sys/messages');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
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

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'messagefilepath', $this->alias]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MessagesFileModel::find()->with(['lang']);
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = MessagesFileModel::find()->with(['lang']);
        return $this->baseSearch($query, $params);
    }
}
