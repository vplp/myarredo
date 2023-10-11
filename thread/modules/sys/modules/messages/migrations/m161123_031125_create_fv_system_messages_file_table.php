<?php

use yii\db\Migration;
use thread\modules\sys\modules\messages\Messages;

/**
 * Class m161123_031125_create_fv_system_messages_file_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161123_031125_create_fv_system_messages_file_table extends Migration
{

    /**
     * Menu table name
     * @var string
     */
    public $table = '{{%system_messages_file}}';

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
            'messagefilepath' => $this->string(512)->notNull()->comment('messagefilepath'),
            'alias' => $this->string(32)->unique()->notNull()->comment('alias'),
            'created_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('Update time')
        ]);

    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
