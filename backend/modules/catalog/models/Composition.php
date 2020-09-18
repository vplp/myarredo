<?php

namespace backend\modules\catalog\models;

use backend\modules\user\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\Composition as CommonCompositionModel;

/**
 * Class Composition
 *
 * @package backend\modules\catalog\models
 */
class Composition extends CommonCompositionModel implements BaseBackendModel
{
    public $parent_id = 0;

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->alias == '' && in_array($this->scenario, ['backend', 'frontend'])) {
            $this->alias = (Yii::$app->request->post('CompositionLang'))['title'];
        }

        return parent::beforeValidate();
    }

    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->undeleted()->all(), 'id', 'lang.title');
    }

    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownListEditor()
    {
        $query = self::find()
            ->indexBy('editor_id')
            ->andWhere(['is_composition' => '1'])
            ->select('editor_id, count(editor_id) as count')
            ->groupBy('editor_id')
            ->andWhere('editor_id > 0')
            ->asArray()
            ->all();

        $ids = [];

        foreach ($query as $item) {
            $ids[] = $item['editor_id'];
        }

        if ($ids) {
            return ArrayHelper::map(
                User::findBase()->andWhere(['IN', User::tableName() . '.id', $ids])->all(),
                'id',
                'profile.fullName'
            );
        } else {
            return [];
        }
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Composition())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Composition())->trash($params);
    }
}
