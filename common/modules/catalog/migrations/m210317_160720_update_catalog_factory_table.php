<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210317_160720_update_catalog_factory_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%catalog_factory}}';

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
        $this->addColumn($this->table, 'factory_discount', $this->integer(11)->unsigned()->notNull()->defaultValue(0));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'factory_discount');
    }
}
