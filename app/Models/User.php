<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
        'department',
        'position',
        'status',
        'deployed'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function two_zero_one_file()
    {
        if($this->employee_id != null){
            return $this->hasOne(TwoZeroOneFile::class, 'employee_id', 'employee_id');
        }else{
            return $this->hasOne(TwoZeroOneFile::class, 'employee_id', 'id');

        }
    }
    public function participated_trainings()
    {
        return $this->hasMany(TrainingApplicant::class, 'employee_id', 'employee_id')->where('status', 'approved');
    }
    public function approved_benefits()
    {
        return $this->hasMany(BenefitsApplicant::class, 'employee_id', 'employee_id')->where('status', 'approved');
    }
    
    public function favorite_websites()
    {
        return $this->hasMany(Favorites::class, 'employee_id', 'employee_id')->where('type', 'website');
    }
    public function favorite_ebooks()
    {
        return $this->hasMany(Favorites::class, 'employee_id', 'employee_id')->where('type', 'ebook');
    }
    public function favorite_videos()
    {
        return $this->hasMany(Favorites::class, 'employee_id', 'employee_id')->where('type', 'video');
    }
    public function favorites()
    {
        return $this->hasMany(Favorites::class, 'employee_id', 'employee_id');
    }

    public function employee_information()
    {
        if($this->employee_id != null){
            return $this->hasOne(EmployeeInformation::class,'employee_id', 'employee_id');
        }else{
            return $this->hasOne(EmployeeInformation::class,'employee_id','id');
        }
    }

    public function my_applying_job()
    {
        return $this->hasMany(jobApplicants::class, 'id', 'user_id');
    }

    public function leave_credits()
    {
        return $this->hasOne(LeaveCredit::class, 'employee_id', 'employee_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'employee_id', 'employee_id');
    }
    
    public function coerequest()
    {
        return $this->hasMany(CoeRequest::class, 'employee_id', 'employee_id');
    }

    
}
