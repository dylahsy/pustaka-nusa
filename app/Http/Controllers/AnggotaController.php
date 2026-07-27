<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Denda;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    private const GENDER_OPTIONS = ['Laki-laki', 'Perempuan'];
    private const DEFAULT_ANGGOTA_TYPE = 'Siswa';

    public function index(Request $request)
    {
        $search = $request->search;
        $data['anggota'] = Anggota::where(function ($query) {
                $query->whereNull('jenis')->orWhere('jenis', self::DEFAULT_ANGGOTA_TYPE);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('kode_anggota', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('kelas', 'like', "%{$search}%")
                        ->orWhere('jenis_kelamin', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })->paginate(5)->withQueryString();
        $data['judul'] = 'Data Anggota';
        $data['search'] = $search;
        return view('anggota_index', $data);
    }

    public function create()
    {
        return view('anggota_create', [
            'jenis_kelamin' => self::GENDER_OPTIONS,
            'kode_anggota' => $this->generateKodeAnggota(),
            'judul' => 'Tambah Data Anggota',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->anggotaRules(), $this->anggotaMessages());
        try {
            $anggota = new Anggota();
            $anggota->kode_anggota = $this->generateKodeAnggota();
            $anggota->fill($validated);
            $anggota->status_anggota = 'Aktif';
            $anggota->alamat = $validated['alamat'] ?? '-';
            $anggota->foto_kartu = $this->storeFotoKartu($request);
            $anggota->save();
            return redirect('/anggota')->with('pesan', 'Data anggota berhasil disimpan');
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->withErrors(['foto_kartu' => 'Foto kartu gagal disimpan. Coba unggah ulang gambar yang valid.']);
        }
    }

    public function edit(string $id)
    {
        return view('anggota_edit', [
            'anggota' => Anggota::findOrFail($id),
            'jenis_kelamin' => self::GENDER_OPTIONS,
            'judul' => 'Edit Data Anggota',
        ]);
    }

    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $validated = $request->validate($this->anggotaRules($anggota, false), $this->anggotaMessages());
        try {
            $oldFotoKartu = $anggota->foto_kartu;
            $anggota->fill($validated);
            $anggota->alamat = $validated['alamat'] ?? '-';
            if ($request->hasFile('foto_kartu')) {
                $anggota->foto_kartu = $this->storeFotoKartu($request);
            }
            $anggota->save();
            if ($request->hasFile('foto_kartu') && $oldFotoKartu && $oldFotoKartu !== $anggota->foto_kartu) {
                $this->deleteFotoKartuPath($oldFotoKartu);
            }
            return redirect('/anggota')->with('pesan', 'Data anggota berhasil diupdate');
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->withErrors(['foto_kartu' => 'Foto kartu gagal diupdate. Coba unggah ulang gambar yang valid.']);
        }
    }

    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $transaksiIds = Transaksi::where('anggota_id', $anggota->id)->pluck('id');
        Denda::whereIn('transaksi_id', $transaksiIds)->delete();
        Transaksi::whereIn('id', $transaksiIds)->delete();
        $this->deleteFotoKartuPath($anggota->foto_kartu);
        $anggota->delete();
        return back()->with('pesan', 'Data anggota berhasil dihapus');
    }

    public function kartu(Anggota $anggota)
    {
        $missingFields = $this->missingAnggotaCardFields($anggota);
        if ($missingFields) {
            return redirect()->route('anggota.edit', $anggota)->withErrors([
                'kartu_anggota' => 'Lengkapi data berikut sebelum mencetak kartu: '.implode(', ', $missingFields).'.',
            ]);
        }
        return view('anggota_kartu', ['anggota' => $anggota, 'judul' => 'Cetak Kartu Anggota']);
    }

    public function laporan()
    {
        $periode = $this->resolveReportPeriod(request());
        return view('anggota_laporan', [
            'anggota' => Anggota::where(function ($query) {
                $query->whereNull('jenis')->orWhere('jenis', self::DEFAULT_ANGGOTA_TYPE);
            })->whereYear('created_at', $periode['tahun'])->whereMonth('created_at', $periode['bulan'])->orderBy('nama')->get(),
            'judul' => 'Laporan Data Anggota', 'periode' => $periode['periode'],
        ]);
    }

    private function storeFotoKartu(Request $request): ?string
    {
        if (!$request->hasFile('foto_kartu')) return null;
        $uploadPath = public_path('uploads/anggota-cards');
        if (!File::exists($uploadPath)) File::makeDirectory($uploadPath, 0755, true, true);
        $file = $request->file('foto_kartu');
        $extension = strtolower($file->extension() ?: $file->getClientOriginalExtension() ?: 'jpg');
        $fileName = uniqid('anggota_', true).'.'.$extension;
        if (file_put_contents($uploadPath.DIRECTORY_SEPARATOR.$fileName, file_get_contents($file->getRealPath())) === false) {
            throw new \RuntimeException('Gagal menyimpan foto kartu.');
        }
        return 'uploads/anggota-cards/'.$fileName;
    }

    private function deleteFotoKartuPath(?string $relativePath): void
    {
        if ($relativePath && File::exists(public_path($relativePath))) File::delete(public_path($relativePath));
    }

    private function generateKodeAnggota(): string
    {
        return 'AGT-'.str_pad((string) ((Anggota::max('id') ?? 0) + 1), 4, '0', STR_PAD_LEFT);
    }

    private function anggotaRules(?Anggota $anggota = null, bool $fotoRequired = true): array
    {
        return [
            'nis' => ['required', 'string', 'max:255', Rule::unique('anggota', 'nis')->ignore($anggota?->id)], 'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:255'], 'jenis_kelamin' => ['required', Rule::in(self::GENDER_OPTIONS)],
            'no_hp' => ['required', 'string', 'max:30', Rule::unique('anggota', 'no_hp')->ignore($anggota?->id)], 'alamat' => ['required', 'string', 'max:255'],
            'foto_kartu' => [$fotoRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    private function anggotaMessages(): array
    {
        return ['nis.required'=>'Harap di isi kolom ini.', 'nis.unique'=>'NIS sudah terdaftar dan tidak boleh sama.', 'nama.required'=>'Harap di isi kolom ini.', 'kelas.required'=>'Harap di isi kolom ini.',
            'jenis_kelamin.required'=>'Harap di isi kolom ini.', 'jenis_kelamin.in'=>'Jenis kelamin harus Laki-laki atau Perempuan.',
            'no_hp.required'=>'Harap di isi kolom ini.', 'no_hp.unique'=>'No. HP sudah terdaftar dan tidak boleh sama.', 'alamat.required'=>'Harap di isi kolom ini.', 'foto_kartu.required'=>'Harap di isi kolom ini.',
            'foto_kartu.image'=>'Foto kartu harus berupa gambar.', 'foto_kartu.mimes'=>'Foto kartu harus berformat JPG, JPEG, PNG, atau WEBP.',
            'foto_kartu.max'=>'Ukuran foto kartu maksimal 5 MB.'];
    }

    private function missingAnggotaCardFields(Anggota $anggota): array
    {
        $missing = [];
        foreach (['nis'=>'NIS', 'nama'=>'Nama', 'kelas'=>'Kelas', 'jenis_kelamin'=>'Jenis Kelamin', 'no_hp'=>'No. HP'] as $field => $label) {
            if (blank($anggota->{$field})) $missing[] = $label;
        }
        if (blank($anggota->alamat) || trim((string) $anggota->alamat) === '-') $missing[] = 'Alamat';
        if (blank($anggota->foto_kartu) || !File::exists(public_path($anggota->foto_kartu))) $missing[] = 'Foto Kartu';
        return $missing;
    }
}
