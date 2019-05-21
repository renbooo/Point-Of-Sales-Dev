<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert(array(
        	[
	            'company_name'			=>	'kopiding.in',
	            'company_address'		=>	'lamongan',
	            'company_phone_number'	=>	'123456789',
	            'company_logo'			=>	'shield.svg',
	            'member_card'			=>	'card.jpg',
	            'member_discount'		=>	'20',
	            'note_type'				=>	'0'
	        ]

        ));
    }
}
