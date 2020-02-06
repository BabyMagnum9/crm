<?php

namespace App\Http\Controllers;

use App\Events\Users\Auth\ChangePassword;
use App\Models\Users\Role;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{

    /**
     * @var User
     */
    protected $users;

    /**
     * @var Role $roles
     */
    protected $roles;

    /**
     * UserController constructor.
     * @param User $users
     * @param Role $roles
     */
    public function __construct(User $users, Role $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        SEOMeta::setTitle('Пользователи');
        $frd = $request->all();
        $users = $this->users::filter($frd)->paginate(20);

        return view('users.index', compact('users', 'frd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        SEOMeta::setTitle('Добавление пользователя');
        return view('users.create');
    }


    public function store(Request $request)
    {

        $date = Carbon::now()->subYears(18);
        $this->validate($request, [
            'f_name' => 'required|min:1|max:50',
            'l_name' => 'required|min:1|max:50',
            'm_name' => 'required|min:1|max:50',
            'age' => 'required|min:1|max:50',
            'email' => 'required|unique:users',
            'image' => 'required|mimes:jpeg,jpg,png|dimensions:min_width=1000,min_height=400',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            "date_birth" => 'required|before:'.$date,
        ]);

        $data = $request->all();
        $data['date_birth']  = Carbon::parse( $data['date_birth']);

        $user = User::create($data);

        $user->setName($data['f_name'], 1);
        $user->setName($data['m_name'], 2);
        $user->setName($data['l_name'], 0);
        $user->setPassword($data['password']);
        $user->save();

        $image = $request->file('image');

        $storage = Storage::disk('public');
        $localPath = '/users/avatars/'.md5($user->getKey()).'.jpg';
        $storage->put($localPath, $image->get());
        if (isset($data['roles'])){
            $user->roles()->sync($data['roles']);
        }
        $publicPath = $storage->url($localPath);
        $user->setImageUrl($publicPath);
        $user->save();
        $flashMessages = [['type' => 'success', 'text' => 'Пользователь «' . $user->getName() . '» создан']];
        return redirect()->route('users.index')->with(compact('flashMessages'));;

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        SEOMeta::setTitle($user->getName());
        return view('users.show', compact('user'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user)
    {
        $frd = $request->only([
            'f_name',
            'l_name',
            'm_name',
            'phones',
            'email',
        ]);

        $this->validate($request, [
            'l_name' => 'required',
            'email'=>'required|unique:users,email,'.$user->getKey(),
            'image' => 'required|mimes:jpeg,jpg,png|dimensions:min_width=1000,min_height=400',
        ]);

        /**
         * @var User $user
         */
        $user->setFirstName($frd['f_name']);
        $user->setLastName($frd['l_name']);
        $user->setMiddleName($frd['m_name']);
        $user->setEmail($frd['email']);
        $user->save();

        $user->syncPhones($frd['phones']);

        $image = $request->file('image');
        \Image::make($image)->resize(null,500,function ($constraint){
            $constraint->aspectRatio();
        });
        /**
         * @var FilesystemAdapter $storage
         */
        $storage = Storage::disk('public');
        $localPath = '/users/avatars/'.md5($user->getKey()).'.jpg';
        $storage->put($localPath, $image->get());

        $publicPath = $storage->url($localPath);
        $image=$publicPath;
        $user->setImageUrl($publicPath);
        $user->save();
        dd($image);

        $flashMessages = [['type' => 'success', 'text' => 'Пользователь «'.$user->getName() .'» сохранен']];

        return redirect()->back()->with(compact('flashMessages','$image'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back();
    }


    public function  roles(User $user)
    {
        SEOMeta::setTitle('Роль для '.$user->getName() );

        $roles = $this->roles::get();

        return view('users.roles', compact('user','roles'));

    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rolesUpdate(Request $request,User $user)
    {
        $frd = $request->only('roles');

        $user->roles()->sync($frd['roles']);

        $flashMessages = [['type' => 'success', 'text' => 'Роль у '.$user->getName() .' успешно обновлена.']];

        return redirect()->back()->with(compact('flashMessages'));
    }



    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logs(Request $request,User $user)
    {
        SEOMeta::setTitle('Логи — '.$user->getName() );
        $frd = $request->all();
        $logs = $user->logs()->filter($frd)->orderBy('id','desc')->paginate($frd['perPage'] ?? 20);
        return view('users.logs', compact('user','logs'));
    }


    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password(User $user)
    {
        SEOMeta::setTitle('Пароль — '.$user->getName());
        return view('users.password', compact('user'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function passwordUpdate(Request $request,User $user)
    {
        $this->validate($request,[
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $frd = $request->only('password');
        $user->setPassword($frd['password']);
        $user->save();
        event(new ChangePassword($user));
        $flashMessages = [['type' => 'success', 'text' => 'Пароль пользователя «'.$user->getName() .'» сохранен']];

        return redirect()->back()->with(compact('flashMessages'));
    }

}
