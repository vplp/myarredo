<?php

namespace frontend\modules\forms\widgets;

use yii\base\Widget;
use frontend\modules\forms\models\FormsFeedback;

/**
 * Class FeedbackForm
 *
 * @package frontend\modules\forms\widgets
 */
class FormFeedback extends Widget
{
    /**
     * @var string
     */
    public $view = 'form_feedback';

    /**
     * @var string
     */
    public $partner_id = 0;

    /**
     * @return string
     */
    public function run()
    {
        $model = new FormsFeedback(['scenario' => 'frontend']);

        return $this->render($this->view, [
            'model' => $model,
            'partner_id' => $this->partner_id
        ]);
    }
}
