<?php

use thread\modules\sys\Sys;
use yii\db\Migration;

/**
 * Class m170228_030515_create_fv_system_logbook_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170228_030515_create_fv_system_logbook_table extends Migration
{
    use \thread\app\base\db\mysql\MySqlExtraTypesTrait;
    use \thread\app\base\db\mysql\ThreadMySqlExtraTypesTrait;

    /**
     * @var string
     */
    public $tableCronTab = '{{%system_logbook}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Sys::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {

        $this->createTable($this->tableCronTab, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('User'),
            'type' => $this->enum(['notice', 'warning', 'error'], 'notice')->comment('Type'),
            'url' => $this->string(512)->notNull()->comment('Url'),
            'message' => $this->string(512)->notNull()->comment('Message'),
            'category' => $this->string(50)->notNull()->comment('Category'),
            'created_at' => $this->t_created_at(),
            'updated_at' => $this->t_updated_at(),
            'is_read' => $this->enum([0, 1], 0)->comment('is_read'),
            'published' => $this->enum([0, 1], 0)->comment('Published'),
            'deleted' => $this->enum([0, 1], 0)->comment('Deleted'),
        ]);
        $this->createIndex('type', $this->tableCronTab, 'type');
        $this->createIndex('is_read', $this->tableCronTab, 'is_read');
        $this->createIndex('user_id', $this->tableCronTab, 'user_id');
        $this->createIndex('published', $this->tableCronTab, 'published');
        $this->createIndex('category', $this->tableCronTab, 'category');
        $this->createIndex('deleted', $this->tableCronTab, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableCronTab);
        $this->dropIndex('published', $this->tableCronTab);
        $this->dropIndex('type', $this->tableCronTab);
        $this->dropIndex('is_read', $this->tableCronTab);
        $this->dropIndex('category', $this->tableCronTab);
        $this->dropIndex('user_id', $this->tableCronTab);
        $this->dropTable($this->tableCronTab);
    }
}
