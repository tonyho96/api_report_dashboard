<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class UserService
{
    public static function getRoles() {
        $result = [];
        foreach (config('user.roles') as $key => $value) {
            $result[$value] = 'users.roles.' . $key;
        }

        return $result;
    }

    public static function listUser($conditions, $paginate = 10)
    {
        $users = User::orderBy('id', 'desc');
        foreach ($conditions as $key => $value) {
            $users->where($key, $value);
        }

        if ($paginate)
            return $users->paginate(10);
        return $users->get();
    }

    public static function validate($input, $user= null) {
        $ruleValdates = [
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required',
            'mailchimp_api_key' => 'required'

//            'role' => 'in:' . implode(',', config('user.roles')),
        ];

        if ($user) {
            $ruleValdates['email'] .= ',id,' . $user->id;
        } else {
//            $ruleValdates['password'] = 'required|confirmed';
        }

        return Validator::make($input, $ruleValdates);
    }

    public static function create($input) {
        DB::beginTransaction();

        try {

            $user = User::create( [
                'name' => $input['name'],
                'email'  => $input['email'],
                'password'  => bcrypt( $input['password'] ),
                'role'   => $input['role'],
                'mailchimp_api_key' => $input['mailchimp_api_key'],
                'last_sync' => date('Y-m-d H:i:s'),
                'remember_token' => null,

            ] );

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            die($e->getMessage());
            return false;
        }
    }

    public static function update( $input, $user ) {
        DB::beginTransaction();
        try {
            $userData = [
                'name' => $input['name'],
                'email'  => $input['email'],
               'role'   => $input['role'],
               'mailchimp_api_key' => $input['mailchimp_api_key'],
            ];
            if ( strlen( $input['password'] ) ) {
                $userData['password'] = bcrypt( $input['password'] );
            }

            $user->update( $userData );

            DB::commit();

            return $user;
        } catch ( \Exception $e ) {
            DB::rollback();

            return false;
        }
    }

    public static function delete($user, $mes = null)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }
}

 ?>
