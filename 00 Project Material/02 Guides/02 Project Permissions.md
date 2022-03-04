<h1 align="center">Project permissions</h1>

## Gym Manager

```php

    $resourcesActions = [
    
        /*_____ * _____ Admin only Resources _____ * _____ */
        // we have to restrict deleting the city if it has gyms inside it
        // you can't delete the package if any manager bought it for user just create a new one
        'city_Managers' => [ // ahmed hafez
            'index', // only 
            'edit', // only his manager information can't edit his city from her
            'update',
            'destroy|delete' // restrict if it has related records
        ], 
        'cities' => [ // ahmed hafez
            'index',
            'create|add',
            'store',
            'edit',
            'update',
            'destroy|delete',
        ],                          
        'training_packages' => [ 
            'index',
            'create|add',
            'store',
            'edit', 
            'update', 
            'destroy|delete',
         /*_____ * _____ City Manager Resources _____ * _____ */

        // admin will see the whole gyms and gymManagers and in gyms tab he will see extra column called "city manager name"
        // cityManager will see only gyms and gymManagers in his city
        // we have to restrict deleting the gym if it has training sessions
        // editing gym will be only in name & cover_image
        // if the admin is creating gym he have to specify in which city and with which gymManager it will be created

        // if admin show extra "city manager name" column.
        'gym' => [ // ahmed hafez
            'index',
            'create|add',
            'store',
            'edit',
            'show',
            'update',
            'destroy|delete'
        ],
         // when creating a gym manager we will show a drop-down of gyms and choose which gym the gym manager belongs to.
         // city manager can ban and unban gym manager

        'gym manager' => [ // ahmed hafez
            'index',
            'create|add',
            'store',
            'edit',
            'update',
            'destroy|delete' 
        ],
        /*_____ * _____ Gym Manager Resources _____ * _____ */
        // when deleting or editing training session make sure there are no users attend that session 
        // when editing session we can edit date & time only if there's no user attended the session
        // when creating a new training session make sure it dosn't overlap with any other training session in that gym.

        // when creating a new training session the form will consists of name, day, start, finish time , coaches(multible select) this means many to many relation ship

        // don't forget to record this in training_sessiosn_coaches_table

        // make sure when you creating a training session as an admin or city manager you have to specify the gym and after specifying the gym you will reveal the coaches related to that gym

        // the same thing with training package we have to specify the gym if you are buying it as city manager or admin
        'training_sessions' => [  // ashraf
            'create|add',
            'store',
            'edit',
            'show', // show the coashes according to the session
            'update',
            'destroy|delete' 
        ],
        'coaches' => [ // ayman
            'create|add',
            'store',
            'edit',
            'update',
            'destroy|delete' 
        ],
        /*_____ * _____ Revenue _____ * _____ */

        // We need to show the total revenue as a card at the top of page, if iam logged in as gym manager, then will show the total revenue of my gym, and if i am logged in as a city manager it will show the total revenue of my city gyms.

        // this is not resource
        'revenueCard' => [
            'show total gym revenue card', // if gym manager
            'show total city revenue card', // if city manager
            'show total system revenue card', // if admin
        ],

        /*_____ * _____ Purchases _____ * _____ */

        // we need to show the purchases history in dataTables , we will need to show user email, name, package name, amount the user bought with (Not The Package Price But The Amount user Paid When He Bought The Package, Cause Admin Can Edit The Package Price) If the logged-in user is City Manager then we will need to show which gym this package is bought from, and if the logged in user is Admin then we will need to show which city this package is bought from

        // if city manager show extra gym column
        // if admin show extra city column
        'purchases' => [
            'create|add',
            'store',
        ],

        // if city manager show extra gym column
        // if admin show extra city column
        'attendance' => [
            'show'
        ],
        'users' => [
            'show'
        ],

    ];
    $permissions = [
        'gym_manger' => [
            'coaches, sessions, purchases, attendance, users.*',
            'revenueCard.showGymRevenue',
        ],
        'city_manager' => [
            'revenueCard.showCityRevenue',
            'gym_manager, gyms.*'
        ],
        'admin' => [
            'revenueCard.showSystemRevenue',
            '*.*',
        ],
    ]; 
    $revokedPermissions = [
        'gym_manager_revoke' => [
            '*.showGymData, showCityData',
        ],
        'city_manager_revoke' => [
            '*.showCityData',
        ],
    ];

    // creating the permissions
        use Spatie\Permission\Models\Permission;
        Permission::create(['name'=>'coaches, sessions, purchases, attendance, users.*']);
        Permission::create(['name'=>'gym_manager, gyms.*']);
        Permission::create(['name'=>'revenueCard.showGymRevenue']);
        Permission::create(['name'=>'revenueCard.showCityRevenue']);
        Permission::create(['name'=>'revenueCard.showSystemRevenue']);
        Permission::create(['name'=>'*.showGymData, showCityData']);
        Permission::create(['name'=>'*.showCityData']);
        Permission::create(['name'=> '*.*']);

```

```php


/*
    General Rules 
    // create methods in Manager model to demote and promote
        1- Managers Tab 
            1- General Manager
                1- Cann't be deleted if this manager related to any other records
            2- City Manager
                1- inex
            3- Gym Manager

*/

````
