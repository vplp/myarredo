<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170728_131922_update_catalog_factory_file_table
 */
class m170728_131922_update_catalog_factory_file_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory_file}}';

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
        $this->renameColumn($this->table, 'name', 'title');
        $this->renameColumn($this->table, 'created', 'created_at');
        $this->renameColumn($this->table, 'updated', 'updated_at');
        $this->renameColumn($this->table, 'filepath', 'file_link');
        $this->renameColumn($this->table, 'type_file', 'file_type');
        $this->renameColumn($this->table, 'size', 'file_size');

        $this->addColumn($this->table, 'published', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published' AFTER file_size");
        $this->addColumn($this->table, 'deleted', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted' AFTER published");
        $this->addColumn($this->table, 'position', $this->integer(11)->unsigned()->defaultValue(0)->after('deleted'));

        // set published
        $this->update($this->table, ['published' => '1']);
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'position');
        $this->dropColumn($this->table, 'deleted');
        $this->dropColumn($this->table, 'published');

        $this->renameColumn($this->table, 'file_size', 'size');
        $this->renameColumn($this->table, 'file_type', 'type_file');
        $this->renameColumn($this->table, 'file_link', 'filepath');
        $this->renameColumn($this->table, 'created_at', 'created');
        $this->renameColumn($this->table, 'updated_at', 'updated');
        $this->renameColumn($this->table, 'title', 'name');
    }
}
