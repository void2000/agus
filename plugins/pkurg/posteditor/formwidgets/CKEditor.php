<?php namespace Pkurg\PostEditor\FormWidgets;

use Backend;
use Backend\Classes\FormWidgetBase;

/**
 * CKEditor Form Widget
 */
class CKEditor extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'pkurg_posteditor_c_k_editor';

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
        return $this->makePartial('ckeditor');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;

        $this->vars['lang'] = \Lang::getLocale();
        $this->vars['backendpath'] = Backend::url('/');

    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/editor/ckeditor.js?v=2');
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
