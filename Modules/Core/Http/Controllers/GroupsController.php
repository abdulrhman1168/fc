<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Core\Group;
use Modules\Auth\Entities\Core\User;
use Yajra\Datatables\Datatables;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\UserBaseController;

class GroupsController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
      $groupId = isset($request->groupId) ? $request->groupId : 0;

      if ($request->wantsJson() || $request->ajax()) {
          $groups = Group::select('id','name')->where('parent_id', $groupId);

          return Datatables::of($groups)
             ->addColumn('action', 'core::groups.index-actions')->toJson();
      } else {
          return view('core::groups.index');
      }
    }

    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function create()
    {
        $group = new Group();
        
        $groups = Group::where('parent_id', 0)->pluck('name', 'id');
        $groups->prepend('', 0);

        return view('core::groups.create')
              ->with('group', $group)
              ->with('groups', $groups);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $request->validate([
          'parent_id' => 'nullable',
          'name' => 'required|unique:es_core_groups',
          'name_en' => 'required|unique:es_core_groups',
          'key' => 'required|unique:es_core_groups'
      ]);

      if((int)$request->parent_id <= 0) {
        $request->merge([
          'parent_id' => 0,
        ]);
      }

      $group = Group::create($request->all());

      return redirect()->route('groups.show', ['id' => $group->id ]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        return view('core::groups.show',array('group'=> Group::find($id)));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $group = Group::find($id);

        $groups = Group::where('parent_id', 0)->pluck('name', 'id');
        $groups->prepend('', 0);

        return view('core::groups.edit', array('group' => $group, 'groups' => $groups));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'parent_id' => 'nullable',
            'name' => 'required|unique:es_core_groups,name,'.$id,
            'name_en' => 'required|unique:es_core_groups,name_en,'.$id,
            'key' => 'required|unique:es_core_groups,key,'.$id,
        ]);


        if((int)$request->parent_id <= 0) {
          $request->merge([
            'parent_id' => 0,
          ]);
        }
        
        $group = Group::find($id);

        $group->update($request->all());

        return view('core::groups.show',array('group'=> Group::find($id)));
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
      $group = Group::find($id);
      $group->permissions()->delete();
      $group->users()->detach();
      $group->delete();

      return redirect()->route('groups.index');
    }

  /**
   * @api  Attach group to user
   * @apiName attachUserGroup
   * @apiGroup Core
   *
   * @apiParam {String} group_id group id we want to attach
   *
   * @apiSuccess (Success 200) {JsonObject} groups group information
   * @apiError (Unprocessable Entity 422) ValidationError
   */
   public function attachUser(Request $request)
   {
     $groupId = $request->input('group_id');

     $validations = [
         'user_id' => [
                        'required',
                         Rule::unique('es_core_users_groups')->where(function ($query) use ($groupId) {
                              return $query->where('es_core_group_id', $groupId);
                         })
           ],
         'group_id' => 'required|numeric|exists:es_core_groups,id',
     ];

     $request->validate($validations);

      $user = User::findOrFail($request->input('user_id'));

     $user->groups()->attach($request->input('group_id'));

     return $user;
   }

 /**
  * @api  Detach group from user
  * @apiName attachUserGroup
  * @apiGroup Core
  *
  * @apiParam {String} group_id group id we want to attach
  *
  * @apiSuccess (Success 200) {JsonObject} groups group information
  * @apiError (Unprocessable Entity 422) ValidationError
  */
  public function detachUser(Request $request, $id, $userId)
  {
    $user = User::findOrFail($userId);
    $groupId = $id;

    $userGroupIds = join($user->groups()->pluck('es_core_groups.id')->toArray(), ",");

    $validator = Validator::make(['group_id' => $groupId], [
         'group_id' => 'required|in:'. $userGroupIds,
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $user->groups()->detach($groupId);

    return response(null, 204);
  }

  public function users(Request $request, $id) {
    $group = Group::find($id);

    return $group->users;
  }
}
