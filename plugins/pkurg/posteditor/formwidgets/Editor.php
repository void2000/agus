<?php namespace Pkurg\PostEditor\FormWidgets;

use Backend;
use Backend\Classes\FormWidgetBase;
use Pkurg\PostEditor\Models\Settings;
use Twig;

class Editor extends FormWidgetBase
{

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'posteditor';

    public function render()
    {

        $this->vars['size'] = $this->formField->size;

        //dd($this->vars['size']);

        $this->vars['name'] = $this->getFieldName();
        $this->vars['value'] = $this->getLoadValue();

        if (Settings::get('builder_styles')) {
            $this->vars['builder_styles'] = Twig::parse(Settings::get('builder_styles'));
        } else {
            $this->vars['builder_styles'] = '';
        }

        if (Settings::get('builder_scripts')) {
            $this->vars['builder_scripts'] = Twig::parse(Settings::get('builder_scripts'));
        } else {
            $this->vars['builder_scripts'] = '';
        }

        $this->vars['canvasAssets'] = 'styles: [' . $this->vars['builder_styles'] . '],    scripts: [' . $this->vars['builder_scripts'] . ']';

        $this->vars['curdir'] = url('/');

        // $this->vars['backendpath'] = config('cms.backendUri');
        $this->vars['backendpath'] = Backend::url('/');
        
        $this->vars['mediapath'] = config('cms.storage.media.path');

        $this->vars['customblocks'] = Settings::get('customblocks');

        return $this->makePartial('builder');
    }

    public function loadAssets()
    {

        $this->addCss('/plugins/pkurg/posteditor/formwidgets/editor/assets/css/grapes.min.css?v=8');
        $this->addCss('/plugins/pkurg/posteditor/formwidgets/editor/assets/css/grapes-code-editor.min.css');
        $this->addCss('/plugins/pkurg/posteditor/formwidgets/editor/assets/css/editor.css?v=2');
        $this->addCss('/plugins/pkurg/posteditor/formwidgets/editor/assets/builder.css?v=9');

        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/grapes.min.js?v=4');

        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/post-editor.js?v=92');

        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/grapesjs-blocks-basic.min.js?v=2');
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/grapesjs-code-editor.min.js?v=2');
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/editor/ckeditor.js?v=2');
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/grapesjs-plugin-ckeditor.min.js?v=2');
        //$this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/vkbeautify.js');
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/text2HTML.js');
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/editor.js?v=92');

    }

}
