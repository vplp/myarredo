<?php

use thread\modules\shop\Shop;
use yii\db\Migration;

/**
 * Class m161020_105203_create_table_shop_delivery_methods_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161020_105203_create_table_shop_delivery_methods_lang extends Migration
{
    /**
     * @var string
     */
    public $tableDeliveryMethods = '{{%shop_delivery_methods}}';
    public $tableDeliveryMethodsLang = '{{%shop_delivery_methods_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Shop::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableDeliveryMethodsLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),

        ]);
        $this->createIndex('rid', $this->tableDeliveryMethodsLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-shop_delivery_methods_lang-rid-shop_delivery_methods-id',
            $this->tableDeliveryMethodsLang,
            'rid',
            $this->tableDeliveryMethods,
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
        $this->dropIndex('rid', $this->tableDeliveryMethodsLang);
        $this->dropIndex('fk-shop_delivery_methods_lang-rid-shop_delivery_methods-id', $this->tableDeliveryMethodsLang);
        $this->dropTable($this->tableDeliveryMethodsLang);
    }
}
