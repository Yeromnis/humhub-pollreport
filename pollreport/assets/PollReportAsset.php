<?php

namespace humhub\modules\pollreport\assets;

use yii\web\AssetBundle;

class PollReportAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $sourcePath = '@pollreport/resources';
    public $css = [];
    public $js = [
        'js/pollreport.js',
    ];
}