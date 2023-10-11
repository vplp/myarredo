<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190604_085650_add_indexes_for_catalog_tables extends Migration
{
    // Category
    public $tableCategoryLang = '{{%catalog_group_lang}}';

    // Collection
    public $tableCollection = '{{%catalog_collection}}';
    public $tableCollectionLang = '{{%catalog_collection_lang}}';

    // Colors
    public $tableColors = '{{%catalog_colors}}';
    public $tableColorsLang = '{{%catalog_colors_lang}}';

    // Factory
    public $tableFactory = '{{%catalog_factory}}';
    public $tableFactoryLang = '{{%catalog_factory_lang}}';
    public $tableFactoryFile = '{{%catalog_factory_file}}';

    // ItalianProduct
    public $tableItalianProduct = '{{%catalog_italian_item}}';

    // Product
    public $tableProduct = '{{%catalog_item}}';

    // ProductStats
    public $tableProductStats = '{{%catalog_item_stats}}';

    // ProductStatsDays
    public $tableProductStatsDays = '{{%catalog_item_stats_days}}';

    // Sale
    public $tableSale = '{{%catalog_sale_item}}';

    // SaleLang
    public $tableSaleLang = '{{%catalog_sale_item_lang}}';

    // SalePhoneRequest
    public $tableSalePhoneRequest = '{{%catalog_sale_item_phone_request}}';

    // SaleRequest
    public $tableSaleRequest = '{{%catalog_sale_item_request}}';

    // SaleStats
    public $tableSaleStats = '{{%catalog_sale_item_stats}}';

    // TypesLang
    public $tableTypesLang = '{{%catalog_type_lang}}';

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
        // CategoryLang
        $this->createIndex('title', $this->tableCategoryLang, 'title');

        // Collection
        $this->createIndex('user_id', $this->tableCollection, 'user_id');
        $this->createIndex('title', $this->tableCollection, 'title');
        $this->dropIndex('updated', $this->tableCollection);
        $this->createIndex('updated_at', $this->tableCollection, 'updated_at');
        $this->createIndex('moderation', $this->tableCollection, 'moderation');

        // CollectionLang
        if ($this->db->getTableSchema($this->tableCollectionLang, true) != null) {
            $this->dropTable($this->tableCollectionLang);
        }

        // Colors
        $this->createIndex('updated_at', $this->tableColors, 'updated_at');

        // ColorsLang
        $this->createIndex('title', $this->tableColorsLang, 'title');
        $this->createIndex('plural_title', $this->tableColorsLang, 'plural_title');

        // Factory
        $this->createIndex('title', $this->tableFactory, 'title');
        $this->createIndex('first_letter', $this->tableFactory, 'first_letter');
        $this->createIndex('position', $this->tableFactory, 'position');
        //$this->createIndex('partner_id', $this->tableFactory, 'partner_id');
        $this->createIndex('alternative', $this->tableFactory, 'alternative');
        $this->createIndex('show_for_ru', $this->tableFactory, 'show_for_ru');
        $this->createIndex('show_for_by', $this->tableFactory, 'show_for_by');
        $this->createIndex('show_for_ua', $this->tableFactory, 'show_for_ua');

        // FactoryFile
        $this->createIndex('published', $this->tableFactoryFile, 'published');
        $this->createIndex('deleted', $this->tableFactoryFile, 'deleted');
        $this->createIndex('position', $this->tableFactoryFile, 'position');
        $this->createIndex('updated_at', $this->tableFactoryFile, 'updated_at');

        // ItalianProduct
        $this->createIndex('updated_at', $this->tableItalianProduct, 'updated_at');

        // Product
        $this->createIndex('updated_at', $this->tableProduct, 'updated_at');

        // ProductStats
        $this->createIndex('product_id', $this->tableProductStats, 'product_id');
        $this->createIndex('city_id', $this->tableProductStats, 'city_id');
        $this->createIndex('updated_at', $this->tableProductStats, 'updated_at');

        // ProductStatsDays
        $this->createIndex('views', $this->tableProductStatsDays, 'views');
        $this->createIndex('requests', $this->tableProductStatsDays, 'requests');
        $this->createIndex('updated_at', $this->tableProductStatsDays, 'updated_at');

        // Sale
        $this->createIndex('country_id', $this->tableSale, 'country_id');
        $this->createIndex('city_id', $this->tableSale, 'city_id');
        $this->createIndex('user_city_id', $this->tableSale, 'user_city_id');
        $this->createIndex('on_main', $this->tableSale, 'on_main');

        // SaleLang
        $this->createIndex('title', $this->tableSaleLang, 'title');

        // SalePhoneRequest
        $this->createIndex('updated_at', $this->tableSalePhoneRequest, 'updated_at');

        // SaleRequest
        $this->createIndex('updated_at', $this->tableSaleRequest, 'updated_at');

        // SaleStats
        $this->createIndex('updated_at', $this->tableSaleStats, 'updated_at');

        // TypesLang
        $this->createIndex('title', $this->tableTypesLang, 'title');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        // CategoryLang
        $this->dropIndex('title', $this->tableCategoryLang);

        // Collection
        $this->dropIndex('user_id', $this->tableCollection);
        $this->dropIndex('title', $this->tableCollection);
        $this->createIndex('updated', $this->tableCollection, 'updated_at');
        $this->dropIndex('updated_at', $this->tableCollection);
        $this->dropIndex('moderation', $this->tableCollection);

        // Colors
        $this->dropIndex('updated_at', $this->tableColors);

        // ColorsLang
        $this->dropIndex('title', $this->tableColorsLang);
        $this->dropIndex('plural_title', $this->tableColorsLang);

        // Factory
        $this->dropIndex('title', $this->tableFactory);
        $this->dropIndex('first_letter', $this->tableFactory);
        $this->dropIndex('position', $this->tableFactory);
        $this->dropIndex('alternative', $this->tableFactory);
        $this->dropIndex('show_for_ru', $this->tableFactory);
        $this->dropIndex('show_for_by', $this->tableFactory);
        $this->dropIndex('show_for_ua', $this->tableFactory);

        // FactoryFile
        $this->dropIndex('published', $this->tableFactoryFile);
        $this->dropIndex('deleted', $this->tableFactoryFile);
        $this->dropIndex('position', $this->tableFactoryFile);
        $this->dropIndex('updated_at', $this->tableFactoryFile);

        // ItalianProduct
        $this->dropIndex('updated_at', $this->tableItalianProduct);

        // Product
        $this->dropIndex('updated_at', $this->tableProduct);

        // ProductStats
        $this->dropIndex('product_id', $this->tableProductStats);
        $this->dropIndex('city_id', $this->tableProductStats);
        $this->dropIndex('updated_at', $this->tableProductStats);

        // ProductStatsDays
        $this->dropIndex('views', $this->tableProductStatsDays);
        $this->dropIndex('requests', $this->tableProductStatsDays);
        $this->dropIndex('updated_at', $this->tableProductStatsDays);

        // Sale
        $this->dropIndex('country_id', $this->tableSale);
        $this->dropIndex('city_id', $this->tableSale);
        $this->dropIndex('user_city_id', $this->tableSale);
        $this->dropIndex('on_main', $this->tableSale);

        // SaleLang
        $this->dropIndex('title', $this->tableSaleLang);

        // SalePhoneRequest
        $this->dropIndex('updated_at', $this->tableSalePhoneRequest);

        // SaleRequest
        $this->dropIndex('updated_at', $this->tableSaleRequest);

        // SaleStats
        $this->dropIndex('updated_at', $this->tableSaleStats);

        // TypesLang
        $this->dropIndex('title', $this->tableTypesLang);
    }
}
