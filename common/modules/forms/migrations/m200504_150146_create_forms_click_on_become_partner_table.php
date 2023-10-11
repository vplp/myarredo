<?php

use yii\db\Migration;
use common\modules\forms\FormsModule;

/**
 * Handles the creation of table `{{%forms_click_on_become_partner}}`.
 */
class m200504_150146_create_forms_click_on_become_partner_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%forms_click_on_become_partner}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = FormsModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned(),
            'country_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'city_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'ip' => $this->string(45)->notNull(),
            'http_user_agent' => $this->string(512)->notNull(),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('country_id', $this->table, 'country_id');
        $this->createIndex('city_id', $this->table, 'city_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('country_id', $this->table);
        $this->dropIndex('city_id', $this->table);

        $this->dropTable($this->table);
    }
}
