<?php

namespace App\Models\User;

use App\Models\FieldsClass;
use Illuminate\Database\Eloquent\Model;

class UserFields extends FieldsClass
{
    const string TABLE = 'users';

    const string ID = 'id';
    const string NAME = 'name';
    const string EMAIL = 'email';
    const string PASSWORD = 'password';
    const string EMAIL_VERIFIED_AT = 'email_verified_at';
    const string PHONE_NUMBER = 'phone_number';
    const string IS_PROFILE_COMPLETED = 'is_profile_completed';
    const string OTP_CODE = 'otp_code';
    const string OTP_EXPIRE_AT = 'otp_expired_at';
    const string REMEMBER_TOKEN = 'remember_token';
    const string CREATED_AT = 'created_at';
    const string UPDATED_AT = 'updated_at';

}
