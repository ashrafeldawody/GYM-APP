```php
1- Rules
	=> creation:
		$role = Rule::create(['name' => 'writer']);
	=> assign permission to role:
		$role->givePermissionTo('edit articles');
		$role->givePermissionTo($permission);
	=> sync Multiple permissions to role:
		$role->syncPermissions($permissions);
	=> remove permission from role:
		$role->revokePermissionTo($permission);

2- Permissions
	=> creation:
		$permission = permission::create(['name' => 'edit article']);
	=> Assign The permission to role:
		$permission->assignRole('writer');
		$permission->assignRole($role);
	=> sync permission to multible roles:
		$permission->syncRoles($roles);
	=> remove permission from role:
		$permission->removeRole($role);

3- Fetching roles and permissions
	=> $permissionNames = $user->getPermissionNames();
	=> $permissions = $user->permissions;	// this gives you a collection of permission objects
	=> $permissions = $user->getDirectPermissions(); // this will return a collection of the user direct permissions
	=> $permissions = $user->getPermissionsViaRoles(); // This will return a collection of the user permisions via roles
	=> $permissions = $user->getAllPermissions(); // This will return a collection of the whole user permissions
	=> $roles = $user-> getRoleNames();	// This will return a collection of the user roles.

4- Queries on Eloquent
	=> users with certian role:
 		$users = User::role('writer')->get(); // this will return the users that have a writer role.
	=> user with certain permissions:
		$users = User:permission('edit articles')->get(); // this will return the users that have an edit articles permission.
	=> all users with all roles
		$all_users_with_all_their_roles = User::with('roles')->get();
	=> all users with all direct permissions
		$all_users_with_all_direct_permissions = User::with('permissions')->get();
	=> all roles in database
		$all_roles_in_database = Role::all()->pluck('name');
	=> users without any roles
		$users_without_any_roles = User::dosntHave('roles')->get();
	=> all roles except a and b
		$all_roles_except_a_and_b = Role::whereNotIn('name', ['role A', ['role B']])->get();
5- Usage
	=> You can also give multiple permission at once
		$user->givePermissionTo('edit articles', 'delete articles');
	=> you can give the permissions as an array
		$user->givePermissionTo(['edit articles', 'delete articles']);
	=> you can check if the user has the prmissions:
		$user->hasPermissionTo('1');
		$user->hasPermissionTo(Permission::find(1)->id);
		$user->hasPermissionTo($somePermission->id);
		$user->hasAnyPermission(['edit articles', 'publish articles', 'unpublish articles']);
		$user->hasAllPermissions(['edit articles', 'publish articles', 'unpublish articles']);
		$user->can('edit articles');

6- wild card permissions:
	parts are 3 and separtated by dot . and subparts separtated by ,
	{resource}.{action}.{target}
	you can aslo use sub parts

	{resource1, resource2, resource3}.{action1, action2, action3}.{element1Id, element2Id}
	you can use * that will represent All

	// user can only do the actions create, update and view on both resources posts and users
	$user->givePermissionTo('posts,users.create,update,view');

	// user can do the actions create, update, view on any available resource
	$user->givePermissionTo('*.create,update,view');

	// user can do any action on posts with ids 1, 4 and 6
	$user->givePermissionTo('posts.*.1,4,6');

	Permission::create(['name'=>'posts.*']);
	$user->givePermissionTo('posts.*');
	// is the same as
	Permission::create(['name'=>'posts']);
	$user->givePermissionTo('posts');

	// will be true
	$user->can('posts.create');
	$user->can('posts.edit');
	$user->can('posts.delete');
7- USING PERMISSIONS VIA ROLES
	=>A role can be assigned to any user:
		$user->assignRole('writer');
		// You can also assign multiple roles at once
		$user->assignRole('writer', 'admin');
		// or as an array
		$user->assignRole(['writer', 'admin']);
	=>Roles can also be synced:
		// All current roles will be removed from the user and replaced by the array given
		$user->syncRoles(['writer', 'admin']);
	=>You can determine if a user has a certain role:
		$user->hasRole('writer');
		// or at least one role from an array of roles:
		$user->hasRole(['editor', 'moderator']);
	=> You can also determine if a user has any of a given list of roles:
		$user->hasAnyRole(['writer', 'reader']);
		// or
		$user->hasAnyRole('writer', 'reader');

	=> You can also determine if a user has all of a given list of roles:
		$user->hasAllRoles(Role::all());
	=> You can also determine if a user has exactly all of a given list of roles:
		$user->hasExactRoles(Role::all());
	=> A permission can be given to a role:
		$role->givePermissionTo('edit articles');
	=> You can determine if a role has a certain permission:
		$role->hasPermissionTo('edit articles');
	=> A permission can be revoked from a role:
		$role->revokePermissionTo('edit articles');
	=> The permissions property on any given role returns a collection with all the related permission objects. This collection can respond to usual Eloquent Collection operations, such as count, sort, etc.
		=> // get collection
		=> $role->permissions;

		=> // return only the permission names:
		=> $role->permissions->pluck('name');

		=> // count the number of permissions assigned to a role
		=> count($role->permissions);
		=> // or
		=> $role->permissions->count();

=> note: auth()->user() // this will return the authonticated user
8- Blade directives
	=> permissions
		@can('edit articles')
			//
		@endcan

		or

		@if(auth()->user()->can('edit articles') && $some_other_condition)
			//
		@endif

		You can use @can, @cannot, @canany, and @guest to test for permission-related access.

	=> Roles
			As discussed in the Best Practices section of the docs, it is strongly recommended to always use permission directives, instead of role directives.
		// Use this for test only
			@role('writer')
				I am a writer!
			@else
				I am not a writer...
			@endrole
		is the same as
			@hasrole('writer')
				I am a writer!
			@else
				I am not a writer...
			@endhasrole
		Check for any role in a list:
			@hasanyrole($collectionOfRoles)
				I have one or more of these roles!
			@else
				I have none of these roles...
			@endhasanyrole
			// or
			@hasanyrole('writer|admin')
				I am either a writer or an admin or both!
			@else
				I have none of these roles...
			@endhasanyrole
		Check for all roles:
			@hasallroles($collectionOfRoles)
				I have all of these roles!
			@else
				I do not have all of these roles...
			@endhasallroles
			// or
			@hasallroles('writer|admin')
				I am both a writer and an admin!
			@else
				I do not have all of these roles...
			@endhasallroles
		Alternatively, @unlessrole gives the reverse for checking a singular role, like this:
			@unlessrole('does not have this role')
				I do not have the role
			@else
				I do have the role
			@endunlessrole
		You can also determine if a user has exactly all of a given list of roles:
			@hasexactroles('writer|admin')
				I am both a writer and an admin and nothing else!
			@else
				I do not have all of these roles or have more other roles...
			@endhasexactroles
9- Defining super-admin
	=> in AuthServeiceProvider.php

    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
```
10- using artisan commands
	=> You can create a role or permission from the console with artisan commands.
		php artisan permission:create-role writer

		php artisan permission:create-permission "edit articles"

	=> When creating permissions/roles for specific guards you can specify the guard names as a second argument:
		php artisan permission:create-role writer web

		php artisan permission:create-permission "edit articles" web

	=>  When creating roles you can also create and link permissions at the same time:
		php artisan permission:create-role writer web "create articles|edit articles"

	=> displaying roles and permissions:
		=> There is also a show command to show a table of roles and permissions per guard:
			php artisan permission:show

//11- Using a middleware
	=> Default Middleware
		// you can use route group like this
		Route::group(['middleware' => ['can:publish articles']], function () {
			//
		});
//	=> Package Middleware
		// we will use this method in our project to specify the routes for each role
		Route::group(['middleware' => ['role:super-admin']], function () {
			//
		});

		Route::group(['middleware' => ['permission:publish articles']], function () {
			//
		});

		Route::group(['middleware' => ['role:super-admin','permission:publish articles']], function () {
			//
		});

		Route::group(['middleware' => ['role_or_permission:super-admin|edit articles']], function () {
			//
		});

		Route::group(['middleware' => ['role_or_permission:publish articles']], function () {
			//
		});

//	=> Alternatively, you can separate multiple roles or permission with a | (pipe) character:
		Route::group(['middleware' => ['role:super-admin|writer']], function () {
   			 //
		});

		Route::group(['middleware' => ['permission:publish articles|edit articles']], function () {
			//
		});

		Route::group(['middleware' => ['role_or_permission:super-admin|edit articles']], function () {
			//
		});
//	=> You can protect your controllers similarly, by setting desired middleware in the constructor:
		public function __construct()
		{
			$this->middleware(['role:super-admin','permission:publish articles|edit articles']);
		}
		public function __construct()
		{
			$this->middleware(['role_or_permission:super-admin|edit articles']);
		}
```
