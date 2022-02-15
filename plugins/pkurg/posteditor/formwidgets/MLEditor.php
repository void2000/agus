<?php namespace Pkurg\PostEditor\FormWidgets;

use Backend;
use Backend\Classes\FormWidgetBase;
use Pkurg\PostEditor\Models\Settings;
use RainLab\Translate\Models\Locale;
use Twig;
use RainLab\Blog\Models\Post;

/**
 * MLEditor Form Widget
 */
class MLEditor extends FormWidgetBase
{

    use \RainLab\Translate\Traits\MLControl;

    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'pkurg_posteditor_m_l_editor';

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->initLocale();
    }

    /**
     * @inheritDoc
     */
    public function render()
    {

        $this->vars['size'] = $this->formField->size;

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

        $this->vars['backendpath'] = Backend::url('/');

        $this->vars['mediapath'] = config('cms.storage.media.path');

        $this->vars['customblocks'] = Settings::get('customblocks');
        $this->prepareVars();
        return $this->makePartial('mleditor');
    }

    /**
     * prepareVars for view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;

        $this->vars['locales'] = Locale::listAvailable();
        $this->vars['curlang'] = config('app.locale');

        $lang = \Lang::getLocale();
        $LANG = strtoupper($lang);

        $this->vars['l'] = Locale::getDefault()->code;

        $this->vars['lang'] = $lang . '-' . $LANG;
        $this->vars['backendpath'] = Backend::url('/');

        $this->prepareLocaleVars();
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
        // $this->addCss('css/mleditor.css', 'Pkurg.PostEditor');
        // $this->addJs('js/mleditor.js', 'Pkurg.PostEditor');
        $this->addCss('/plugins/pkurg/posteditor/formwidgets/editor/assets/css/grapes.min.css?v=8');
        $this->addCss('/plugins/pkurg/posteditor/formwidgets/editor/assets/css/grapes-code-editor.min.css');
        $this->addCss('/plugins/pkurg/posteditor/formwidgets/editor/assets/css/editor.css?v=2');
        $this->addCss('/plugins/pkurg/posteditor/formwidgets/editor/assets/builder.css?v=93');

        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/grapes.min.js?v=4');

        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/post-editor.js?v=92');

        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/grapesjs-blocks-basic.min.js?v=2');
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/grapesjs-code-editor.min.js?v=2');
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/editor/ckeditor.js?v=2');
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/grapesjs-plugin-ckeditor.min.js?v=2');
        //$this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/vkbeautify.js');
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/text2HTML.js');
        $this->addJs('/plugins/pkurg/posteditor/formwidgets/editor/assets/editor.js?v=22'. uniqid());
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        $localeData = $this->getLocaleSaveData();

        /*
         * Set the translated values to the model
         */
        if ($this->model->methodExists('setAttributeTranslated')) {
            foreach ($localeData as $locale => $value) {

                $v = $value;
                $v = str_replace('><', '>' . PHP_EOL . '<', $v);

                $this->model->setAttributeTranslated('content', $v, $locale);

                $this->model->setAttributeTranslated(
                    'content_html',
                    Post::formatHtml($v),
                    $locale
                );
            }
        }

        foreach ($localeData as &$value) {

            $value = str_replace('><', '>' . PHP_EOL . '<', $value);
        }

        return array_get($localeData, $this->defaultLocale->code, $value);
    }
}
