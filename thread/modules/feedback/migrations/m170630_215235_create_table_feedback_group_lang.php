<?php

use yii\db\Migration;

/**
 * Class m170630_215235_create_table_feedback_group_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170630_215235_create_table_feedback_group_lang extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = '{{%feedback_group}}';

    /**
     * Table lang table name
     *
     * @var string
     */
    public $tableLang = '{{%feedback_group_lang}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title')
        ]);

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);
        $this->createIndex('rid_2', $this->tableLang, 'rid');

        $this->addForeignKey(
            'fk-feedback_group_lang-rid-feedback_group-id',
            $this->tableLang,
            'rid',
            $this->table,
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
        $this->dropForeignKey('fk-feedback_group_lang-rid-feedback_group-id', $this->tableLang);
        $this->dropIndex('rid', $this->tableLang);
        $this->dropIndex('rid_2', $this->tableLang);
        $this->dropTable($this->tableLang);
    }
}
