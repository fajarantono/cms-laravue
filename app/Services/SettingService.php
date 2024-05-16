<?php

namespace App\Services;

use Smartisan\Settings\Facades\Settings;

class SettingService
{
    public function list() : array
    {
        $array = [];
        $array = array_merge($array, Settings::group('company')->all());
        $array = array_merge($array, Settings::group('site')->all());
        return $array = array_merge($array, Settings::group('theme')->all());
    }
}
