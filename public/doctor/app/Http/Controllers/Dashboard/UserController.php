<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\RequiredIf;

class UserController extends BackEndController
{
    public function __construct(User $model)
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
       $rows = $this->model->when($request->search,function($query) use ($request){
           $query->where('name','like','%' .$request->search . '%')
                 ->orWhere('email', 'like','%' . $request->search . '%')
                 ->orWhere('phone', 'like','%' . $request->search . '%')
                 ->orWhere('address', 'like','%' . $request->search . '%');

       });
       $rows = $this->filter($rows,$request);
       $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of ind
    public function store(Request $request)
    {

        $request->validate([
            'name'                  => 'required|min:5|string',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'nullable',
            'password'              => 'required|min:5|string|confirmed',
            'password_confirmation' => 'required|min:5|string|same:password',
            'address'               => 'nullable|min:5|string',
            'role_id'               =>'required',
            'image'                 =>'required|mimes:jpg,jpeg,png,svg',
            'hotel_id'         => new RequiredIf(auth()->user()->hotel_id === null),

        ]);

        $request_data = $request->except(['_token', 'password','hotel_id', 'password_confirmation', 'role_id','image']);
        $request_data['password'] = bcrypt($request->password);
        if($request->has('image')){
            $request_data['image'] = $this->uploadImage($request->image, 'users_images');
        }
        if(auth()->user()->hotel_id == null)
        {
            $request_data['hotel_id']=$request->hotel_id;
        }else{
            $request_data['hotel_id']=auth()->user()->hotel_id;
        }
        $request_data['type']=1;
        $newuser = $this->model->create($request_data);
        if($request->role_id){
            $newuser->attachRoles($request->role_id);
        }
        session()->flash('success', __('site.add_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }


    public function update(Request $request, $id)
    {
        $user = $this->model->find($id);

        $request->validate([
            'name'                    => 'required|min:5|string',
            'email'                   => 'required|email|unique:users,email,'.$user->id.'',
            'phone'                   => 'nullable',
            'password_confirmation'   => 'same:password',
            'address'                 => 'nullable|min:5|string',
            'role_id'                 =>'required',
            'image'                   =>'nullable|mimes:jpg,jpeg,png,svg',
            'hotel_id'         => new RequiredIf(auth()->user()->hotel_id === null),
        ]);

        $request_data = $request->except(['_token', 'password','hotel_id', 'password_confirmation', 'role_id']);
        if($request->has('password') && $request->password !=null){

            $request_data['password'] = bcrypt($request->password);
        }
        if($request->image != null){
            if($user->image != null){
                if(file_exists(base_path('public/uploads/users_images/') . $user->image)){
                    unlink(base_path('public/uploads/users_images/') . $user->image);
                }
            }
            $request_data['image'] = $this->uploadImage($request->image, 'users_images');
        }

        if($request->role_id){
            $user->syncRoles($request->role_id);
        }

        if(auth()->user()->hotel_id == null)
        {
            $request_data['hotel_id']=$request->hotel_id;
        }else{
            $request_data['hotel_id']=auth()->user()->hotel_id;
        }
        $user->update($request_data);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
    public function destroy($id, Request $request)
    {
        $user = $this->model->findOrFail($id);
        if($user->image != null)
        {
            if(file_exists(base_path('public/uploads/users_images/') . $user->image)){
                unlink(base_path('public/uploads/users_images/') . $user->image);
            }
        }
        $user->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
}
