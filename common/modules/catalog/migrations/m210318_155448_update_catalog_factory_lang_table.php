<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210318_155448_update_catalog_factory_lang_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%catalog_factory_lang}}';

    /**
    *
    */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'subdivision', $this->text()->defaultValue(null));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'subdivision');
    }
}
