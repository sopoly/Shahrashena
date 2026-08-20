<?php

namespace App\Models\User;

use App\Models\FieldsClass;
use Illuminate\Database\Eloquent\Model;

class UserFields extends FieldsClass
{
    const TABLE = 'users';

    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const EMAIL_VERIFIED_AT = 'email_verified_at';
    const PHONE_NUMBER = 'phone_number';
    const OTP_CODE = 'otp_code';
    const OTP_EXPIRE_AT = 'otp_expired_at';
    const REMEMBER_TOKEN = 'remember_token';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

}
