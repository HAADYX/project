<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Api\BaseController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class CategoryController extends BackEndController
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //get all data of Model
        $rows = $this->model->when($request->search,function($q) use ($request){
            $q->whereTranslationLike('name','%' .$request->search. '%')
              ->orWhere('status','like','%'.$request->search.'%');
        });
        $rows = $this->filter($rows,$request);
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));


    } //end of ind


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ar.name'          => ['required','min:3','max:60'],
            'en.name'          => 'required|min:3|max:60',
            'image'            => 'nullable|image',
            'status'           => ['required',Rule::in('active','pending')],

        ]);
        //    return $request;
        $request_data = $request->except(['image','hotel_id']);
        if ($request->image) {
            $request_data['image'] = $this->uploadImage($request->image, 'categories');
        }
       //stor the category
        Category::create($request_data);
        session()->flash('success', __('site.add_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

    public function update(Request $request, $id)
    {
        //find the category
        $category = $this->model->findOrFail($id);
        $request->validate([
            'ar.name'          => ['required', 'min:3'],
            'en.name'          => ['required', 'max:60'],
            'image'            => 'nullable|image',
            'status'           => ['required',Rule::in('active','pending')],
        ]);
        $request_data = $request->except(['image','hotel_id']);
        if ($request->image) {
            if ($category->image != null) {
                Storage::disk('public_uploads')->delete('/categories/' . $category->image);
            }
            $request_data['image'] = $this->uploadImage($request->image, 'categories');
        } //end of if

       //update the category
      
        $category->update($request_data);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');


    }

    public function destroy($id, Request $request)
    {
        //find the category
        $category = $this->model->findOrFail($id);
        //delet the category
        $category->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

}
