<?php namespace Pkurg\PostEditor\FormWidgets;

use Backend;
use Backend\Classes\FormWidgetBase;

/**
 * SummerNote Form Widget
 */
class SummerNote extends FormWidgetBase
{

    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'pkurg_posteditor_summer_note';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('summernote');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;

        $lang = \Lang::getLocale();
        $LANG = strtoupper($lang);

        $this->vars['lang'] = $lang . '-' . $LANG;
        //$this->vars['backendpath'] = config('cms.backendUri');
        $this->vars['backendpath'] = Backend::url('/');
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('summernote-lite.min.css', 'Pkurg.PostEditor');

        $this->addJs('summernote-lite.min.js', 'Pkurg.PostEditor');

        $lang = \Lang::getLocale();
        $LANG = strtoupper($lang);

        $this->addJs('lang/summernote-' . $lang . '-' . $LANG . '.js', 'Pkurg.PostEditor');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {

        $v = $value;
        $v = str_replace('><', '>' . PHP_EOL . '<', $v);

        return $v;

    }
}
