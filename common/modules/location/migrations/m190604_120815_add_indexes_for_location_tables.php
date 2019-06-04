<?php

use yii\db\Migration;
//
use common\modules\location\Location;

class m190604_120815_add_indexes_for_location_tables extends Migration
{
    // City
    public $tableCity = '{{%location_city}}';

    // CityLang
    public $tableCityLang = '{{%location_city_lang}}';

    // Country
    public $tableCountry = '{{%location_country}}';

    // CountryLang
    public $tableCountryLang = '{{%location_country_lang}}';

    // Region
    public $tableRegion = '{{%location_region}}';

    // RegionLang
    public $tableRegionLang = '{{%location_region_lang}}';

    // Currency
    public $tableCurrency = '{{%location_currency}}';

    // CurrencyLang
    public $tableCurrencyLang = '{{%location_currency_lang}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Location::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        // City
        $this->createIndex('updated_at', $this->tableCity, 'updated_at');
        $this->createIndex('position', $this->tableCity, 'position');

        // CityLang
        $this->createIndex('title', $this->tableCityLang, 'title');

        // Country
        $this->createIndex('updated_at', $this->tableCountry, 'updated_at');
        $this->createIndex('position', $this->tableCountry, 'position');

        // CountryLang
        $this->createIndex('title', $this->tableCountryLang, 'title');

        // Region
        $this->createIndex('updated_at', $this->tableRegion, 'updated_at');

        // RegionLang
        $this->createIndex('title', $this->tableRegionLang, 'title');

        // Currency
        $this->createIndex('updated_at', $this->tableCurrency, 'updated_at');

        // CurrencyLang
        $this->createIndex('title', $this->tableCurrencyLang, 'title');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        // City
        $this->dropIndex('updated_at', $this->tableCity);
        $this->dropIndex('position', $this->tableCity);

        // CityLang
        $this->dropIndex('position', $this->tableCityLang);

        // Country
        $this->dropIndex('updated_at', $this->tableCountry);
        $this->dropIndex('position', $this->tableCountry);

        // CountryLang
        $this->dropIndex('title', $this->tableCountryLang);

        // Region
        $this->dropIndex('updated_at', $this->tableRegion);

        // RegionLang
        $this->dropIndex('title', $this->tableRegionLang);

        // Currency
        $this->dropIndex('updated_at', $this->tableCurrency);

        // CurrencyLang
        $this->dropIndex('title', $this->tableCurrencyLang);
    }
}
