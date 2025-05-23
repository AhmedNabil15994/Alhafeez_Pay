<?php

//view()->composer(['area::dashboard.cities.*'], \Modules\Area\ViewComposers\Dashboard\CountryComposer::class);
//
//view()->composer([
//    'area::dashboard.states.*','company::dashboard.companies.*'
//], \Modules\Area\ViewComposers\Dashboard\CityComposer::class);
//
view()->composer(
    [
        'user::dashboard.users.create', 'user::dashboard.users.edit',
        'user::dashboard.parents.create', 'user::dashboard.parents.edit' ,
        'user::dashboard.teachers.create', 'user::dashboard.teachers.edit' ,
    ],
    \Modules\Area\ViewComposers\Dashboard\CountryComposer::class
);
