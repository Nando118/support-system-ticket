<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize("viewUsers", User::class);

        if (\request()->ajax()){
            $data_builder = User::query()->get();

            return DataTables::of($data_builder)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group mr-1">';
                    $btn .= '<a href="'. route("users.edit", ["id" => $row->id]) .'" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-fw fa-edit"></i></a> ';
                    $btn .= '<button type="button" class="delete btn btn-danger btn-sm" title="Delete" data-url="'. route("users.delete", ["id" => $row->id]) .'"><i class="fas fa-fw fa-trash"></i></button> ';
                    $btn .= '</div>';
                    return $btn;
                })
                ->toJson();
        }

        return view("dashboard.users.users", [
            "title_page" => "Support Ticket System | Users"
        ]);
    }

    public function create()
    {
        $this->authorize("createNewUser", User::class);

        $action = route("users.create");

        return view("dashboard.users.form.form-user", [
            "title_page" => "Support Ticket System | Create New User",
            "action" => $action
        ]);
    }

    public function store(UserCreateRequest $request)
    {
        $this->authorize("createNewUser", User::class);

        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $user = new User($validated);
            $user->role = $validated["role"];
            $user->password = Hash::make($validated["password"]);
            $user->save();

            DB::commit();
            return redirect()->route("users.index")->with('success_create_new_user', 'Berhasil menambahkan pengguna baru!');
        }catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route("users.index")->with('error_create_new_user', 'Terjadi kesalahan saat menambahkan pengguna baru!');
        }
    }

    public function edit(string $id)
    {
        $current_user = Auth::user();
        $this->authorize("updateUserData", $current_user);

        $user = User::query()->where("id", "=", $id)->firstOrFail();
        $action = route("users.update", ["id" => $id]);

        return view("dashboard.users.form.form-user", [
            "title_page" => "Support Ticket System | Update User",
            "user_data" => $user,
            "action" => $action
        ]);
    }

    public function update(string $id, Request $request)
    {
        $current_user = Auth::user();
        $this->authorize("updateUserData", $current_user);

        try {
            $user = User::query()->where("id", "=", $id)->firstOrFail();

            $rules = [
                "name" => ["required", "string", "min:3", "max:200"],
                "role" => ["required"]
            ];

            if ($request["password"]) {
                $rules["password"] = ["required", "string", "min:8"];
            }

            $valid = $request->validate($rules);

            if ($valid) {
                $data = [
                    'name' => $valid['name'],
                    'role' => $valid['role'],
                ];

                if ($request["password"]) {
                    $data['password'] = bcrypt($valid['password']);
                }

                $user->update($data);
            }

            DB::commit();
            return redirect()->route("users.index")->with('success_update_user', 'Berhasil mengubah data pengguna!');
        }catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route("users.index")->with('error_update_user', 'Terjadi kesalahan saat mengubah data pengguna!');
        }
    }

    public function delete(string $id)
    {
        $current_user = Auth::user();
        $this->authorize("deleteUserData", $current_user);

        $userData = User::findOrFail($id);

        if ($userData) {
            $userData->delete();
        } else {
            return response([
                'success' => false,
                'error' => 'Data pengguna tidak ditemukan!'
            ]);
        }
        return response([
            'success' => true
        ]);
    }
}
