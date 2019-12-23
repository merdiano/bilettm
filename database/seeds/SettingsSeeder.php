<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('settings')->delete();
        Schema::enableForeignKeyConstraints();
        DB::table('settings')->insert([
            [
                'key'         => 'contact_email',
                'name'        => 'Contact form email address',
                'description' => 'The email address that all emails will go from.',
                'value'       => 'admin@bilettm.com',
                'field'       => '{"name":"value","label":"Value","type":"email"}',
                'active'      => 1,
            ],[
                'key'         => 'phone',
                'name'        => 'Phone number',
                'description' => 'The phone number where custmers should call',
                'value'       => '+(993) 12 60-60-60',
                'field'       => '{"name":"value","label":"Value","type":"text"}',
                'active'      => 1,
            ],[
                'key'         => 'social_facebook',
                'name'        => 'Facebook page',
                'description' => 'Social facebook address',
                'value'       => 'facebook.com',
                'field'       => '{"name":"value","label":"Value","type":"text"}',
                'active'      => 1,
            ],[
                'key'         => 'social_pinterest',
                'name'        => 'Pinterest page',
                'description' => 'Social Pinterest page address',
                'value'       => 'pinterest.com',
                'field'       => '{"name":"value","label":"Value","type":"text"}',
                'active'      => 1,
            ],[
                'key'         => 'social_linkedin',
                'name'        => 'Linkedin page',
                'description' => 'Social Linkedin page address',
                'value'       => 'linkedin.com',
                'field'       => '{"name":"value","label":"Value","type":"text"}',
                'active'      => 1,
            ],[
                'key'         => 'social_twitter',
                'name'        => 'Twitter page',
                'description' => 'Social Twitter page address',
                'value'       => 'twitter.com',
                'field'       => '{"name":"value","label":"Value","type":"text"}',
                'active'      => 1,
            ],[
                'key'         => 'ticket_text_title',
                'name'        => 'Text title on ticket',
                'description' => 'Text title that will be printed on tickets',
                'value'       => 'Uns berin',
                'field'       => '{"name":"value","label":"Value","type":"text"}',
                'active'      => 1,
            ],[ 'key'         => 'ticket_text',
                'name'        => 'Text on ticket',
                'description' => 'Text that will be printed on tickets',
                'value'       => 'Satyn alynan biletlar yzyny gaytarylanok',
                'field'       => '{"name":"value","label":"Value","type":"text"}',
                'active'      => 1,
            ],[
                'key'         => 'cinema_category_id',
                'name'        => 'Cinema category Id',
                'description' => 'Home page cinema section category id',
                'value'       => 2,
                'field'       => '{"name":"value","label":"Value","type":"number"}',
                'active'      => 1,
            ],[
                'key'         => 'theatre_category_id',
                'name'        => 'Theatre category Id',
                'description' => 'Home page theatre section category id',
                'value'       => 4,
                'field'       => '{"name":"value","label":"Value","type":"number"}',
                'active'      => 1,
            ],[
                'key'         => 'concert_category_id',
                'name'        => 'Concert category Id',
                'description' => 'Home page concert section category id',
                'value'       => 5,
                'field'       => '{"name":"value","label":"Value","type":"number"}',
                'active'      => 1,
            ],
        ]);
    }
}
