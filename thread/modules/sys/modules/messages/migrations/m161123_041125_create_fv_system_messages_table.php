<?php

use yii\db\Migration;
use thread\modules\sys\modules\messages\Messages;

/**
 * Class m161123_041125_create_fv_system_messages_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161123_041125_create_fv_system_messages_table extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%system_messages}}';
    /**
     * @var string
     */
    public $rootTable = '{{%system_messages_file}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Messages::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {

        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'group_id' => $this->integer()->unsigned()->notNull()->comment('group_id'),
            'alias' => $this->string(32)->notNull()->comment('alias'),
            'arraykey' => $this->text()->notNull()->comment('arraykey'),
            'on_default_lang' => $this->text()->notNull()->comment('on_default_lang'),
            'created_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('Update time')
        ]);

        $this->createIndex('group_id', $this->table, ['group_id']);
        $this->createIndex('alias', $this->table, ['group_id', 'alias'], true);

        $this->addForeignKey(
            'fk-system_messages_file_-group_id-id',
            $this->table,
            'group_id',
            $this->rootTable,
            'id',
            'CASCADE',
            'CASCADE'
        );

    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-system_messages_file_-group_id-id', $this->table);
        $this->dropIndex('group_id', $this->table);
        $this->dropTable($this->table);
    }
}
