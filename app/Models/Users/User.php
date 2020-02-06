<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Users\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $f_name
 * @property string $l_name
 * @property string $m_name
 * @property string $phone
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereFName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereLName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereMName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @property int $age
 * @property string|null $date_birth
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereDateBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User filter($frd)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\UserLog[] $logs
 * @property-read int|null $logs_count
 * @property string $image_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\Phone[] $phones
 * @property-read int|null $phones_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereImageUrl($value)
 */
class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';


    /**
     * @var array
     */
    protected $hidden=[
        'password','remember_token',
    ];
    protected $fillable= [
        'name',
        'email',
        'password',
        'f_name',
        'l_name',
        'm_name',
        'phone',
        'age',
        'date_birth',
        'image_url',
    ];

    public function setName(string $name, int $typeId = 0): void
    {
        switch ($typeId) {
            case 1:
                {
                    $type = 'f_name';
                }
                break;
            case 2:
                {
                    $type = 'm_name';
                }
                break;
            default:
                {
                    $type = 'l_name';
                }
                break;
        }
        $this->{$type} = mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
    }

    public function getName(): string
    {
        return trim($this->getLastName() . ' ' . $this->getFirstName() . ' ' . $this->getMiddleName());
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $hash= Hash::make($password);
        $this->password = $hash;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->f_name;
    }

    /**
     * @param string $f_name
     */
    public function setFirstName(string $f_name): void
    {
        $this->f_name = $f_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->l_name;
    }

    /**
     * @param string $l_name
     */
    public function setLastName(string $l_name): void
    {
        $this->l_name = $l_name;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->m_name;
    }

    /**
     * @param string $m_name
     */
    public function setMiddleName(string $m_name): void
    {
        $this->m_name = $m_name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return string|null
     */
    public function getDateBirth(): ?string
    {
        return $this->date_birth;
    }

    /**
     * @param string|null $date_birth
     */
    public function setDateBirth(?string $date_birth): void
    {
        $this->date_birth = $date_birth;
    }



    /**
     * @param Builder $query
     * @param array $frd
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $frd): Builder
    {
        array_filter($frd);
        foreach ($frd as $key => $value) {
            if (null === $value) {
                continue;
            }
            switch ($key) {
                case 'search':
                    {
                        $query->where(function (Builder $query) use ($value): Builder {
                            return $query->orWhere('f_name', 'like', '%' . $value . '%')
                                ->orWhere('l_name', 'like', '%' . $value . '%')
                                ->orWhere('m_name', 'like', '%' . $value . '%');
                        });
                    }
                    break;
            }
        }
        return $query;
    }

    /**
     * @return string
     */
    public function getUrl():string {
        return route('users.show',$this);
    }

    /**
     * @return HasMany
     */
    public function logs():HasMany{
        return $this->hasMany(UserLog::class);
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->{'phone'};
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $phone = preg_replace('/\D/', '', $phone);
        $this->{'phone'} = $phone;
    }

    /**
     * @return BelongsToMany
     */
    public function phones():BelongsToMany{
        return $this->belongsToMany(Phone::class);
    }

    /**
     * @return Collection
     */
    public function getPhones():Collection{
        return $this->phones;
    }

    public function syncPhones(array $phones):array {
        $phonesIds = array();
        foreach ($phones as $phoneNumber){
            $phoneNumber = Phone::prepare($phoneNumber);
            if (null !== $phoneNumber){
                $phone = Phone::firstOrCreate([
                    'name'=>$phoneNumber,
                ]);
                $phonesIds[] = $phone->getKey();
            }
        }
        $this->phones()->sync($phonesIds);
        return $phonesIds;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    /**
     * @param string $image_url
     */
    public function setImageUrl(string $image_url): void
    {
        $this->image_url = $image_url;
    }



}
