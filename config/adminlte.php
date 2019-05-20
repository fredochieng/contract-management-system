<?php

$logo_url = "/images/branding/logo.png";
return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Wananchi Legal',

    'title_prefix' => '',

    'title_postfix' => '',


    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' =>' Wananchi Legal',

    'logo_mini' => '<img src="' . $logo_url . '">',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'green',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'dashboard',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'MAIN NAVIGATION',

        [
            'text' => 'Dashboard',
            'url'  => '/dashboard',
            'icon'        => 'dashboard',
            // 'can'  => '',
        ], [
            'text'    => 'User Management',
            'icon'    => 'users',
            'submenu' => [
                [
                    'text' => 'Users',
                    'icon'        => 'angle-double-right',
                    'url'  => '/system-users/users',
                ], [
                    'text' => 'Roles',
                    'icon'        => 'angle-double-right',
                    'url'  => '#',
                ],
            ],
            'can'  => 'users.manage',
        ],

        [
            'text'    => 'Contracts',
            'icon'    => 'briefcase',
            'submenu' => [
                [
                    'text' => 'Create New Contract',
                    'icon'        => 'angle-double-right',
                    'url'  => 'contract/create',
                ],[
                    'text' => 'Pending Contracts',
                    'icon'        => 'angle-double-right',
                    'url'  => 'pending-contracts',
                ],

                 [
                    'text' => 'Reviewed Contracts',
                    'icon'        => 'angle-double-right',
                    'url'  => 'reviewed-contracts',
                ],
                // [
                //     'text' => 'Ammended Contracts',
                //     'icon'        => 'angle-double-right',
                //     'url'  => 'amended-contracts',
                // ],
                [
                    'text' => 'Approved Contracts',
                    'icon'        => 'angle-double-right',
                    'url'  => 'approved-contracts',
                ],
                // [
                //     'text' => 'Terminated Contracts',
                //     'icon'        => 'angle-double-right',
                //     'url'  => 'terminated-contracts',
                // ],
                [
                    'text' => 'Closed Contracts',
                    'icon'        => 'angle-double-right',
                    'url'  => 'closed-contracts',
                ],
            ],
        ], [
            'text' => 'Contract Parties',
            'icon'    => 'certificate',
            'url'  => 'party',
            'can'  => 'parties.manage',
        ], [
            'text'    => 'Business Documents',
            'icon'    => 'book',
            'submenu' => [
                [
                    'text' => 'Licences',
                    'icon'        => 'angle-double-right',
                    'url'  => '#',
                ], [
                    'text' => 'Type Approvals',
                    'icon'        => 'angle-double-right',
                    'url'  => '#',
                ],
            ],
            'can'  => 'documents.manage',

        ], [
            'text' => 'Reports',
            'url'  => 'reports',
            'icon' => 'bar-chart',
            'can'  => 'reports.manage',
        ],


        'SYSTEM SETTINGS',
        [
            'text' => 'System',
            'url'  => 'system/settings',
            'icon' => 'cogs',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        \App\Lib\SpatieFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
        'pace'       => true,
    ],

    'pace' => [
        'color' => 'white',
        'type' => 'minimal',
    ],

];
