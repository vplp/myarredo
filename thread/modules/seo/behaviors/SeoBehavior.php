<?php
namespace thread\modules\seo\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
//
use thread\modules\seo\models\Seo;

/**
 * Class SeoBehavior
 *
 * @package thread\modules\seo\behaviors
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class SeoBehavior extends Behavior
{
    /**
     * @var array Массив аттрибутов которые должны быть обработаны с HtmlPurifier
     */
    public $attributes = [];

    /**
     * @var null
     */
    public $model_id = null;

    /**
     *
     * @var null
     */
    public $modelNamespace = null;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'updSeoModel',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updSeoModel',
        ];
    }

    /**
     * Save seo model
     */
    public function updSeoModel()
    {
        $seoModel = Seo::getModelByNamespace($this->modelNamespace, $this->owner->id);
        $seoModel->setScenario('backend');
        $post = Yii::$app->getRequest()->post();

        if ($seoModel->load($post) && $seoModel->save()) {
            $seoModelLang = $seoModel->getLangModel();
            $seoModelLang->setScenario('backend');

            if ($seoModelLang->load($post) && $seoModelLang->save()) {
            }
        }
    }
}
