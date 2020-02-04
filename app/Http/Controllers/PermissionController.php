<?php

namespace App\Http\Controllers;

use App\Models\Users\Permission;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Validation;

class PermissionController extends Controller
{
    /**
     * @var Permission
     */
    protected $permissions;

    /**
     * PermissionController constructor.
     * @param Permission $permissions
     */
    public function __construct(Permission $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $frd = $request->all();
        $permissions = $this->permissions::filter($frd)->paginate(20);
        return view('permissions.index', compact('permissions', 'frd'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('permissions.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:50',
            'display_name'=>'required|min:1|max:50',
            'description'=>'required|min:1|max:50',
        ]);

        $data = $request->all();

        $permission = Permission::create($data);
        $permission->setName($data['name']);
        $permission->setDisplayName($data['display_name']);
        $permission->setDescription($data['description']);
        $permission->save();

        return redirect()->route('permissions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        SEOMeta::setTitle('Разрешение '.$permission->getDisplayName());
        return view('permissions.show', compact('permission'));
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Permission $permission)
    {
        $frd=$request->all();

        $this->validate($request,[
            'name' => 'required',
            'display_name'=>'required',
            'description'=>'required',
        ]);
        /**
         * @var Permission $permission
         */
        $permission->setName($frd['name']);
        $permission->setDisplayName($frd['display_name']);
        $permission->setDescription($frd['description']);
        $permission->save();

        return redirect()->back();
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->back();
    }
}
