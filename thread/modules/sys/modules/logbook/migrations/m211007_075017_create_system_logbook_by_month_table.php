<?php

use yii\db\Migration;
use thread\app\base\module\abstracts\Module as ParentModule;

/**
 * Handles the creation of table `{{%system_logbook_by_month}}`.
 */
class m211007_075017_create_system_logbook_by_month_table extends Migration
{
    use \thread\app\base\db\mysql\MySqlExtraTypesTrait;
    use \thread\app\base\db\mysql\ThreadMySqlExtraTypesTrait;

    /**
     * @var string
     */
    public $table = '{{%system_logbook_by_month}}';

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
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('User'),
            'action_method' => $this->string(512)->notNull()->comment('Action Method'),
            'action_date' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Action date'),
            'count' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->t_created_at(),
            'updated_at' => $this->t_updated_at(),
            'published' => $this->enum([0, 1], 0)->comment('Published'),
            'deleted' => $this->enum([0, 1], 0)->comment('Deleted'),
        ]);

        $this->createIndex('user_id', $this->table, 'user_id');
        $this->createIndex('action_method', $this->table, 'action_method');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropIndex('action_method', $this->table);
        $this->dropIndex('user_id', $this->table);

        $this->dropTable($this->table);
    }
}
