<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_114124_update_catalog_specification_table
 */
class m170721_114124_update_catalog_specification_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%specification}}';

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

        $this->dropColumn($this->table, 'left_key');
        $this->dropColumn($this->table, 'right_key');
        $this->dropColumn($this->table, 'level');
        $this->dropColumn($this->table, 'default_title');

        $this->addColumn($this->table, 'position', $this->integer(11)->unsigned()->defaultValue(0)->after('deleted'));

        $this->renameTable('specification', 'catalog_specification');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_specification', 'specification');

        $this->dropColumn($this->table, 'position');

        $this->addColumn($this->table, 'left_key', $this->integer(11)->unsigned()->defaultValue(0)->after('parent_id'));
        $this->addColumn($this->table, 'right_key', $this->integer(11)->unsigned()->defaultValue(0)->after('left_key'));
        $this->addColumn($this->table, 'level', $this->integer(11)->unsigned()->defaultValue(0)->after('right_key'));
        $this->addColumn($this->table, 'default_title', $this->string(255)->defaultValue(null)->after('alias'));

        $this->renameColumn($this->table, 'published', 'enabled');
        $this->renameColumn($this->table, 'created_at', 'created');
        $this->renameColumn($this->table, 'updated_at', 'updated');
    }
}
