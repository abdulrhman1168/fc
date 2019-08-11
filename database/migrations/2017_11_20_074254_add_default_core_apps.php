<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Core\Entities\Core\App;
use Carbon\Carbon;

class AddDefaultCoreApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $topParentId = App::create(
            ['resource_name' => 'Modules', 'name' => 'التطبيقات', 'name_en' => 'Apps', 'is_main_root' => 1,
                'icon' => 'icon icon-folder', 'sort' => 1, 'parent_id' => 0, 'frontend_path' => 'index',
                'displayed_in_menu' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()])->id;

      $coreAppsModuleId = App::create(
                   ['resource_name' => 'Modules\Core\Http\Controllers', 'name' => 'المصادر الرئيسية', 'name_en' => 'Core Apps',
                   'icon' => 'icon icon-folder','sort' => 1, 'parent_id' => $topParentId, 'frontend_path' => 'core', 'is_main_root' => 0,
                    'displayed_in_menu' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()])->id;

      $coreAppsId = App::create(
                  ['resource_name' => 'Modules\Core\Http\Controllers\AppsController', 'name' => 'إدارة التطبيقات', 'name_en' => 'Manage Apps',
                  'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $coreAppsModuleId, 'frontend_path' => 'core/apps', 'is_main_root' => 0,
                   'displayed_in_menu' => 1 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()])->id;

                //    $graduates = App::create(
                //     ['resource_name' => 'Modules\Core\Http\Controllers\AppsController', 'name' => 'إدارة التطبيقات', 'name_en' => 'Manage Apps',
                //     'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $coreAppsModuleId, 'frontend_path' => 'core/apps', 'is_main_root' => 0,
                //      'displayed_in_menu' => 1 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()])->id;

       App::create(
               ['resource_name' => 'Modules\Core\Http\Controllers\AppsController@index', 'name' => 'قراءة الكل', 'name_en' => 'Read List',
               'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $coreAppsId, 'frontend_path' => 'core/apps', 'is_main_root' => 0,
                'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

       App::create(
                ['resource_name' => 'Modules\Core\Http\Controllers\AppsController@show', 'name' => 'قراءة تفاصيل', 'name_en' => 'Read All',
                'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $coreAppsId, 'frontend_path' => 'core/apps', 'is_main_root' => 0,
                 'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

       App::create(
                ['resource_name' => 'Modules\Core\Http\Controllers\AppsController@store', 'name' => 'إضافة', 'name_en' => 'Add',
                'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $coreAppsId, 'frontend_path' => 'core/apps', 'is_main_root' => 0,
                 'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

       App::create(
                ['resource_name' => 'Modules\Core\Http\Controllers\AppsController@update', 'name' => 'تعديل', 'name_en' => 'Edit',
                'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $coreAppsId, 'frontend_path' => 'core/apps', 'is_main_root' => 0,
                 'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

       App::create(
                ['resource_name' => 'Modules\Core\Http\Controllers\AppsController@destroy', 'name' => 'حذف', 'name_en' => 'Delete',
                'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $coreAppsId, 'frontend_path' => 'core/apps', 'is_main_root' => 0,
                 'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);


       $usersId = App::create(
                   ['resource_name' => 'Modules\Core\Http\Controllers\UsersController', 'name' => 'المستخدمين', 'name_en' => 'Manage Users',
                   'icon' => 'icon icon-folder','sort' => 3, 'parent_id' => $coreAppsModuleId, 'frontend_path' => 'core/users', 'is_main_root' => 0,
                    'displayed_in_menu' => 1 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()])->id;


      App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\UsersController@index', 'name' => 'قراءة الكل', 'name_en' => 'Read List',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $usersId, 'frontend_path' => 'core/users', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

      App::create(
               ['resource_name' => 'Modules\Core\Http\Controllers\UsersController@search', 'name' => 'بحث', 'name_en' => 'Search',
               'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $usersId, 'frontend_path' => 'core/apps', 'is_main_root' => 0,
                'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

      $groupsId = App::create(
                  ['resource_name' => 'Modules\Core\Http\Controllers\GroupsController', 'name' => 'المجموعات', 'name_en' => 'Manage Groups',
                  'icon' => 'icon icon-folder','sort' => 3, 'parent_id' => $coreAppsModuleId, 'frontend_path' => 'core/groups', 'is_main_root' => 0,
                   'displayed_in_menu' => 1 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()])->id;


     App::create(
             ['resource_name' => 'Modules\Core\Http\Controllers\GroupsController@index', 'name' => 'قراءة الكل', 'name_en' => 'Read List',
             'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $groupsId, 'frontend_path' => 'core/groups', 'is_main_root' => 0,
              'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

     App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\GroupsController@show', 'name' => 'اظهار بيانات', 'name_en' => 'Show details',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $groupsId, 'frontend_path' => 'core/groups', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

     App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\GroupsController@create', 'name' => 'صفحة انشاء جديد', 'name_en' => 'Add New Page',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $groupsId, 'frontend_path' => 'core/groups', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

     App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\GroupsController@store', 'name' => 'انشاء جديد', 'name_en' => 'Store Action',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $groupsId, 'frontend_path' => 'core/groups', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

     App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\GroupsController@edit', 'name' => 'صفحة التعديل', 'name_en' => 'ِEdit Page',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $groupsId, 'frontend_path' => 'core/groups', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

     App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\GroupsController@update', 'name' => 'تحديث', 'name_en' => 'Update Action',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $groupsId, 'frontend_path' => 'core/groups', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

     App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\GroupsController@destroy', 'name' => 'حذف', 'name_en' => 'Delete',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $groupsId, 'frontend_path' => 'core/groups', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

     App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\GroupsController@attachUser', 'name' => 'اضافة مستخدم', 'name_en' => 'Add User',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $groupsId, 'frontend_path' => 'core/groups', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

     App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\GroupsController@detachUser', 'name' => 'حذف مستخدم من المجموعة', 'name_en' => 'Delete User',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $groupsId, 'frontend_path' => 'core/groups', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);


     $permissionsId = App::create(
                 ['resource_name' => 'Modules\Core\Http\Controllers\PermissionsController', 'name' => 'الصلاحيات', 'name_en' => 'Manage Permissions',
                 'icon' => 'icon icon-folder','sort' => 3, 'parent_id' => $coreAppsModuleId, 'frontend_path' => 'core/permissions', 'is_main_root' => 0,
                  'displayed_in_menu' => 0 ,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()])->id;


     App::create(
            ['resource_name' => 'Modules\Core\Http\Controllers\PermissionsController@index', 'name' => 'قراءة الكل', 'name_en' => 'Read List',
            'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $permissionsId, 'frontend_path' => 'core/permissions', 'is_main_root' => 0,
             'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

     App::create(
             ['resource_name' => 'Modules\Core\Http\Controllers\PermissionsController@store', 'name' => 'اضافة', 'name_en' => 'Add',
             'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $permissionsId, 'frontend_path' => 'core/permissions', 'is_main_root' => 0,
              'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

    App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\PermissionsController@update', 'name' => 'تحديث', 'name_en' => 'Update',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $permissionsId, 'frontend_path' => 'core/permissions', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

     App::create(
               ['resource_name' => 'Modules\Core\Http\Controllers\PermissionsController@destroy', 'name' => 'حذف', 'name_en' => 'Delete',
               'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $permissionsId, 'frontend_path' => 'core/permissions', 'is_main_root' => 0,
                'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

    App::create(
              ['resource_name' => 'Modules\Core\Http\Controllers\AccessLevelsController@index', 'name' => 'مستويات الصلاحية', 'name_en' => 'Access Level',
              'icon' => 'icon icon-folder','sort' => 2, 'parent_id' => $permissionsId, 'frontend_path' => 'core/permissions', 'is_main_root' => 0,
               'displayed_in_menu' => 0,'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //App::truncate();
    }
}
