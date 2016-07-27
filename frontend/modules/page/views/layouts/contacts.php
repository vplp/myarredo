<?php

use frontend\themes\vents\assets\AppAsset;

$bundle = AppAsset::register($this);
Yii::$app->view->registerJsFile($bundle->baseUrl . '/js/map/map1.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->beginContent('@app/layouts/main.php');
?>
    <div class="contact-wr">
        <div id="map1"></div>
        <div class="shadow"></div>

        <?= $this->render('@app/layouts/parts/_header', ['bundle' => $bundle]) ?>
        <div class="content">

            <div class="contact">

                <div class="left-part">
                    <div class="left-corner"></div>
                    <div class="line"></div>
                </div>

                <?php //$content ?>

                <p class="title">контакты:</p>
                <div class="branch clearfix">
                    <p>По вопросам поставки продукции по територии Украины:<span>+38 (044) 406-36-27</span><span>+38 (044) 406-07-50</span></p>
                    <p>Служба поддержки клиентов:<span class="pd">0-800-501-74-80</span><span class="free">бесплатно со стационарных телефонов Украины</span></p>
                    <p class="export">Отдел экспорта:<span>+38 (044) 406-36-25</span></p>
                    <p class="cadr">Отдел кадров:<span>+38 (044) 406-36-26</span></p>
                </div>
                <p class="adr">Украина, 01030, г.Киев, ул.М.Коцюбинского, 1</p>
                <div class="right-part">
                    <div class="line"></div>
                    <div class="right-corner"></div>
                </div>

            </div>
        </div>
    </div>
    <div class="form-wr">
        <div class="form">
            <?= \frontend\modules\page\widgets\Feedback\Feedback::widget() ?>

        </div>
    </div>
    <!-- Контакты -->
    <script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "Organization",
 "url": "<?= Yii::$app->getUrlManager()->getHostInfo(); ?>",
 "logo": {
       "@type": "ImageObject",
       "url": "<?= Yii::$app->getUrlManager()->getHostInfo() . $bundle->baseUrl ?>/img/logo.png",
       "width": "174",
       "height": "77"
       },
 "contactPoint": [{
       "@type": "ContactPoint",
       "telephone": "+38(044)406-36-27",
       "contactType": "customer service"
       },
       {
       "@type": "ContactPoint",
       "telephone": "+3800-501-74-80",
       "contactType": "customer service"
       }],

   "location": {
           "@type": "PostalAddress",
           "addressLocality": "Ukraine",
           "addressRegion": "Kiev",
           "postalCode": "01030",
           "streetAddress": "Kotsyubyns'kogo street 1"
           }

}
</script>
<?php $this->endContent(); ?>