<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Authorization\Entities\Permission;

class CreatePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create {route :  route name like users}';

    protected $mapKey = [
        "show" => [
            "lang" => [
                "display_name" => [
                    "ar" => "عرض",
                    "en" => "show"
                ] ,
               
            ]
        ],
        "add" => [
            "lang" => [
                "display_name" => [
                    "ar" => "أضافه",
                    "en" => "add"
                ] ,
                 
            ]
        ],
        "edit" => [
            "lang" => [
                "display_name" => [
                    "ar" => "تعديل" ,
                    "en" => "edit"
                ] ,

                
            ]
        ],
        "delete" => [
            "lang" => [
                "display_name" => [
                    "ar" => "حذف" ,
                    "en" => "delete"
                ] ,
                 
            ]
        ],
    ];

    protected $RegisterKey = [
        "show" => [
            "lang" => [
                "display_name" => [
                    "ar" => "عرض",
                    "en" => "show"
                ] ,
               
            ]
        ],
       
    ];

    protected $NotificationMapKey = [
        "show" => [
            "lang" => [
                "display_name" => [
                    "ar" => "الاشعارات العامة",
                    "en" => "General Notifications"
                ] ,
               
            ]
        ],
       
       
        
    ];

    protected $ContactUsMapKey = [
        "show" => [
            "lang" => [
                "display_name" => [
                    "ar" => "عرض",
                    "en" => "Show"
                ] ,
               
            ]
        ],

        "delete" => [
            "lang" => [
                "display_name" => [
                    "ar" => "حذف" ,
                    "en" => "delete"
                ] ,
                 
            ]
        ],
        
    ];

    protected $statisticsMapKey = [
        "show" => [
            "lang" => [
                "display_name" => [
                    "ar" => "الاحصائيات",
                    "en" => "Statistics"
                ] ,
               
            ]
        ],
       
       
        
    ];


   


    /**
     * The console command display_name.
     *
     * @var string
     */
    protected $display_name = 'create permission for the routes ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $route = $this->argument('route');
        $route = trim($route);

        $routeSingular = $route;
       
        // Permission::where("display_name", $route)->delete();
        $maps = $this->mapKey;


        if ($routeSingular == "notifications") {
            $maps = $this->NotificationMapKey;
        }

        if ($routeSingular == "statistics") {
            $maps = $this->statisticsMapKey;
        }

        if ($routeSingular == "contacts_us") {
            $maps = $this->ContactUsMapKey;
        }

        if ($routeSingular == "register_circles") {
            $maps = $this->RegisterKey;
        }
        

        foreach ($maps as $key => $value) {
            # code...
            Permission::updateOrCreate(
                ["name"        => $key."_".$routeSingular ],
                array_merge(
                    [
                    'category' => $routeSingular,
                    'guard_name' => 'web',
                    'routes' =>""
                ],
                    $value["lang"]
                )
            );
        }
        
        $this->info("done");
    }
}
