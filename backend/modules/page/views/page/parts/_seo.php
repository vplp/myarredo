<?php

use thread\modules\seo\modules\modellink\widgets\seo\SeoBlock;

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

echo SeoBlock::widget([
    'form' => $form,
    "model" => $model,
]);