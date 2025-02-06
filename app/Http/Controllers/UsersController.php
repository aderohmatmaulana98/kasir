<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function users(){
        $title = 'Manajemen User';        
        $users = User::all(); 
        $role =  DB::table('role')->get();
        return view('users',  compact('title','users','role'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'id_role' => 'required',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'id_role' => $request->id_role,
            'password' => bcrypt($request->password),
        ]);
        session()->flash('success', 'User berhasil ditambahkan!');
        return redirect()->route('users');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan!'], 404);
        }
    
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User berhasil dihapus!']);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'id_role' => 'required',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan!'], 404);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'id_role' => $request->id_role,
        ]);

        session()->flash('success', 'Barang berhasil diubah!');
        return redirect()->route('users');
    }
}
