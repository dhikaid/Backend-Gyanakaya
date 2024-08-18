<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostAuthResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function signin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string|max:30|exists:users,username',
                'password' => 'required|min:8|string',
            ]);


            if (Auth::attempt($validatedData)) {
                $user = User::firstWhere('username', $validatedData['username']);
                return (new PostAuthResource(200, 'Sukses login.', $user))->additional([
                    'token' => $user->createToken("sanctum_token_auth")->plainTextToken,
                ]);
            }

            return new PostAuthResource(422, 'Username atau password salah. Silahkan coba kembali.');
        } catch (ValidationException $e) {
            return new PostAuthResource(422, 'Something wrong!', $e->errors());
        }
    }

    public function signup(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string|max:30|unique:users,username',
                'fullname' => 'required|string|max:150',
                'email' => 'required|email:rfc,dns|string|unique:users,email',
                'password' => 'required|min:8|string',
                'password2' => 'required|min:8|string|same:password',
            ]);
            $validatedData['uuid'] = fake()->uuid();
            $validatedData['password'] = Hash::make($validatedData['password']);
            DB::transaction(function () use ($validatedData, &$user) {
                $user = User::create($validatedData);
            });

            return new PostAuthResource(200, 'Sukses, silahkan login.');
        } catch (ValidationException $e) {
            return new PostAuthResource(422, 'Something wrong!', $e->errors());
        }
    }


    public function signout(Request $request)
    {
        $request->user()->tokens()->delete();
        return new PostAuthResource(200, 'Sukses, anda telah logout dari sistem.');
    }


    public function user(Request $request)
    {
        return new PostAuthResource(200, 'Sukses, ini adalah akun anda.', $request->user());
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $user = User::firstWhere('uuid', $request->user()->uuid);
            // VALIDATE
            $rules = [
                'username' => 'required|string|max:30',
                'fullname' => 'required|string|max:150',
                'email' => 'required|email:rfc,dns|string',
            ];

            if ($request->email !== $user->email) {
                $rules['email'] = 'required|email:rfc,dns|string|unique:users,email';
            }

            if ($request->username !== $user->username) {
                $rules['username'] = 'required|string|max:30|unique:users,username';
            }


            if ($request->password) {
                $rules['prev_password'] = 'required|min:8|string';
                $rules['password'] = 'required|min:8|string';
                $rules['password2'] = 'required|min:8|string|same:password';
            }

            $validatedData = $request->validate($rules);

            if ($request->password) {
                if (password_verify($validatedData['password'], $user->password)) {
                    $validatedData['password'] = Hash::make($validatedData['password']);
                    unset($validatedData['password2']);
                } else {    
                    return new PostAuthResource(200, 'Gagal! Password salah');
                }
            }

            DB::transaction(function () use ($validatedData, &$user, $request) {
                User::where('uuid', $request->user()->uuid)->update($validatedData);
                $user =  User::firstWhere('uuid', $request->user()->uuid);
            });

            return new PostAuthResource(200, 'Sukses, profile telah diupdate.', $user);
        } catch (ValidationException $e) {
            return new PostAuthResource(422, 'Something wrong!', $e->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
