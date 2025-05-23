<?php

return [
    'admins'            => [
        'create'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General Info.',
                'image'             => 'Profile Image',
                'info'              => 'Info.',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Password',
                'roles'             => 'Roles',
            ],
            'title' => 'Create Admins',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'email'         => 'Email',
            'image'         => 'Image',
            'mobile'        => 'Mobile',
            'name'          => 'Name',
            'options'       => 'Options',
        ],
        'index'     => [
            'title' => 'Admins',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'Confirm Password',
                'email'             => 'Email',
                'general'           => 'General info.',
                'image'             => 'Profile Image',
                'mobile'            => 'Mobile',
                'name'              => 'Name',
                'password'          => 'Change Password',
                'roles'             => 'Roles',
            ],
            'title' => 'Update Admins',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'Please enter the email of admin',
                'unique'    => 'This email is taken before',
            ],
            'mobile'    => [
                'digits_between'    => 'Please add mobile number only 8 digits',
                'numeric'           => 'Please enter the mobile only numbers',
                'required'          => 'Please enter the mobile of admin',
                'unique'            => 'This mobile is taken before',
            ],
            'name'      => [
                'required'  => 'Please enter the name of admin',
            ],
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'Please enter the password of admin',
                'same'      => 'The Password confirmation not matching',
            ],
            'roles'     => [
                'required'  => 'Please select the role of admin',
            ],
        ],
    ],
    'users'             => [
        'statistics' =>
        [
            'title' => 'Renters (Civilians)'
        ],
        'form'  => [
            'confirm_password'  => 'Confirm Password',
            'email'             => 'Email',
            'general'           => 'General Info.',
            'image'             => 'Profile Image',
            'info'              => 'Info.',
            'mobile'            => 'Mobile',
            'name'              => 'Name',
            'password'          => 'Password',
            "id_number"         => "Id number",
            "id_number_desc"         => "Id number must be 12 digits, no more no less",
            "birth_date"        => "Birth Date",
            "level_id"          => "Level",
            "parent_id"         => "Parent",
            "id_image"          => "Id Image",
            "nationality_id"    => "Nationality",
            "admin_approved"    => "Admin approved",
            "is_verified"       => "is verified",
            "send_welcome_email" => 'Welcome E-mail',
            'notes' => 'Notes',
            'status' => 'Status',
            'city_id' => 'City',
            'state_id' => 'State',

        ],
        'create'    => [

            'title' => 'Create Office',
            'title_civil' => 'Create Client',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'email'         => 'Email',
            "level_id"          => "Level",
            'image'         => 'Image',
            'mobile'        => 'Mobile',
            "parents"       => "Parent",
            "admin_approved"=> "Admin approve status",
            "id_number"     => "Id Number",
            'name'          => 'Name',
            'options'       => 'Options',
            'nationality'       => 'Nationality',
            'city'       => 'City',
            'state'       => 'State',
        ],
        'index'     => [
            'title' => 'Renters (Civilians)',
        ],
        'update'    => [

            'title' => 'Update Civlian',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'Please enter the email of user',
                'unique'    => 'This email is taken before',
            ],
            'mobile'    => [
                'digits_between'    => 'Please add mobile number only 8 digits',
                'numeric'           => 'Please enter the mobile only numbers',
                'required'          => 'Please enter the mobile of user',
                'unique'            => 'This mobile is taken before',
            ],
            'name'      => [
                'required'  => 'Please enter the name of user',
            ],
            'note'      => [
                'required'  => 'Please enter the note regrading the client behavior',
            ],
            'status'      => [
                'required'  => 'Please select the client behavior\'s status',
            ],
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'Please enter the password of user',
                'same'      => 'The Password confirmation not matching',
            ],
            'id_number'     => [
                'required'  => 'Please enter the civil ID number of user',
                'unique'    => 'This civil ID number is taken before',
                'numeric'    => 'Civil ID number must be numbers only',
                'digits'    => 'Civil ID number must be 12 digits, no more no less',
            ],
        ],
    ]
];
