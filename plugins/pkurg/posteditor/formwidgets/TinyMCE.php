<?php namespace Pkurg\PostEditor\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * TinyMCE Form Widget
 */
class TinyMCE extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'pkurg_posteditor_tiny_m_c_e';

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
        return $this->makePartial('tinymce');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/tinymce.css', 'Pkurg.PostEditor');
        $this->addJs('js/tinymce.js', 'Pkurg.PostEditor');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
