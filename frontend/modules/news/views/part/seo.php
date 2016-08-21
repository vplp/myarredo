<?php
use frontend\themes\defaults\assets\AppAsset;
use yii\helpers\Html;

$bundle = AppAsset::register($this);
/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
?>

<script type="application/ld+json">
        {
        "@context": "http://schema.org",
        "@type": "NewsArticle",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "https://google.com/article"
            },
        "headline": "<?= Html::encode($article['lang']['title']) ?>",
        "image": {
            "@type": "ImageObject",
            "url": "<?php if (!empty($article->getArticleImage())) {
        echo Yii::$app->request->hostInfo . $article->getArticleImage();
    } else {
        echo Yii::$app->request->hostInfo . $bundle->baseUrl . '/img/logo.png';
    } ?>",
            "height": "116",
            "width": "76"
            },
        "datePublished": "<?= date('Y-m-d', $article->published_time) ?>",
        "dateModified": "<?= date('Y-m-d', $article->updated_at) ?>",
        "author": {
            "@type": "Person",
            "name": "vents"
            },
        "publisher": {
            "@type": "Organization",
            "name": "<?= Yii::$app->request->hostInfo ?>",
            "logo": {
                    "@type": "ImageObject",
                     "width": "358",
                    "height": "98",
                    "url": "<?= Yii::$app->request->hostInfo . $bundle->baseUrl ?>/img/logo.png"
                }
            },
        "description": "<?= $article['lang']['description'] ?>"
        }
</script>