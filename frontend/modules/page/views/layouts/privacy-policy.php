<?php

use frontend\themes\vents\assets\AppAsset;

$bundle = AppAsset::register($this);

$this->beginContent('@app/layouts/main.php');
?>

    <div class="confid-wr">
        <div class="inner">

            <?= $this->render('@app/layouts/parts/_header', ['bundle' => $bundle]) ?>

            <?= $content ?>

        </div>
        <div class="info">
            <div class="in-world">
                <p class="feature"><?= Yii::t('app', 'In the world') ?></p>
                <a href="#" class="button"><?= Yii::t('app', 'Learn more') ?></a>
            </div>
            <div class="in-number">
                <p class="feature"><?= Yii::t('app', 'In numbers') ?></p>
                <div class="jcarousel2">
                    <ul>
                        <li>
                            <div class="ach">
                                <span>7</span>
                                <p>The ventilating equipment and accessories plants are located in Europe</p>
                            </div>
                        </li>
                        <li>
                            <div class="ach">
                                <span>23</span>
                                <p>Saleshouses in 15 countries all around the world</p>
                            </div>
                        </li>
                        <li>
                            <div class="ach">
                                <span>25</span>
                                <p>Years of experience in production of hi-tech energy-efficient ventilation equipment</p>
                            </div>
                        </li>
                        <li>
                            <div class="ach">
                                <span>105</span>
                                <p>Quantity of the countries in which our production is on sale</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="jcarousel-pagination">
                    <!-- Pagination items will be generated in here -->
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>