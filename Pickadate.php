<?php

namespace fourteenmeister\extensions;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

class Pickadate extends \yii\widgets\InputWidget
{
    public $editable = false;
    public $options = [];
    public $clientOptions = [];
    public $isTime = false;
    public $containerOptions = [];
    public $language = 'en';
    public $enableBlur = true;
    public $autoPlaceholder = true;

    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'form-control');
        isset($this->options['id'])
            ? $this->setId($this->options['id'])
            : $this->options['id'] = $this->getId();
        if($this->editable && !isset($this->clientOptions['editable']))
            $this->clientOptions['editable'] = true;
        if($this->enableBlur && !isset($this->clientOptions['onClose'])) {
            $callback = new JsExpression("function(){
                $(document.activeElement).blur()
            }");
            $this->clientOptions['onClose'] = $callback;
        }
        $this->registerJs();
    }

    /**
     * @return string
     */
    public function run()
    {
        echo Html::tag('div', $this->renderInput(), $this->containerOptions);
    }

    public function registerJs()
    {
        $view = $this->getView();
        $selector = "#{$this->options['id']}";
        if($this->language != 'en') {
            $pickadateAsset = \Yii::$app->assetManager->getBundle(PickadateAsset::className());
            $pickadateAsset->js[] =  YII_DEBUG ? "translations/{$this->language}.js" : "compressed/translations/{$this->language}.js";
        }
        PickadateAsset::register($view);
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        if ($this->isTime === true) {
            $useMethod = 'pickatime';
        } else {
            $useMethod = 'pickadate';
        }
        $view->registerJs("jQuery('$selector').$useMethod($clientOptions);");
        $view->registerCss(".form-control.picker__input[readonly] {background: none !important;}");
    }

    public function renderInput()
    {
        Html::addCssClass($this->options, 'field');
        if ($this->hasModel()) {
            if($this->autoPlaceholder && !$this->options['placeholder']) {
                $this->options['placeholder'] = $this->model->getAttributeLabel($this->attribute);
            }
            $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::textInput($this->name, $this->value, $this->options);
        }
        return $input;
    }

}