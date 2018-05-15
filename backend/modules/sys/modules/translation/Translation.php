<?php

namespace backend\modules\sys\modules\translation;

use common\modules\sys\modules\translation\Translation as CommonTranslation;

/**
 * Class Translation
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 * @package backend\modules\sys\modules\translation
 */
class Translation extends CommonTranslation
{
    // Number of items on page for dataProvider
    public $itemOnPage = 100;
}
