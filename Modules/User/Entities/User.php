<?php

namespace Modules\User\Entities;

use Modules\Area\Entities\City;
use Modules\Note\Entities\Note;
use Modules\User\Enum\UserType;
use Modules\Area\Entities\State;
use Spatie\MediaLibrary\HasMedia;
use Modules\Area\Entities\Country;
use Modules\Ensaan\Entities\Circle;
use Modules\Vendor\Entities\Vendor;
use Modules\Core\Traits\ScopesTrait;
use Modules\Invoice\Entities\Invoice;
use Modules\User\Entities\CustomToken;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Modules\Ensaan\Entities\CircleAttend;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\ClearsResponseCache;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Ensaan\Entities\AttendUserResult;
use Modules\Ensaan\Entities\UserNotification;
use Modules\Ensaan\Entities\RegisterUserRequest;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use CrudModel{
        __construct as private CrudConstruct;
    }
    use ClearsResponseCache;

    use Notifiable , HasRoles , InteractsWithMedia;

    use SoftDeletes {
      restore as private restoreB;
    }

    protected $guard_name = 'web';
    protected $dates = [
      'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'image' , "type",
        "admin_approved", "is_verified", "phone_code", "nationality_id" ,"id_image", "id_number",
        'vendor_id', 'add_by_vendor_id', 'city_id', 'state_id'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setLogAttributes(['name', 'email', 'password', 'mobile' , 'image']);
    }

    public function restore()
    {
        $this->restoreB();
    }

    public function mobileCode()
    {
        return $this->morphOne(MobileCode::class, 'user');
    }

    public function nationality()
    {
        return $this->belongsTo(Country::class, "nationality_id");
    }

    public function city()
    {
        return $this->belongsTo(City::class, "city_id");
    }

    public function state()
    {
        return $this->belongsTo(State::class, "state_id");
    }

    public function getPhone()
    {
        return ($this->phone_code ?? "965") . $this->mobile;
    }

    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class, "user_id");
    }

    public function unreadUserNotifications()
    {
        return $this->hasMany(UserNotification::class, "user_id")->whereNull("read_at");
    }

    public function scopeBaseType($query, $type)
    {
        $query->where("type", $type);
    }

    public function custom_tokens()
    {
        return $this->hasMany(CustomToken::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'model_id');
    }
}
