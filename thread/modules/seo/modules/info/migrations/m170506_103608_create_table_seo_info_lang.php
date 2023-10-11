<?php

use yii\db\Migration;

/**
 * Class m170506_103608_create_table_seo_info_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170506_103608_create_table_seo_info_lang extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = '{{%seo_info}}';

    /**
     * Table lang table name
     *
     * @var string
     */
    public $tableLang = '{{%seo_info_lang}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
            'value' => $this->string(255)->notNull()->comment('value')
        ]);

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);
        $this->createIndex('rid_2', $this->tableLang, 'rid');

        $this->addForeignKey(
            'fk-seo_info_lang-rid-seo_info-id',
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
        $this->dropForeignKey('fk-seo_info_lang-rid-seo_info-id', $this->tableLang);
        $this->dropIndex('rid', $this->tableLang);
        $this->dropIndex('rid_2', $this->tableLang);
        $this->dropTable($this->tableLang);
    }
}
