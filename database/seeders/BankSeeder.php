<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'name' => 'Bank Central Asia (BCA)',
                'code' => 'BCA',
                'account_name' => 'PT Ticketing Laravel',
                'account_number' => '1234567890',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/2560px-Bank_Central_Asia.svg.png',
            ],
            [
                'name' => 'Bank Mandiri',
                'code' => 'MANDIRI',
                'account_name' => 'PT Ticketing Laravel',
                'account_number' => '0987654321',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/2560px-Bank_Mandiri_logo_2016.svg.png',
            ],
            [
                'name' => 'Bank Negara Indonesia (BNI)',
                'code' => 'BNI',
                'account_name' => 'PT Ticketing Laravel',
                'account_number' => '1122334455',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/1200px-BNI_logo.svg.png',
            ],
            [
                'name' => 'Bank Rakyat Indonesia (BRI)',
                'code' => 'BRI',
                'account_name' => 'PT Ticketing Laravel',
                'account_number' => '5544332211',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/2560px-BANK_BRI_logo.svg.png',
            ],
            [
                'name' => 'Bank Syariah Indonesia (BSI)',
                'code' => 'BSI',
                'account_name' => 'PT Ticketing Laravel',
                'account_number' => '7788990011',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Bank_Syariah_Indonesia.svg/2560px-Bank_Syariah_Indonesia.svg.png',
            ],
            [
                'name' => 'CIMB Niaga',
                'code' => 'CIMB',
                'account_name' => 'PT Ticketing Laravel',
                'account_number' => '2233445566',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/CIMB_Niaga_logo.svg/2560px-CIMB_Niaga_logo.svg.png',
            ],
        ];

        foreach ($banks as $bank) {
            Bank::updateOrCreate(['code' => $bank['code']], $bank);
        }
    }
}
