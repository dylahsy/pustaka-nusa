<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    private const GENDER_OPTIONS = ['Laki-laki', 'Perempuan'];

    public function edit()
    {
        $user = request()->user();

        return view('kelola_akun', [
            'user' => $user,
            'profileCardMissing' => $this->missingProfileCardFields($user),
            'profileCardComplete' => $this->profileCardIsComplete($user),
        ]);
    }

    public function editData()
    {
        return view('profile_data_edit', [
            'user' => request()->user(),
            'genderOptions' => self::GENDER_OPTIONS,
        ]);
    }

    public function editPassword()
    {
        return view('profile_password_edit', [
            'user' => request()->user(),
        ]);
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nis_nip' => ['nullable', 'string', 'max:100', Rule::unique('users', 'nis_nip')->ignore($request->user()->id)],
            'jenis_kelamin' => ['nullable', Rule::in(self::GENDER_OPTIONS)],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'nis_nip.string' => 'NIS/NIP harus berupa teks.',
            'nis_nip.max' => 'NIS/NIP maksimal 100 karakter.',
            'nis_nip.unique' => 'NIS/NIP sudah terdaftar.',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'no_hp.string' => 'No. HP harus berupa teks.',
            'no_hp.max' => 'No. HP maksimal 30 karakter.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
        ]);

        $user = $request->user();
        $user->update([
            'name' => trim((string) $request->name),
            'nis_nip' => filled($request->nis_nip) ? trim((string) $request->nis_nip) : null,
            'jenis_kelamin' => filled($request->jenis_kelamin) ? trim((string) $request->jenis_kelamin) : null,
            'no_hp' => filled($request->no_hp) ? trim((string) $request->no_hp) : null,
            'alamat' => filled($request->alamat) ? trim((string) $request->alamat) : null,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.string' => 'Password baru harus berupa teks.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak sama.',
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.password.edit')->with('success', 'Password berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'profile_photo.required' => 'Foto profil wajib dipilih.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Foto profil harus berformat JPG, JPEG, PNG, atau WEBP.',
            'profile_photo.max' => 'Ukuran foto profil maksimal 5 MB.',
        ]);

        try {
            $user = $request->user();
            $oldPhotoPath = $user->profile_photo_path;
            $profilePhotoPath = $this->storeProfilePhoto($request);

            $user->update([
                'profile_photo_path' => $profilePhotoPath,
            ]);

            if ($oldPhotoPath && $oldPhotoPath !== $profilePhotoPath) {
                $this->deleteProfilePhotoPath($oldPhotoPath);
            }

            return back()->with('success', 'Foto profil berhasil diperbarui.');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors(['profile_photo' => 'Foto profil gagal diperbarui. Coba unggah ulang gambar yang valid.']);
        }
    }

    public function deletePhoto(Request $request)
    {
        $user = $request->user();
        $photoPath = $user->profile_photo_path;

        if ($photoPath) {
            $this->deleteProfilePhotoPath($photoPath);
            $user->update(['profile_photo_path' => null]);
        }

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }

    public function printCard()
    {
        $user = request()->user();

        if ($user->role !== 'Anggota') {
            return redirect()
                ->route('profile.edit')
                ->withErrors(['profile_card' => 'Fitur kartu anggota hanya tersedia untuk Anggota.']);
        }

        $missingFields = $this->missingProfileCardFields($user);

        if (! empty($missingFields)) {
            return redirect()
                ->route('profile.edit')
                ->withErrors([
                    'profile_card' => 'Lengkapi profil dulu sebelum mencetak kartu: ' . implode(', ', $missingFields) . '.',
                ]);
        }

        return view('profile_kartu_preview', [
            'anggotaCard' => $this->profileCardData($user),
            'autoPrint' => true,
        ]);
    }

    private function profileCardIsComplete($user): bool
    {
        return empty($this->missingProfileCardFields($user));
    }

    private function profileCardData($user): array
    {
        $profilePhoto = filled($user->profile_photo_path) && File::exists(public_path($user->profile_photo_path))
            ? asset($user->profile_photo_path)
            : null;
        $profileInitial = strtoupper(substr($user->name ?: 'U', 0, 1));
        $profileJenis = $user->jenis_anggota ?? $user->role ?? '-';
        $profileKelas = data_get($user, 'kelas');
        $profileGender = data_get($user, 'jenis_kelamin');
        $profileAlamat = data_get($user, 'alamat');
        $nomorAnggota = filled($user->nis_nip) ? trim((string) $user->nis_nip) : '-';

        $rows = [
            ['label' => 'NIS/NIP', 'value' => $nomorAnggota],
            ['label' => 'Nama', 'value' => $user->name ?: '-'],
            ['label' => 'Jenis', 'value' => $profileJenis ?: '-'],
        ];

        if ($profileJenis === 'Siswa' || filled($profileKelas)) {
            $rows[] = ['label' => 'Kelas', 'value' => $profileKelas ?: '-'];
        }

        $rows[] = ['label' => 'Jenis Kelamin', 'value' => $profileGender ?: '-'];
        $rows[] = ['label' => 'No. HP', 'value' => $user->no_hp ?: '-'];
        $rows[] = ['label' => 'Alamat', 'value' => $profileAlamat ?: '-', 'class' => 'address-value'];

        return [
            'title_top' => 'Kartu Tanda Anggota Perpustakaan',
            'title_bottom' => 'SMA Negeri 9 Kota Jambi',
            'rows' => $rows,
            'photo' => $profilePhoto,
            'photo_alt' => 'Foto profil ' . ($user->name ?: 'pengguna'),
            'initial' => $profileInitial,
            'note' => 'Kartu ini dapat digunakan untuk administrasi perpustakaan dan wajib dibawa saat peminjaman.',
            'photo_slot_id' => 'profile-card-photo-slot',
        ];
    }

    private function missingProfileCardFields($user): array
    {
        $missing = [];

        if (blank($user->name)) {
            $missing[] = 'Nama';
        }

        if (blank($user->nis_nip)) {
            $missing[] = 'NIS/NIP';
        }

        if (blank($user->jenis_kelamin)) {
            $missing[] = 'Jenis Kelamin';
        }

        if (blank($user->no_hp)) {
            $missing[] = 'No. HP';
        }

        if (blank($user->alamat)) {
            $missing[] = 'Alamat';
        }

        if (blank($user->profile_photo_path) || ! File::exists(public_path($user->profile_photo_path))) {
            $missing[] = 'Foto Profil';
        }

        return $missing;
    }

    private function storeProfilePhoto(Request $request): string
    {
        $user = $request->user();
        $uploadPath = public_path('uploads/profile-photos');

        if (! File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true, true);
        }

        $file = $request->file('profile_photo');
        $extension = strtolower($file->extension() ?: $file->getClientOriginalExtension() ?: 'jpg');
        $fileName = 'user-' . $user->id . '-' . uniqid('', true) . '.' . $extension;
        $targetPath = $uploadPath . DIRECTORY_SEPARATOR . $fileName;
        $contents = file_get_contents($file->getRealPath());

        if ($contents === false || File::put($targetPath, $contents) === false) {
            throw new \RuntimeException('Gagal menyimpan foto profil.');
        }

        return 'uploads/profile-photos/' . $fileName;
    }

    private function deleteProfilePhotoPath(?string $relativePath): void
    {
        if (! $relativePath) {
            return;
        }

        $oldPhoto = public_path($relativePath);

        if (File::exists($oldPhoto)) {
            File::delete($oldPhoto);
        }
    }

    private function buildProfileCardSvg($user): string
    {
        $name = $this->escapeSvg($user->name ?: 'Pengguna');
        $email = $this->escapeSvg($user->email ?: '-');
        $role = $this->escapeSvg($user->role ?? '-');
        $status = $this->escapeSvg($user->status ?? 'Aktif');
        $anggotaNumber = $this->escapeSvg(filled($user->nis_nip) ? trim((string) $user->nis_nip) : '-');
        $initial = $this->escapeSvg(Str::of($user->name ?: 'U')->substr(0, 1)->upper());
        $photoDataUri = $this->profilePhotoDataUri($user->profile_photo_path);

        $photoBlock = $photoDataUri
            ? '<defs><clipPath id="photo-clip"><rect x="82" y="168" width="244" height="308" rx="28" /></clipPath></defs><image href="' . $this->escapeSvg($photoDataUri) . '" x="82" y="168" width="244" height="308" preserveAspectRatio="xMidYMid slice" clip-path="url(#photo-clip)" />'
            : '<rect x="82" y="168" width="244" height="308" rx="28" fill="#f5f3ff" stroke="#6d28d9" stroke-width="4" /><text x="204" y="340" fill="#6d28d9" font-family="Poppins, Arial, sans-serif" font-size="78" font-weight="800" text-anchor="middle">' . $initial . '</text>';

        return <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" width="1016" height="640" viewBox="0 0 1016 640">
  <defs>
    <linearGradient id="card-bg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#f8fafc"/>
      <stop offset="55%" stop-color="#f5f3ff"/>
      <stop offset="100%" stop-color="#eef2ff"/>
    </linearGradient>
    <linearGradient id="accent" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0%" stop-color="#4c1d95"/>
      <stop offset="100%" stop-color="#7c3aed"/>
    </linearGradient>
    <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
      <feDropShadow dx="0" dy="18" stdDeviation="18" flood-color="#4c1d95" flood-opacity="0.16"/>
    </filter>
  </defs>
  <rect x="0" y="0" width="1016" height="640" rx="42" fill="url(#card-bg)"/>
  <circle cx="912" cy="96" r="122" fill="#ddd6fe" opacity="0.28"/>
  <circle cx="126" cy="560" r="154" fill="#c7d2fe" opacity="0.24"/>
  <rect x="44" y="44" width="928" height="552" rx="34" fill="#ffffff" filter="url(#shadow)"/>
  <rect x="44" y="44" width="928" height="72" rx="34" fill="url(#accent)"/>
  <rect x="44" y="44" width="9" height="552" rx="4.5" fill="#4c1d95"/>
  <text x="84" y="91" fill="#ffffff" font-family="Poppins, Arial, sans-serif" font-size="28" font-weight="800">SIMPUS SMANES</text>
  <text x="932" y="91" fill="#e0e7ff" font-family="Poppins, Arial, sans-serif" font-size="18" font-weight="700" text-anchor="end">Kartu Profil Digital</text>

  <rect x="82" y="168" width="244" height="308" rx="28" fill="#f8fafc" stroke="#bfdbfe" stroke-width="4"/>
  {$photoBlock}

  <text x="382" y="182" fill="#64748b" font-family="Poppins, Arial, sans-serif" font-size="18" font-weight="700">Nama Lengkap</text>
  <text x="382" y="222" fill="#0f172a" font-family="Poppins, Arial, sans-serif" font-size="34" font-weight="800">{$name}</text>

  <text x="382" y="286" fill="#64748b" font-family="Poppins, Arial, sans-serif" font-size="18" font-weight="700">NIS/NIP</text>
  <text x="382" y="326" fill="#0f172a" font-family="Poppins, Arial, sans-serif" font-size="28" font-weight="800">{$anggotaNumber}</text>

  <text x="382" y="390" fill="#64748b" font-family="Poppins, Arial, sans-serif" font-size="18" font-weight="700">Email</text>
  <text x="382" y="430" fill="#0f172a" font-family="Poppins, Arial, sans-serif" font-size="26" font-weight="700">{$email}</text>

  <rect x="382" y="468" width="220" height="46" rx="23" fill="#dbeafe"/>
  <text x="492" y="498" fill="#1d4ed8" font-family="Poppins, Arial, sans-serif" font-size="18" font-weight="800" text-anchor="middle">{$role}</text>

  <rect x="622" y="468" width="170" height="46" rx="23" fill="#dcfce7"/>
  <text x="707" y="498" fill="#166534" font-family="Poppins, Arial, sans-serif" font-size="18" font-weight="800" text-anchor="middle">{$status}</text>

  <text x="82" y="544" fill="#475569" font-family="Poppins, Arial, sans-serif" font-size="16" font-weight="700">Kartu ini dapat diunduh dan dicetak untuk keperluan administrasi perpustakaan.</text>
</svg>
SVG;
    }

    private function profilePhotoDataUri(?string $relativePath): ?string
    {
        if (! $relativePath) {
            return null;
        }

        $absolutePath = public_path($relativePath);

        if (! File::exists($absolutePath)) {
            return null;
        }

        $mimeType = File::mimeType($absolutePath) ?: 'image/jpeg';

        return 'data:' . $mimeType . ';base64,' . base64_encode(File::get($absolutePath));
    }

    private function escapeSvg(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
