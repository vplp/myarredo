<?php

namespace frontend\actions;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class UpdateWithLang
 *
 * @package frontend\actions
 */
class UpdateWithLang extends \thread\actions\UpdateWithLang
{
    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        $this->model = $this->findModel($id);
        $this->modelLang = $this->findModelLang($id);

        if ($this->model == null) {
            throw new NotFoundHttpException();
        }

        if (Yii::$app->getRequest()->isAjax) {
            return $this->controller->renderPartial($this->view, [
                'model' => $this->model,
                'modelLang' => $this->modelLang,
            ]);
        } else {
            if ($this->saveModel()) {
                return $this->controller->redirect($this->getRedirect());
            } else {
                $this->controller->layout = $this->layout;
                return $this->controller->render($this->view, [
                    'model' => $this->model,
                    'modelLang' => $this->modelLang,
                ]);
            }
        }
    }

    /**
     * @param array|int $model_id
     * @param string $className
     * @return null|\yii\base\Model
     */
    public function findModel($model_id, $className = '')
    {
        $modelClass = empty($className) ? $this->model : new $className();

        return $modelClass::findById($model_id);
    }
}
