<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Mengambil dan menampilkan semua data (Read)
    public function index()
    {
        $users = DB::table('users')->get();
        return view('users.index', compact('users'));
    }

   
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email'
        ]);

       
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password123')
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }
}