<?php

namespace backend\modules\sys\modules\logbook\widgets\panel;

use backend\modules\sys\modules\logbook\models\Logbook;
use thread\app\base\widgets\Widget;

/**
 * Class LogbookPanel
 *
 * @package backend\modules\sys\modules\logbook\widgets\panel
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class LogbookPanel extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $models = Logbook::find()->undeleted()->addOrderBy(['updated_at' => SORT_DESC])->limit(7)->all();
        return $this->render('index', [
            'models' => $models
        ]);
    }
}