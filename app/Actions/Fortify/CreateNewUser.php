<?php

namespace App\Actions\Fortify;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rule;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        
        Validator::make($input, [
            'role_id' => ['required', Rule::enum(UserRole::class)],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $clickId = request()->session()->get('clickId');
        request()->session()->forget('clickId');
        
        return User::create([
            'role_id' => $input['role_id'],
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'tapfiliate_id' => $clickId,
            'is_active' => ($input['role_id'] == 4) ? 0 : 1,
        ]);
    }
}
