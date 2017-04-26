<?php

use yii\db\Migration;

/**
 * Class m170418_172028_create_translation_message_table
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 */
class m170418_172028_create_translation_message_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%translation_message}}';

    /**
     * @var string
     */
    public $refTable = '{{%translation_source}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
                'lang' => $this->string(5)->notNull()->comment('Language'),
                'translation' => $this->text()->notNull()->comment('Translation'),
            ]
        );

        $this->addPrimaryKey('rid', $this->table, ['rid', 'lang']);


        $this->addForeignKey(
            'fk-translation_message-rid-translation_source-id',
            $this->table,
            'rid',
            $this->refTable,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-translation_message-rid-translation_source-id', $this->table);
        $this->dropIndex('rid', $this->table);
        $this->dropTable($this->table);
    }
}
