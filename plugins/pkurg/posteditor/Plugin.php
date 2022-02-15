<?php namespace Pkurg\PostEditor;

use Cms\Classes\Controller as CMSController;
use Config;
use Event;
use Pkurg\PostEditor\Models\Settings;
use System\Classes\PluginBase;
use System\Classes\PluginManager;
use System\Classes\SettingsManager;

class Plugin extends PluginBase
{

    public $require = ['RainLab.Blog'];

    public function registerMarkupTags()
    {
        return [
            'filters' => [

                'theme' => [$this, 'CanvasAssets'],
            ],

        ];
    }

    public function CanvasAssets($url)
    {

        $Controller = new CMSController;
        return $Controller->themeUrl($url);

    }

    public function registerPermissions()
    {
        return [
            'pkurg.posteditor.manage' => [
                'tab' => 'Post Editor',
                'label' => 'Manage Post Editor',
            ],

        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'Post Editor',
                'description' => 'Manage Post Editor settings.',
                'category' => SettingsManager::CATEGORY_CMS,
                'icon' => 'oc-icon-edit',
                'class' => 'Pkurg\PostEditor\Models\Settings',
                'order' => 500,
                'permissions' => ['pkurg.posteditor.manage'],

            ],
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'Pkurg\PostEditor\FormWidgets\Editor' => 'grapeposteditor',
            'Pkurg\PostEditor\FormWidgets\MLEditor' => 'mlgrapeposteditor',

            'Pkurg\PostEditor\FormWidgets\SummerNote' => 'summernote',
            'Pkurg\PostEditor\FormWidgets\MLSummerNote' => 'mlsummernote',

            'Pkurg\PostEditor\FormWidgets\CKEditor' => 'ckeditor',
            'Pkurg\PostEditor\FormWidgets\MLCKEditor' => 'mlckeditor',

            'Pkurg\PostEditor\FormWidgets\Tiptap' => 'tiptapeditor',
            'Pkurg\PostEditor\FormWidgets\MLTiptap' => 'mltiptapeditor',

        ];
    }

    public function boot()
    {

        //Old config support
        if (class_exists('\Editor\Controllers\Index')) {

            Config::set('cms.storage.media.folder', Config::get('system.storage.media.folder'));
            Config::set('cms.storage.media.path', Config::get('system.storage.media.path'));
        }

        if (is_null(Settings::get('useeditor'))) {

            Settings::set('savelocal', 'grapesjs');

        }

        if (is_null(Settings::get('savelocal'))) {

            Settings::set('savelocal', 1);

        }
        if (is_null(Settings::get('show_page'))) {

            Settings::set('show_page', 1);

        }

        Event::listen('backend.form.extendFields', function ($form) {

            if ((Settings::get('useeditor') == 'grapesjs') && $form->model instanceof \RainLab\Blog\Models\Post) {

                $this->replaceEditor($form, 'Pkurg\PostEditor\FormWidgets\Editor', 'Pkurg\PostEditor\FormWidgets\MLEditor');

            }

            if ((Settings::get('useeditor') == 'summernote') && $form->model instanceof \RainLab\Blog\Models\Post) {

                $this->replaceEditor($form, 'Pkurg\PostEditor\FormWidgets\SummerNote', 'Pkurg\PostEditor\FormWidgets\MLSummerNote');

            }

            if ((Settings::get('useeditor') == 'ckeditor') && $form->model instanceof \RainLab\Blog\Models\Post) {

                $this->replaceEditor($form, 'Pkurg\PostEditor\FormWidgets\CKEditor', 'Pkurg\PostEditor\FormWidgets\MLCKEditor');

            }

            if ((Settings::get('useeditor') == 'tiptap') && $form->model instanceof \RainLab\Blog\Models\Post) {

                $this->replaceEditor($form, 'Pkurg\PostEditor\FormWidgets\Tiptap', 'Pkurg\PostEditor\FormWidgets\MLTiptap');

            }

        });

    }

    public function replaceEditor($form, $editor, $mleditor)
    {

        $replacable = [
            'codeeditor', 'Eein\Wysiwyg\FormWidgets\Trumbowyg', 'richeditor', 'RainLab\Blog\FormWidgets\BlogMarkdown',
            'RainLab\Blog\FormWidgets\MLBlogMarkdown', 'mlricheditor',
        ];

        foreach ($form->getFields() as $field) {

            if (!empty($field->config['type']) && in_array($field->config['type'], $replacable)) {

                if (PluginManager::instance()->exists('RainLab.Translate')) {

                    if (count(\RainLab\Translate\Models\Locale::listAvailable()) > 1) {
                        $field->config['type'] = $field->config['widget'] = $mleditor;
                    } else {
                        $field->config['type'] = $field->config['widget'] = $editor;
                    }

                } else {
                    $field->config['type'] = $field->config['widget'] = $editor;
                }

                return;
            }
        }
    }

}
