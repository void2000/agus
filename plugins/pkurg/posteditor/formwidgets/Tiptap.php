<?php namespace Pkurg\PostEditor\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * tiptap Form Widget
 */
class Tiptap extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'pkurg_posteditor_tiptap';

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
        return $this->makePartial('tiptap');
    }

    /**
     * prepareVars for view data
     */
    public function prepareVars()
    {
     

        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['curlang'] = config('app.locale');
        //$this->vars['basepath'] = url('/');
    }

    public function urls($url)
    {
        return url($url);
    }


    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        
        // $this->addCss('css/tiptap.css', 'Pkurg.PostEditor');
        // $this->addJs('js/tiptap.js', 'Pkurg.PostEditor');


        // $this->addCss('css/chunk-vendors.d6e43ad4.css', 'Pkurg.PostEditor');
        // $this->addJs('js/chunk-vendors.930309d2.js', 'Pkurg.PostEditor');
        // $this->addJs('js/app.f73907df.js', 'Pkurg.PostEditor');


    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
