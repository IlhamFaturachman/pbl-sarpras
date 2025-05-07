<?php

namespace App\Http\Controllers\Admin;

use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        $users = UserModel::get();
    
        $roles = DB::table('m_role')->select('id', 'name')->get();

        return view('admin.user.index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function store(Request $request){
        if($request){
            $rules = [
                'nama_lengkap' => 'required|string|max:255',
                'nomor_induk' => 'required|string|max:255|unique:m_user,nomor_induk',
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:m_user,email',
                'password' => 'required|min:6',
                'foto_profile' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
                'role' => 'required|exists:m_role,id' // Validasi role harus ada di tabel m_role
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'messages' => "Validasi Gagal",
                    'msgField' => $validator->errors()
                ]);
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
        
                // Buat user baru
                $user = UserModel::create($data);
                
                // Ambil role dari request dan assign ke user
                $role = RoleModel::findById($request->role);
                if ($role) {
                    $user->assignRole($role);
                } else {
                    throw new \Exception("Role tidak ditemukan");
                }
                
                DB::commit();
        
                return response()->json([
                    'status' => true,
                    'messages' => "Data Berhasil Disimpan"
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'messages' => "Terjadi kesalahan: " . $e->getMessage(),
                    'error' => $e->getMessage()
                ]);
            }
        }
    
        return redirect('/admin/data/user');
    }
}