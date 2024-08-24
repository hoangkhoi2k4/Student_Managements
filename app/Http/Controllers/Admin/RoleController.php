<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Http\Requests\RoleFormRequest;

class RoleController extends Controller
{
    protected $roleRepository;
    public function __construct(RoleRepository $roleRepository)
    {
        $this->middleware('permission:list_role')->only(['index']);
        $this->middleware('permission:create_role')->only(['create', 'store']);
        $this->middleware('permission:show_role')->only(['show']);
        $this->middleware('permission:update_role')->only(['edit', 'update']);
        $this->middleware('permission:destroy_role')->only(['destroy']);
        $this->roleRepository = $roleRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = $this->roleRepository->getAll($request->all());
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission_groups = $this->roleRepository->getPermissions();
        return view('admin.roles.form', compact('permission_groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->roleRepository->createRole($request->all());
            DB::commit();
            return redirect()->route('roles.index')->with('success', __('Created Successfully'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = $this->roleRepository->showRole($id);
        $permission_groups = $this->roleRepository->getPermissions();
        return view('admin.roles.form', compact('role', 'permission_groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleFormRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->roleRepository->updateRole($request->all(), $id);
            DB::commit();
            return redirect()->route('roles.index')->with('success', __('Updated Successfully'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = $this->roleRepository->deleteRole($id);
        if (!$role) {
            return redirect()->back()->with('error', __('Can not delete'));
        }
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }
}
