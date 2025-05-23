<?php

namespace Modules\Slider\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Enum\SliderType;
use Illuminate\Database\Eloquent\Model;

class SliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $this->insert();
    }
    public function insert(){
        $data = [
            [
                "title" => [
                    "ar"=> " Slider ar" ,
                    "en"=> "Slider en"
                ],
                "description" => [
                    "ar"=> " Slider ar" ,
                    "en"=> "Slider en"
                ],
                "start_at" => now(),
                "end_at"   => now()->addYears(1)
            ],
            [
                "title" => [
                    "ar"=> " Slider ar" ,
                    "en"=> "Slider en"
                ],
                "description" => [
                    "ar"=> " Slider ar" ,
                    "en"=> "Slider en"
                ],
                "start_at" => now(),
                "end_at"   => now()->addYears(1) ,
                "type"     => SliderType::URL ,
                "value"    => "http:://test.com"
            ]
        ];

        foreach ($data as $object) {
            # code...
            Slider::create($object);
        }
    }

}
