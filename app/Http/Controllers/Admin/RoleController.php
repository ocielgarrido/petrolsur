<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//agregamos
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //    abort_if(Gate::denies('role_index'), 403);
        $roles = Role::paginate(10);
        return view('pages.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // abort_if(Gate::denies('role_create'), 403);
        $permissions = Permission::all()->pluck('name', 'id');
        // dd($permissions);
        return view('pages.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create($request->only('name'));
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
     //   abort_if(Gate::denies('role_show'), 403);

        $role->load('permissions');
        return view('pages.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
      //  abort_if(Gate::denies('role_edit'), 403);

        $permissions = Permission::all()->pluck('name', 'id');
        $role->load('permissions');
        // dd($role);
        return view('pages.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update($request->only('name'));

        // $role->permissions()->sync($request->input('permissions', []));
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
       // abort_if(Gate::denies('role_delete'), 403);

        $role->delete();

        return redirect()->route('roles.index');
    }
}
