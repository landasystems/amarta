<?php
$this->Widget('common.extensions.highcharts.HighchartsWidget', array(
    'options' => array(
        'title' => array('text' => 'Exam Comparison'),
        'xAxis' => array(
            'categories' => $x,
        ),
        'yAxis' => array(
            'title' => array('text' => 'Amount')
        ),
        'series' => $series,
        'legend' => array(
            'enabled' => false
        ),
        'credits' => array(
            'enabled' => false
        ),
    )
));
?>