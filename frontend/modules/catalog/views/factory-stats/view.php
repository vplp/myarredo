<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\{
    Factory, ProductStats, ProductStatsDays
};

/** @var $model Factory */
/** @var $modelsStats ProductStats */
/** @var $modelProductStatsDays ProductStatsDays */
/** @var $item ProductStatsDays */

$this->title = $this->context->title;

$labels = [];
$data = [];

foreach ($modelsStats as $item) {
    $labels[$item['date']] = $item['dateTime'];
    $dataViews[$item['date']] = (isset($data[$item['date']]) ? $data[$item['date']] : 0) + $item['views'];
    $dataRequests[$item['date']] = (isset($data[$item['date']]) ? $data[$item['date']] : 0) + $item['requests'];
}

$_js_labels = [];
foreach ($labels as $val) {
    $_js_labels[] = '"' . $val . '"';
}

$js_labels = implode(',', $_js_labels);
$js_data_views = implode(',', $dataViews);
$js_data_requests = implode(',', $dataRequests);

$totalViews = 0;
foreach ($dataViews as $val) {
    $totalViews += $val;
}
$totalRequests = 0;
foreach ($dataRequests as $val) {
    $totalRequests += $val;
}

?>

<main>
    <div class="prod-card-page page">
        <div class="container large-container">
            <div class="row">
                <div class="product-title">
                    <?= Html::tag(
                        'h1',
                        $model->title,
                        ['class' => 'prod-model', 'itemprop' => 'name']
                    ); ?>
                </div>

                <div class="col-md-12 adding-product-page">

                    <?= $this->render('_form_filter', [
                        'model' => $modelProductStatsDays,
                        'params' => $params,
                    ]); ?>

                    <div>
                        <?= Html::img(Factory::getImageThumb($model['image_link'])) ?>
                    </div>
                    <div>
                        <?= Html::a(
                            Yii::t('app', 'Product statistics'),
                            [
                                '/catalog/product-stats/list',
                                'factory_id' => $model['id'],
                                'start_date' => Yii::$app->request->get('start_date'),
                                'end_date' => Yii::$app->request->get('end_date'),
                            ]
                        ) ?>
                    </div>

                    <?php /*
                    <table border="1">
                        <tr>
                            <!--<td>Город</td>
                            <td>Страна</td>-->
                            <td>Количество просмотров</td>
                            <td>Даты</td>
                        </tr>
                        <?php foreach ($modelsStats as $item): ?>
                            <tr>
                                <!--<td><?php //$item['city']['lang']['title'] ?></td>
                                <td><?php //$item['country']['lang']['title'] ?></td>-->
                                <td><?= $item['views'] ?></td>
                                <td><?= $item['dateTime'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    */ ?>

                    <canvas id="myChart"></canvas>

                </div>
            </div>
        </div>
    </div>
</main>

<?php
$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js',
    [
        'position' => yii\web\View::POS_END,
    ]
);

$labelTotalViews = Yii::t('app', 'Количество просмотров: {0}', $totalViews);
$labelTotalRequests = Yii::t('app', 'Количество заявок: {0}', $totalRequests);
$labelViews = Yii::t('app', 'Количество просмотров');
$labelRequests = Yii::t('app', 'Количество заявок');
$labelDates = Yii::t('app', 'Даты');
$labelCounts = Yii::t('app', 'Количество');

$script = <<<JS
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',
    // The data for our dataset
    data: {
        labels: [$js_labels],
        datasets: [{
            label: '$labelViews',             
            borderColor: 'rgb(255, 99, 132)',
            data: [$js_data_views],
            fill: false,
        },
        {
            label: '$labelRequests',             
            borderColor: 'rgb(68, 131, 57)',
            data: [$js_data_requests],
            fill: false,
        }]
    },
    // Configuration options go here
    options: {
        responsive: true,
        title: {
            display: true,
            text: '$labelTotalViews  $labelTotalRequests'
        },
        tooltips: {
            mode: 'index',
            intersect: false,
        },
        hover: {
            mode: 'nearest',
            intersect: true
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: '$labelDates'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: '$labelCounts'
                }
            }]
        }
    }   
});
JS;

$this->registerJs($script, yii\web\View::POS_END);
?>