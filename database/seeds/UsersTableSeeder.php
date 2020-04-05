<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
        	[
        		'name'		=>	'Lendis Fabri',
        		'email'		=>	'lendisfabri27@gmail.com',
        		'password'	=>	bcrypt('lendis123'),
        		'photos'	=>	'lendis.jpg',
        		'level'		=>	1
        	],
        	[
        		'name'		=>	'Divia Nugrahtino',
        		'email'		=>	'lendisdiary@gmail.com',
        		'password'	=>	bcrypt('qwertyuiop'),
        		'photos'	=>	'avatar.png',
        		'level'		=>	2
        	]
        ));
    }
}
