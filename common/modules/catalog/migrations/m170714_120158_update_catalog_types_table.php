<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170714_130158_update_catalog_types_table
 */
class m170714_120158_update_catalog_types_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_type}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->renameColumn($this->table, 'enabled', 'published');
        $this->renameColumn($this->table, 'created', 'created_at');
        $this->renameColumn($this->table, 'updated', 'updated_at');
        $this->renameColumn($this->table, 'order', 'position');

        $this->dropColumn($this->table, 'default_title');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->addColumn($this->table, 'default_title', $this->string(255)->defaultValue(null)->after('alias'));

        $this->renameColumn($this->table, 'published', 'enabled');
        $this->renameColumn($this->table, 'created_at', 'created');
        $this->renameColumn($this->table, 'updated_at', 'updated');
        $this->renameColumn($this->table, 'position', 'order');
    }
}
