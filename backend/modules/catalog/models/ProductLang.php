<?php

namespace backend\modules\catalog\models;

/**
 * Class ProductLang
 *
 * @package backend\modules\catalog\models
 */
class ProductLang extends \common\modules\catalog\models\ProductLang
{
    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->title = $this->parent->types->lang->title
            . ' ' . $this->parent->factory->lang->title
            . ' ' . $this->parent->collection->lang->title
            . (($this->parent->article) ? ' ' . $this->parent->article : '');

        return parent::beforeValidate();
    }
}
