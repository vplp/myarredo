<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\Product;

/** @var \frontend\modules\catalog\models\Product $model */
/** @var \frontend\modules\catalog\models\ProductStatsDays $item */

$this->title = $this->context->title;

?>

<main>
    <div class="prod-card-page page">
        <div class="container large-container">
            <div class="row">
                <div class="product-title">
                    <?= Html::tag(
                        'h1',
                        $model->getTitle(),
                        ['class' => 'prod-model', 'itemprop' => 'name']
                    ); ?>
                </div>

                <div class="col-md-12">

                    <?= $this->render('_form_filter', [
                        'model' => $modelProductStatsDays,
                        'params' => $params,
                    ]); ?>

                    <?= Html::img(Product::getImageThumb($model['image_link'])) ?>

                    <table border="1">
                        <tr>
                            <!--<td>Город</td>
                            <td>Страна</td>-->
                            <td>Количество просмотров</td>
                            <td>Даты</td>
                        </tr>
                        <?php
                        $labels = [];
                        $data = [];

                        foreach ($modelsStats as $item):
                            $labels[$item['date']] = $item['dateTime'];
                            $data[$item['date']] = (isset($data[$item['date']]) ? $data[$item['date']] : 0) + $item['views'];
                            ?>
                            <tr>
                                <!--<td><?php //$item['city']['lang']['title'] ?></td>
                                <td><?php //$item['country']['lang']['title'] ?></td>-->
                                <td><?= $item['views'] ?></td>
                                <td><?= $item['dateTime'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>


                    <canvas id="myChart"></canvas>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<?php
$_js_labels = [];
foreach ($labels as $val) {
    $_js_labels[] = '"'.$val.'"';
}
$js_labels = implode(',', $_js_labels);

$js_data = implode(',', $data);

$script = <<<JS
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: [$js_labels],
        datasets: [{
            label: "Количество просмотров",             
            borderColor: 'rgb(255, 99, 132)',
            data: [$js_data],
            fill: false,
        }]
    },

    // Configuration options go here
    options: {
        responsive: true,
        title: {
            display: true,
            text: ''
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
                    labelString: 'Даты'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Количество'
                }
            }]
        }
    }
});
JS;

$this->registerJs($script, yii\web\View::POS_END);
?>
                </div>
            </div>
        </div>
    </div>
</main>