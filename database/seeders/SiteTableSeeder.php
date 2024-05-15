<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\Activity;
use App\Enums\CurrencyPosition;
use Illuminate\Database\Seeder;
use Dipokhalder\EnvEditor\EnvEditor;
use Illuminate\Support\Facades\Artisan;
use Smartisan\Settings\Facades\Settings;

class SiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $envService = new EnvEditor();
        Settings::group('site')->set([
            'site_date_format'               => 'd-m-Y',
            'site_time_format'               => 'h:i:s',
            'site_default_timezone'          => 'Asia/Jakarta',
            'site_default_branch'            => 1,
            'site_default_currency'          => 1,
            'site_default_currency_symbol'   => '$',
            'site_currency_position'         => CurrencyPosition::LEFT,
            'site_digit_after_decimal_point' => '2',
            'site_email_verification'        => Activity::ENABLE,
            'site_phone_verification'        => Activity::DISABLE,
            'site_default_language'          => 1,
            'site_google_map_key'            => $envService->getValue(
                'DEMO'
            ) ? 'Fake-map-key' : '',
            'site_copyright'                 => $envService->getValue(
                'DEMO'
            ) ? '&copyright; POSLITE by MAXLITE 2024, All Rights Reserved' : '',
            'site_language_switch'        => Activity::ENABLE,
            'site_app_debug'              => Activity::DISABLE,
            'site_auto_update'            => Activity::DISABLE,
            'site_online_payment_gateway' => $envService->getValue('DEMO') ? Activity::ENABLE : Activity::DISABLE,
            'site_default_sms_gateway'    => 0,
            'site_food_preparation_time'  => "30",
        ]);

        $envService->addData([
            'APP_DEBUG'              => 'false',
            'TIMEZONE'               => 'Asia/Jakarta',
            'CURRENCY'               => 'IDR',
            'CURRENCY_SYMBOL'        => 'Rp',
            'CURRENCY_POSITION'      => '5',
            'CURRENCY_DECIMAL_POINT' => '2',
            'DATE_FORMAT'            => 'd-m-Y',
            'TIME_FORMAT'            => 'h:i:s'
        ]);
        Artisan::call('optimize:clear');
    }
}
