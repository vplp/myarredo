<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170718_130158_update_catalog_samples_lang_table
 */
class m170718_130158_update_catalog_samples_lang_table extends Migration
{
    /**
     * table lang name
     * @var string
     */
    public $tableLang = '{{%samples_lang}}';

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
        $this->renameColumn($this->tableLang, 'language_code', 'lang');

        $this->alterColumn($this->tableLang, 'lang', $this->string(5)->notNull()->comment('Language'));

        // change lang 'ru' on 'ru-RU'
        $this->update($this->tableLang, ['lang' => 'ru-RU'], ['lang' => 'ru']);

        $this->renameTable('samples_lang', 'catalog_samples_lang');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_samples_lang', 'samples_lang');

        $this->renameColumn($this->tableLang, 'lang', 'language_code');
    }
}
