<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $search = request('search');

        $data['admin'] = User::whereIn('role', $this->displayedAdminRoles())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->paginate(5)
            ->withQueryString();
        $data['judul'] = 'Tabel Data Admin';
        $data['search'] = $search;
        $data['canManageAdmin'] = $this->canManageAdmins();
        return view('admin_index', $data);
    }

    public function create()
    {
        if (! $this->canManageAdmins()) {
            return $this->denyAdminManagement();
        }

        $data['judul'] = 'Tambah Data Admin';
        return view('admin_create', $data);
    }

    public function store(Request $request)
    {
        if (! $this->canManageAdmins()) {
            return $this->denyAdminManagement();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'no_hp' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama admin wajib diisi.',
            'name.string' => 'Nama admin harus berupa teks.',
            'name.max' => 'Nama admin maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'no_hp.string' => 'No. HP harus berupa teks.',
            'no_hp.max' => 'No. HP maksimal 20 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'role' => $this->adminFormRole(),
            'password' => Hash::make($request->password),
        ]);

        return redirect('/admin')->with('pesan', 'Data admin berhasil disimpan');
    }

    public function edit(string $id)
    {
        if (! $this->canManageAdmins()) {
            return $this->denyAdminManagement();
        }

        $data['admin'] = $this->managedAdmin($id);
        $data['judul'] = 'Edit Data Admin';
        return view('admin_edit', $data);
    }

    public function update(Request $request, string $id)
    {
        if (! $this->canManageAdmins()) {
            return $this->denyAdminManagement();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'no_hp' => 'required|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama admin wajib diisi.',
            'name.string' => 'Nama admin harus berupa teks.',
            'name.max' => 'Nama admin maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'no_hp.string' => 'No. HP harus berupa teks.',
            'no_hp.max' => 'No. HP maksimal 20 karakter.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $admin = $this->managedAdmin($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->no_hp = $request->no_hp;
        $admin->role = $this->adminFormRole();
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect('/admin')->with('pesan', 'Data admin berhasil diupdate');
    }

    public function destroy(string $id)
    {
        if (! $this->canManageAdmins()) {
            return $this->denyAdminManagement();
        }

        if ((int) $id === auth()->id()) {
            return back()->with('pesan', 'Akun yang sedang digunakan tidak bisa dihapus.');
        }

        $this->managedAdmin($id)->delete();
        return back()->with('pesan', 'Data admin berhasil dihapus');
    }

    private function displayedAdminRoles(): array
    {
        return ['Admin', 'Kepala Perpustakaan'];
    }

    /**
     * Only regular Admin accounts are managed from this resource.
     * The Kepala Perpustakaan account is system-owned and can be viewed,
     * but its profile is managed from the profile page instead.
     */
    private function managedAdmin(string $id): User
    {
        return User::where('role', 'Admin')->findOrFail($id);
    }

    private function adminFormRole(): string
    {
        return 'Admin';
    }

    private function canManageAdmins(): bool
    {
        return auth()->user()?->role === 'Kepala Perpustakaan';
    }

    private function denyAdminManagement()
    {
        return redirect('/admin')->with('pesan', 'Akses kelola admin hanya untuk Kepala Perpustakaan.');
    }
}
