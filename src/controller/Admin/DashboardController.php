<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PembayaranHarianExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Operasi\DaftarTugasController;
use App\Http\Services\Helper;
use App\Models\DaftarTugas;
use App\Models\Kalender;
use App\Models\MhsSetoran;
use App\Models\MhsTransaksiTagihan;
use App\Models\TahunAkademik;
use App\Models\User;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        $daftarTugasController = new DaftarTugasController();
        $daftarTugas = $daftarTugasController->hitungDeadline(DaftarTugas::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->offset(0)->limit(5)->get());
        $daftarTugas = $daftarTugasController->EditFormatDeadline($daftarTugas);
        $nDaftarTugas = count(DaftarTugas::all());
        $jumlahHalaman = ceil($nDaftarTugas / 5);

        $kalender = Kalender::where('user_id', auth()->user()->id)->get();
        $tahunAkademik = TahunAkademik::first();

        $jumlahPengguna = count(User::all());
        $transaksiTagihan = MhsTransaksiTagihan::all();
        $pemasukan = 0;
        foreach ($transaksiTagihan as $t) {
            $pemasukan += $t->dibayar;
        }

        $setoran = MhsSetoran::all();
        $pengeluaran = 0;
        foreach ($setoran as $s) {
            if (strtolower($s->status) == 'setuju') {
                $pengeluaran += $s->jumlah;
            }
        }
        $pending = 0;
        foreach ($setoran as $s) {
            if (strtolower($s->status) == 'pending') {
                $pending += $s->jumlah;
            }
        }
        $saldo = $pemasukan - $pengeluaran;
        return view('admin/dashboard/index', compact('daftarTugas', 'jumlahHalaman', 'kalender', 'tahunAkademik', 'jumlahPengguna', 'pemasukan', 'pengeluaran', 'saldo'));
    }

    public function inputTahunAkademik(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                "tahun_akademik_1" => 'required',
                "tahun_akademik_2" => 'required',
                "semester_ta" => 'required',
            ]);

            $tahunAkademik = TahunAkademik::first();
            $tahunAkademik->update([
                'tahun_akademik' => $dataValidated['tahun_akademik_1'] . '-' . $dataValidated['tahun_akademik_2'],
                'semester' => $dataValidated['semester_ta']
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Berhasil memperbarui tahun akademik');
        } catch (\Throwable $th) {
            return redirect()->route('admin.dashboard')->with('failed', 'Gagal memperbarui tahun akademik');
        }
    }
}
