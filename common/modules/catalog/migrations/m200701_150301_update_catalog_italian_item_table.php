<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m200701_150301_update_catalog_italian_item_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%catalog_italian_item}}';

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

        $this->renameColumn($this->table, 'production_time', 'production_time_from');
        $this->addColumn($this->table, 'production_time_to', $this->string(255)->defaultValue(null));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'production_time_to');
    }
}
