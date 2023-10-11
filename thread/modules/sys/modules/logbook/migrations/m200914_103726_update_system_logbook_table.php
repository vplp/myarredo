<?php

use yii\db\Migration;
use thread\app\base\module\abstracts\Module as ParentModule;

class m200914_103726_update_system_logbook_table extends Migration
{
    use \thread\app\base\db\mysql\MySqlExtraTypesTrait;
    use \thread\app\base\db\mysql\ThreadMySqlExtraTypesTrait;

    /**
     * @var string
     */
    public $table = '{{%system_logbook}}';

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
        if (!$this->getDb()->getSchema()->getTableSchema($this->table)->getColumn('url')) {
            $this->addColumn($this->table, 'url', $this->string(512)->notNull()->comment('Url')->after('type'));
        }

        $this->addColumn($this->table, 'model_name', $this->string(512)->notNull()->comment('Model Name')->after('category'));
        $this->addColumn($this->table, 'action_method', $this->string(512)->notNull()->comment('Action Method')->after('model_name'));
        $this->addColumn($this->table, 'model_id', $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Model ID')->after('action_method'));

        $this->createIndex('model_name', $this->table, 'model_name');
        $this->createIndex('action_method', $this->table, 'action_method');
        $this->createIndex('model_id', $this->table, 'model_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('model_id', $this->table);
        $this->dropIndex('action_method', $this->table);
        $this->dropIndex('model_name', $this->table);

        $this->dropColumn($this->table, 'model_id');
        $this->dropColumn($this->table, 'action_method');
        $this->dropColumn($this->table, 'model_name');
    }
}
