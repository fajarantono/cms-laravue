<?php

namespace Database\Seeders;

use Dipokhalder\EnvEditor\EnvEditor;
use App\Enums\Status;
use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'name'      => 'Bintaro',
            'email'     => 'bintaro@bizgrow.biz',
            'phone'     => '+6212345678',
            'latitude'  => -6.2684192,
            'longitude' => 106.7347737,
            'city'      => 'Tangerang Selatan',
            'state'     => 'Banten',
            'zip_code'  => '15145',
            'address'   => 'Perkantoran Multiguna, Jl. Bintaro Utama 3A No.8M, Pd. Pucung, Kec. Pd. Aren, Kota Tangerang Selatan, Banten 15145',
            'status'    => Status::ACTIVE,
        ]);

        $envService = new EnvEditor();
        if ($envService->getValue('DEMO')) {
            Branch::create([
                'name'      => 'Alam Sutera',
                'email'     => 'alamsutera@bizgrow.biz',
                'phone'     => '+6212345679',
                'latitude'  => -6.2240337,
                'longitude' => 106.6597012,
                'city'      => 'Kota Tangerang',
                'state'     => 'Banten',
                'zip_code'  => '15144',
                'address'   => 'Jl. Jalur Sutera Tim. No.6 Blok 1B, RT.001/RW.014, Kunciran, Kec. Pinang, Kota Tangerang, Banten 15144',
                'status'    => Status::ACTIVE,
            ]);
        }
    }
}
