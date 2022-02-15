<?php

namespace Pkurg\PostEditor\Models;

use Model;

class Settings extends Model
{

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'builder_posteditor_settings';

    public $settingsFields = 'fields.yaml';

    protected $cache = [];

    

}
