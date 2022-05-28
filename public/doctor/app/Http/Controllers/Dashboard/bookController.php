<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\Book;


class bookController extends BackEndController
{
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request)
    {

        $rows = $this->model->when($request->search,function($q) use ($request){
            $q->whereHas('user',function($q)use($request){
                $q->Where('name','like','%'.$request->search.'%');
            })->whereHas('hotel',function($q)use($request){
                $q->Where('name','like','%'.$request->search.'%');
            });
        });
        $rows = $this->filter($rows,$request);
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    }

 
    public function destroy($id, Request $request)
    {
        $book = $this->model->findOrFail($id);
    
        $book->delete();
        session()->flash('success', __('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }
}
