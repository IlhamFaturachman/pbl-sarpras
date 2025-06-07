<?php

namespace App\Http\Controllers\Admin;

use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request) {
        // Ambil semua role
        $roles = DB::table('m_role')->select('id', 'name')->get();

        // Query awal user
        $query = UserModel::query();

        // Filter berdasarkan role (jika ada)
        if ($request->filled('roles')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('id', $request->roles);
            });
        }

        // Paginate dengan filter query string
        $users = $query->paginate(10)->withQueryString();

        // Default empty user untuk form edit
        $editUser = new UserModel();
        $userRole = '';

        if (session('editUserId')) {
            $editUser = UserModel::find(session('editUserId'));
            $userRole = $editUser->roles->first()?->id ?? '';
        }

        // Detail user
        $detailUser = null;
        if (session('detailUserId')) {
            $detailUser = UserModel::with('roles')->find(session('detailUserId'));
        }

        return view('admin.user.index', [
            'users' => $users,
            'roles' => $roles,
            'editUser' => $editUser,
            'detailUser' => $detailUser,
            'userRole' => $userRole,
            'adding' => session('adding')
        ]);
    }

    public function store(Request $request) {
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:255|unique:m_user,nomor_induk',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:m_user,email',
            'password' => 'required|min:6',
            'foto_profile' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'role' => 'required|exists:m_role,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Jika validasi gagal, kirim kembali error ke form
            return redirect()->route('data.user')
                ->withErrors($validator)
                ->withInput()
                ->with('adding', true);
        }

        try {
            DB::beginTransaction();

            $data = [
                'nama_lengkap' => $request->nama_lengkap,
                'nomor_induk' => $request->nomor_induk,
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status' => $request->status ?? 'Tidak Aktif'
            ];

            if ($request->hasFile('foto_profile')) {
                $file = $request->file('foto_profile');
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->storeAs('public/foto_profile', $fileName);
                $data['foto_profile'] = 'foto_profile/'.$fileName;
            }

            // Simpan user ke database
            $user = UserModel::create($data);
            $role = RoleModel::findById($request->role);
            if ($role) {
                $user->assignRole($role);
            } else {
                throw new \Exception("Role tidak ditemukan");
            }

            DB::commit();

            // Jika menggunakan AJAX atau form biasa
            return redirect()->route('data.user')->with('success', 'Data User berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('data.user')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('adding', true);
        }
    }
    
    public function show($id) {
        $user = UserModel::with('roles')->find($id);

        if (!$user) {
            return redirect()->route('data.user')->with('error', 'User tidak ditemukan');
        }

        return response()->json([
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->first()
        ]);
    }

    public function edit($id) {
        $user = UserModel::findOrFail($id);
        $roles = DB::table('m_role')->select('id', 'name')->get();
        $userRole = $user->roles->first() ? $user->roles->first()->id : '';
        
        return response()->json([
            'user' => $user,
            'userRole' => $userRole
        ]);
    }
    
    public function update(Request $request, $id) {
        $user = UserModel::findOrFail($id);
        
        // Validasi input
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:255|unique:m_user,nomor_induk,'.$id.',user_id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:m_user,email,'.$id.',user_id',
            'password' => 'nullable|min:6',
            'foto_profile' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'role' => 'required|exists:m_role,id', // Pastikan ini sesuai dengan tabel roles Anda
            'status' => 'required|in:Aktif,Tidak Aktif'
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if($validator->fails()){
            return redirect()->route('data.user')
                ->withErrors($validator)
                ->withInput()
                ->with('editing', true)
                ->with('editUserId', $id);
        }
    
        try {
            DB::beginTransaction();
    
            $data = [
                'nama_lengkap' => $request->nama_lengkap,
                'nomor_induk' => $request->nomor_induk,
                'nama' => $request->nama,
                'email' => $request->email,
                'status' => $request->status
            ];
    
            // Update password jika diisi
            if (!empty($request->password)) {
                $data['password'] = bcrypt($request->password);
            }
    
            // Update foto profile jika ada
            if ($request->hasFile('foto_profile')) {
                // Hapus foto lama jika ada
                if ($user->foto_profile && Storage::exists('public/'.$user->foto_profile)) {
                    Storage::delete('public/'.$user->foto_profile);
                }
                
                $file = $request->file('foto_profile');
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->storeAs('public/foto_profile', $fileName);
                $data['foto_profile'] = 'foto_profile/'.$fileName; 
            }
    
            // Update user
            $user->update($data);
            
            // $role = DB::table('m_role')->find($request->role);
            // $user->syncRoles([$role->name]); 
            
            $user->roles()->sync([$request->role]);
            
            DB::commit();
    
            return redirect()->route('data.user')->with('success', 'Data User berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('data.user')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('editing', true)
                ->with('editUserId', $id);
        }
    }
    
    public function destroy($id) {
        try {
            $user = UserModel::findOrFail($id);
            
            // Hapus foto profile jika ada
            if ($user->foto_profile && Storage::exists('public/'.$user->foto_profile)) {
                Storage::delete('public/'.$user->foto_profile);
            }
            
            // Hapus roles terkait
            $user->syncRoles([]);
            
            // Hapus user
            $user->delete();
            
            return redirect()->route('data.user')->with('success', 'Data User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('data.user')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}