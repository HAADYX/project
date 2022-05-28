<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Hotel;
use App\Role;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HotelController extends BackEndController
{
    public function __construct(Hotel $model)
    {
        parent::__construct($model);
    }
    public function index(Request $request)
    {

        //get all data of Model
        $rows = $this->model->when($request->search,function($q) use ($request){
            $q->whereTranslationLike('name','%' .$request->search. '%')
                ->orWhereTranslationLike('description','%' .$request->search. '%');
        })->paginate(5);
        $module_name_plural   = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;

        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    }
    public function create(Request $request)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $categories=Category::where('status','active')->get();
        $append = $this->append();
        return view('dashboard.' . $this->getClassNameFromModel() . '.create', compact('categories','module_name_singular', 'module_name_plural'))->with($append);
    } //end of create

    public function store(Request $request)
    {
        $request->validate([
            'ar.name'          => 'required|min:2|max:60',
            'en.name'          => 'required|min:2|max:60',
            'ar.description'   => 'required',
            'en.description'   => 'required',
            'status'           => ['required',Rule::in('active','pending')],
            'category_id'      => 'nullable|exists:categories,id',

            //user data
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'nullable|unique:users,phone',
            'password'              => 'required|min:5|string|confirmed',
            'password_confirmation' => 'required|min:5|string|same:password',
            'address'               => 'nullable|min:5|string',
            'image'                 =>'nullable|mimes:jpg,jpeg,png,svg',
        ]);
        $image=null;
       
        if($request->hasFile('image')){
            $image = $this->uploadImage($request->image, 'users_images');
        }
        $hotel=Hotel::create([
            'ar'            =>['name'=>$request->ar['name'],'description'=>$request->ar['description']],
            'en'            =>['name'=>$request->en['name'],'description'=>$request->en['description']],
            'status'        =>$request->status,
            'category_id'        =>$request->category_id,

        ]);
       $user=User::create([
            'name'      =>$hotel->name,
            'email'     =>$request->email,
            'phone'     =>$request->phone,
            'address'   =>$request->address,
            'password'  =>bcrypt($request->password),
            'type'      =>1,
            'hotel_id'  =>$hotel->id,
            'image'     =>$image,
        ]);
        $newRole = new Role();
        $newRole->name          = $hotel->name.'-'.$hotel->code;
        $newRole->hotel_id      = $hotel->id;
        $newRole->display_name  = ucfirst($hotel->name.'-'.$hotel->code);
        $newRole->description   = $hotel->name;
        $newRole->save();
        $permissions=[
            "create-users",
            "read-users",
            "update-users",
            "delete-users",
            "create-roles",
            "read-roles",
            "update-roles",
            "delete-roles",
            "create-categories",
            "read-categories",
            "update-categories",
            "delete-categories",
            "create-books",
            "read-books",
            "update-books",
            "delete-books",
            ];
        $newRole->attachPermissions($permissions);
        if($newRole->id != null){
            $user->attachRoles([$newRole->id]);
        }
        session()->flash('success', __('site.add_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
    public function edit($id)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $row = $this->model->findOrFail($id);
        $user=User::where('hotel_id',$row->id)->first();
        $categories=Category::where('status','active')->get();

        return view('dashboard.' . $this->getClassNameFromModel() . '.edit', compact('user','categories','row', 'module_name_singular', 'module_name_plural'))->with($append);
    } //end of edit
    public function update(Request $request, $id)
    {
        $hotel = $this->model->findOrFail($id);
        $user=User::where('hotel_id',$id)->first();
        $val=Validator::make($request->all(),[
            'ar.name'          => ['required', 'min:2'],
            'en.name'          => ['required', 'min:2'],
            'ar.description'   => ['required', 'min:2'],
            'en.description'   => ['required', 'min:2'],
            'category_id'      => 'nullable|exists:categories,id',

            'status'           => ['required',Rule::in('active','pending')],

            //users
            'email'                   => 'required|email|unique:users,email,'.$user->id.'',
            'phone'                   => 'nullable|unique:users,phone,'.$user->id,
            'password_confirmation'   => 'same:password',
            'address'                 => 'nullable|min:5|string',
            'image'                   =>'nullable|mimes:jpg,jpeg,png,svg',
        ]);
        if($request->image != null){
            if ($user->image != null);
                {

                    Storage::disk('public_uploads')->delete('/users_images/' . $user->image);
                }

            $user->image=$this->uploadImage($request->image,'users_images');
        } //end of if
        if($request->password !=  null)
        {
            $user->password=bcrypt($request->password);
        }
        $hotel->save();
        $user->save();
        $hotel->update([
            'ar'            =>['name'=>$request->ar['name'],'description'=>$request->ar['description']],
            'en'            =>['name'=>$request->en['name'],'description'=>$request->en['description']],
            'status'        =>$request->status,
            'category_id'        =>$request->category_id,

        ]);
        $user->update([
            'name'      =>$hotel->name,
            'email'     =>$request->email,
            'phone'     =>$request->phone,
            'address'   =>$request->address,
        ]);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
    public function destroy($id, Request $request)
    {
        $hotel = $this->model->findOrFail($id);
        if($hotel->books()->count()>0)
        {
            session()->flash('error', __('site.To Delete The Doctir Delete All Appointement'));
            return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
        }
        $user=User::where('hotel_id',$hotel->id)->first();
       
        if(!empty($user)){
            if ($user->image != null);
            {
                Storage::disk('public_uploads')->delete('/users_images/' . $user->image);
            }

            if($user->hasRole($hotel->name.'-'.$hotel->code)){
                $user->detachRole($hotel->name.'-'.$hotel->code);
            }
            $user->delete();
        }
        $hotel->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
    public function hotelLogin($id)
    {
        $hotelAdmin=User::where('hotel_id',$id)->first();
        $ro=RoleUser::where('user_id',$hotelAdmin->id)->first();

        $user=auth()->user();
        $user->update(['hotel_id'=>$id,'remember_token'=>$id]);

        $user->syncRoles([$ro->role_id]);
        session(['hotel_id'=>auth()->user()->hotel_id]);
        return redirect()->route('dashboard.home');
    }
    public function hotelLogout()
    {
        session(['hotel_id'=>null]);
        $user=auth()->user();
        $user->syncRoles([1]);
        $user->update(['hotel_id'=>null,'remember_token'=>null]);
        return redirect()->route('dashboard.home');
    }

}
