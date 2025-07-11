<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('divisi')
            ->where('id', '!=', Auth::id())
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhereHas('divisi', function ($q2) use ($search) {
                        $q2->where('nama_divisi', 'like', '%' . $search . '%');
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $users->appends(['search' => $search]);

        if ($request->ajax()) {
            // return partial view untuk tbody tabel saja
            return view('table.usertable', compact('users'))->render();
        }

        return view('profile.kelolaprofile', compact('users'));
    }


    public function create()
    {
        $divisi = Divisi::all();
        return view('profile.addprofile', compact('divisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'posisi' => 'required',
            'divisi_id' => 'required|exists:divisi,id',
            'role' => 'required|in:pimpinan,pegawai,admin',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'posisi' => $request->posisi,
            'divisi_id' => $request->divisi_id,
            'role' => $request->role,

        ]);

        return redirect()->route('user.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Ambil data user berdasarkan ID
        return view('profile.editprofile', compact('user')); // Kirim data user ke view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;

        // Simpan file foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('images/profile'), $filename);
            $user->foto = 'images/profile/' . $filename;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus file foto jika ada
        if ($user->foto && file_exists(public_path($user->foto))) {
            unlink(public_path($user->foto));
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    public function divisiindex()
    {
        $divisis = Divisi::orderBy('created_at', 'desc')->paginate(10);
        return view('profile.divisi', compact('divisis'));
    }


     public function divisicreate()
    {
        return view('profile.adddivisi');
    }

    public function divisistore(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|unique:divisi',
        ]);

        Divisi::create([
            'nama_divisi' => $request->nama_divisi,
        ]);

        return redirect()->route('user.divisiindex')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function divisidestroy($id)
    {
        $divisi = Divisi::findOrFail($id);
        $divisi->delete();

        return redirect()->route('user.divisiindex')->with('success', 'Divisi berhasil dihapus');
    }


}
