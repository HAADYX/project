<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Role;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;

class RoleController extends BackEndController
{

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //get all data of Model
      if(auth()->user()->hotel_id != null)
      {
            $hotelAdmin=User::where('hotel_id',auth()->user()->hotel_id)->first();
            $ro=RoleUser::where('user_id',$hotelAdmin->id)->first();
            $rows = $this->model->where('id','!=',$ro->role_id)->when($request->search,function($query) use ($request){
                $query->where('name','like','%' .$request->search . '%')
                ->orWhere('description', 'like','%' . $request->search . '%');
            });
      }else{
            $rows = $this->model->when($request->search,function($query) use ($request){
                $query->where('name','like','%' .$request->search . '%')
                ->orWhere('description', 'like','%' . $request->search . '%');
            });
      }

    $rows = $this->filter($rows,$request);
     $module_name_plural = $this->getClassNameFromModel();
     $module_name_singular = $this->getSingularModelName();
     // return $module_name_plural;
     return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|unique:roles,name',
            'description'    => 'required|string|min:1|max:2000',
        ]);
        $newRole = new Role();
        if($request->permissions == null)
        {
            session()->flash('error',__('site.add_permission_please'));
            return redirect()->route('dashboard.roles.create');
        }

        $newRole->name         =  $request->name;

        if(auth()->user()->hotel_id == null)
        {
            $newRole->hotel_id=$request->hotel_id;
        }else{
            $newRole->hotel_id=auth()->user()->hotel_id;
        }
        $newRole->display_name = ucfirst($request->name);
        $newRole->description  =  $request->description;
        $newRole->save();

        $newRole->attachPermissions($request->permissions);

        session()->flash('success', __('site.add_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }


    public function update(Request $request, $id)
    {
        $updateRole = $this->model->findOrFail($id);
        if($request->permissions == null)
        {
            session()->flash('error',__('site.add_permission_please'));
            $module_name_plural = $this->getClassNameFromModel();
            $module_name_singular = $this->getSingularModelName();
            $row=$updateRole;
            return view('dashboard.' . $this->getClassNameFromModel() . '.edit', compact('row', 'module_name_singular', 'module_name_plural'));
        }

        $updateRole->name         =  $request->name;
        $updateRole->display_name = ucfirst($request->name);
        $updateRole->description  =  $request->description;
        if(auth()->user()->hotel_id == null)
        {
            $updateRole->hotel_id=$request->hotel_id;
        }else{
            $updateRole->hotel_id=auth()->user()->hotel_id;
        }
        $updateRole->save();

        $updateRole->syncPermissions($request->permissions);
        return $updateRole;
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
    public function destroy($id,Request $request)
    {
        $role=Role::findOrFail($id);
        $role->delete();
        session()->flash('success',__('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');


    }
}
