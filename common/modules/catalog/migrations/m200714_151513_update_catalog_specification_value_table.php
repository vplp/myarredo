<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m200714_151513_update_catalog_specification_value_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%catalog_specification_value}}';

    public $tableSpec = '{{%catalog_specification}}';

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
        $this->alterColumn($this->table, 'val', $this->integer(11)->unsigned()->notNull()->defaultValue(0));

        for ($n = 2; $n <= 10; $n++) {
            $field = "val$n";
            $this->addColumn($this->table, $field, $this->integer(11)->unsigned()->notNull()->defaultValue(0));
            $this->createIndex($field, $this->table, $field);
        }
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        for ($n = 2; $n <= 10; $n++) {
            $field = "val$n";
            $this->dropIndex($field, $this->table);
            $this->dropColumn($this->table, $field);
        }
    }
}
