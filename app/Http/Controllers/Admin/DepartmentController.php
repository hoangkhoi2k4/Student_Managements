<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepository;
use App\Http\Requests\DepartmentFormRequest;

class DepartmentController extends Controller
{
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->middleware('permission:list_department')->only(['index']);
        $this->middleware('permission:create_department')->only(['create', 'store']);
        $this->middleware('permission:show_department')->only(['show']);
        $this->middleware('permission:update_department')->only(['edit', 'update']);
        $this->middleware('permission:destroy_departments')->only(['destroy']);
        $this->departmentRepository = $departmentRepository;
    }

    public function index(Request $request)
    {

        $departments = $this->departmentRepository->getAll($request->all());
        return view('admin.departments.index', compact('departments'));
    }
    public function create()
    {
        return view('admin.departments.form');
    }
    public function store(DepartmentFormRequest $request)
    {
        $this->departmentRepository->create($request->all());
        return redirect()->route('departments.index')->with('success', __('Created Successfully'));
    }
    public function edit($id)
    {
        $department = $this->departmentRepository->findOrFail($id);
        return view('admin.departments.form', compact('department'));
    }
    public function update(DepartmentFormRequest $request, $id)
    {
        $this->departmentRepository->update($request->all(), $id);
        return redirect()->route('departments.index')->with('success', __('Updated Successfully'));
    }
    public function destroy($id)
    {
        $this->departmentRepository->delete($id);
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }
}
