<?php

namespace Database\Seeders;

use Dipokhalder\EnvEditor\EnvEditor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Smartisan\Settings\Facades\Settings;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::group('company')->set([
            'company_name'         => 'POSLITE - Alfanium Indonesia Digital',
            'company_email'        => 'fajarantono.id@gmail.com',
            'company_phone'        => '+621234567',
            'company_website'      => 'https://alfanium.id',
            'company_city'         => 'Jakarta Barat',
            'company_state'        => 'DKI Jakarta',
            'company_country_code' => 'ID',
            'company_zip_code'     => '11750',
            'company_address'      => 'Jl. Cemara 3 No. 1, Duri Kosambi, Cengkareng, Jakarta Barat 11750'
        ]);

        $envService = new EnvEditor();
        $envService->addData([
            'APP_NAME' => "POSLITE - Go Digital"
        ]);

        Artisan::call('optimize:clear');
    }
}
