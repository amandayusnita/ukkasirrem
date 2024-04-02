<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->level == 'admin') {
            $data = User::all();
            return view('User.index', compact('data'));
        } else {
            return redirect()->route('user.edit', Auth::id());
        }
    }

    public function create()
    {
        $level = [
            'kasir' => 'kasir',
            'admin' => 'admin',
        ];
        return view('User.add', compact('level'));
    }

    public function update($id)
    {
        $level = [
            'kasir' => 'kasir',
            'admin' => 'admin',
        ];

        if (is_null($id)) {
            $id = Auth::id();
        } elseif (Auth::user()->level == 'kasir') {
            $id = Auth::id();
        }

        $data = User::find($id);
        return view('User.edit', compact('level', 'data'));
    }

    public function processCreate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'level' => 'required|in:admin,kasir',
        ], [
            'name.required' => 'Kolom Nama User Harus Terisi',
            'username.required' => 'Kolom Username Harus Terisi',
            'password.required' => 'Kolom Password Harus Terisi',
            'level.required' => 'Kolom Level Harus Dipilih',
            'level.in' => 'Kolom Level Harus Admin atau Kasir',
        ]);
        try {
            DB::beginTransaction();
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'level' => $request->level
            ]);
            DB::commit();
            return redirect()->route('user.index')->with(['msg' => 'Berhasil', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('user.add')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }

    public function processUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'level' => 'required|in:kasir,admin',
        ], [
            'name.required' => 'Kolom Nama User Harus Terisi',
            'username.required' => 'Kolom Username Harus Terisi',
            'level.required' => 'Kolom Level Harus Dipilih',
            'level.in' => 'Kolom Level Harus Admin atau Kasir',
        ]);
        try {
            DB::beginTransaction();

            $id = $request->id;
            if (!Auth::user()->level == 'kasir' && $request->id!=Auth::id()) {
                $id = Auth::id();
            }

            $user = User::find($id);
            if (is_null($request->password)) {
                $user->update($request->except('password', 'id'));
            } else {
                $user->update([$request->except('id'), 'password' => Hash::make($request->password)]);
            }

            DB::commit();
            return redirect()->route('user.index')->with(['msg' => 'Berhasil', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('user.edit')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            User::find($id)->delete();
            DB::commit();
            return redirect()->route('user.index')->with(['msg' => 'Berhasil', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('user.index')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }
}