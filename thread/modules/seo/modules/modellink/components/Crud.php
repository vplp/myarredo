<?php

namespace thread\modules\seo\modules\modellink\components;

use Yii;
use yii\base\Exception;
use yii\base\Component;
use yii\log\Logger;
//
use thread\modules\seo\modules\modellink\models\Modellink;
use thread\app\base\models\ActiveRecord;

/**
 * Class Crud
 *
 * @package thread\modules\seo\modules\modellink\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Crud extends Component
{

    protected $model = null;

    /**
     * @return $this
     */
    public function delete()
    {
        if ($this->model != null) {
            Yii::getLogger()->log('Modellink ' . $this->model->id . ' has been deleted', Logger::LEVEL_INFO);
            $this->model->delete();
        }
        return $this;
    }

    /**
     *
     */
    public function saveModel()
    {
        if ($this->model != null) {
            $this->model->scenario = 'backend';

            try {
                $this->model->save();
            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            }
        }
    }

    /**
     * @param string $model_key
     * @param int $model_id
     * @return $this
     */
    public function findModel(string $model_key, int $model_id)
    {
        $this->model = Modellink::findModel($model_key, $model_id)->one();

        return $this;
    }

    /**
     * @return $this
     */
    public function getPostModel()
    {
        if ($this->model == null) {
            $this->model = new Modellink();
        }
        $this->model->scenario = 'backend';
        $this->model->lang = Yii::$app->language;

        $this->model->load(Yii::$app->getRequest()->post());
        if ($this->model->load(Yii::$app->getRequest()->post())) {
            Yii::getLogger()->log('Modellink ' . $this->model->id . ' has been loaded', Logger::LEVEL_INFO);
        } else {
            Yii::getLogger()->log('Modellink ' . $this->model->id . ' has not been loaded', Logger::LEVEL_WARNING);
            Yii::getLogger()->log($this->model->getErrors(), Logger::LEVEL_ERROR);
        }

        return $this;
    }

    /**
     * @param ActiveRecord $model
     * @return string
     */
    public static function getModelKey(ActiveRecord $model)
    {
        return Modellink::getModelKey($model);
    }

    /**
     * @param ActiveRecord $model
     * @return mixed
     */
    public function getByModel(ActiveRecord $model)
    {
        $this->model = Modellink::findModel(self::getModelKey($model), $model->id)->one();

        return $this;
    }
}