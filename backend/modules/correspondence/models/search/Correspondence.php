<?php
namespace backend\modules\correspondence\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\correspondence\Correspondence as СorrespondenceModule;
use backend\modules\correspondence\models\{
    Correspondence as CorrespondenceModel
};

/**
 * Class Сorrespondence
 *
 * @package backend\modules\correspondence\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Correspondence extends CorrespondenceModel implements BaseBackendSearchModel
{
    public $date_from, $date_to;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['subject'], 'string', 'max' => 512],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [
                ['date_from'],
                'date',
                'format' => 'php:' . СorrespondenceModule::getFormatDate(),
                'timestampAttribute' => 'date_from'
            ],
            [
                ['date_to'],
                'date',
                'format' => 'php:' . СorrespondenceModule::getFormatDate(),
                'timestampAttribute' => 'date_to'
            ],
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
        /** @var СorrespondenceModule $module */
        $module = Yii::$app->getModule('correspondence');
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

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['=', 'published', $this->published]);
        //
        $query->andFilterWhere(['>=', 'published_time', $this->date_from]);
        $query->andFilterWhere(['<=', 'published_time', $this->date_to]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CorrespondenceModel::find()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = CorrespondenceModel::find()->deleted();
        return $this->baseSearch($query, $params);
    }
}
