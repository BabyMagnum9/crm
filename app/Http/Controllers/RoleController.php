<?php

namespace App\Http\Controllers;

use App\Models\Users\Role;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Validation;

class RoleController extends Controller
{
    /**
     * @var Role
     */
    protected $roles;

    /**
     * RoleController constructor.
     * @param Role $roles
     */
    public function __construct(Role $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        SEOMeta::setTitle('Роли');
        $frd = $request->all();
        $roles = $this->roles::filter($frd)->paginate(20);
        return view('roles.index', compact('roles', 'frd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        SEOMeta::setTitle('Добавление роли');
        return view('roles.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:50',
            'display_name'=>'required|min:1|max:50',
            'description'=>'required|min:1|max:50',
        ]);

        $data = $request->all();

        $role = Role::create($data);
        $role->setName($data['name']);
        $role->setDisplayName($data['display_name']);
        $role->setDescription($data['description']);
        $role->save();

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
        SEOMeta::setTitle($role->getName());
        return view('roles.show', compact('role'));
    }

    /**
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Role $role)
    {
        $frd=$request->all();

        $this->validate($request,[
            'name' => 'required',
            'display_name'=>'required',
            'description'=>'required',
        ]);
        /**
         * @var Role $role
         */
        $role->setName($frd['name']);
        $role->setDisplayName($frd['display_name']);
        $role->setDescription($frd['description']);
        $role->save();

        return redirect()->back();
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back();
    }
}
