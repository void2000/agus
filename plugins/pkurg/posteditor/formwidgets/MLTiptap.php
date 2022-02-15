<?php namespace Pkurg\PostEditor\FormWidgets;

use Backend;
use Backend\Classes\FormWidgetBase;
use RainLab\Blog\Models\Post;
use RainLab\Translate\Models\Locale;

/**
 * MLtiptap Form Widget
 */
class MLTiptap extends FormWidgetBase
{

    use \RainLab\Translate\Traits\MLControl;
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'pkurg_posteditor_m_ltiptap';

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
        $this->prepareVars();
        return $this->makePartial('mltiptap');
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

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/mltiptap.css', 'Pkurg.PostEditor');
        $this->addJs('js/mltiptap.js', 'Pkurg.PostEditor');
    }

    public function urls($url)
    {
        return url($url);
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
