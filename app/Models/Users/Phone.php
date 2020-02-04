<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * App\Models\Users\Phone
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Phone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Phone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Phone query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Phone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Phone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Phone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\Phone whereUpdatedAt($value)
 */
class Phone extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * @return BelongsToMany
     */
    public function users():BelongsToMany{
        return $this->belongsToMany(User::class);
    }

    /**
     * @return Collection
     */
    public function getUsers():Collection{
        return $this->users;
    }

    /**
     * @return string
     */
    public function getName():string {
        return $this->{'name'};
    }


    /**
     * @param string $value
     */
    public function setFirstNameAttribute(string $value):void
    {
        $this->attributes['name'] = self::prepare($value);
    }


    /**
     * @param string|null $phone
     * @param bool $formatted
     * @return string|null
     */
    public static function prepare(string $phone = null, bool $formatted = false): ?string
    {
        if ('' === trim($phone)) {
            $phone = null;
        }
        if (null !== $phone) {
            $phone = preg_replace('/\D/', '', $phone);
            $phoneLength = strlen($phone);

            if (10 < $phoneLength && $phoneLength < 12) {
                /**
                 * Меняем 8 на +7 в русских номерах
                 */
                $phone = mb_substr($phone, -11, 11, 'UTF-8');

                if (strpos($phone, '8') === 0) {
                    $phone[0] = 7;
                }

            } elseif (10 === $phoneLength) {
                $phone = (int)'7' . $phone;
            } elseif ($phoneLength < 10) {
                $phone = null;
            }
        }

        /**
         * Форматирование на интернациональный формат, если требуется
         */
        if (true === $formatted && null !== $phone){
            if (null !== $phone) {
                try {
                    $phone = (string)$phone;
                    $phone = PhoneNumber::make($phone, ['RU', 'BE', 'UK', 'UA', 'US'])->formatInternational();
                } catch (\Exception $exception) {
                    Log::warning('User preparePhoneFormatted failed for "' . $phone . '" ' . $exception->getMessage());
                }
            }
        }

        return $phone;
    }

}
