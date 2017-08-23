<?php

namespace fourteenmeister\extensions;

use yii\web\AssetBundle;

class PickadateAsset extends AssetBundle
{

    public $sourcePath = '@bower/pickadate/lib';

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init()
    {
        $compressed = YII_DEBUG ? '' : 'compressed/';
        $this->js = [
            "{$compressed}picker.js",
            "{$compressed}legacy.js",
            "{$compressed}picker.date.js",
            "{$compressed}picker.time.js",
        ];
        $this->css = [
            "{$compressed}themes/default.css",
            "{$compressed}themes/default.date.css",
            "{$compressed}themes/default.time.css",
        ];
        parent::init();
    }

}
