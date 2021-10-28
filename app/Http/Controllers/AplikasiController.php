<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class AplikasiController extends Controller
{
    public function all()
    {
        /**
         * Shows all data from table Dosen and Mahasiswa
         */
        echo "## Dosen ## <br>";
        $dosens = Dosen::all();
        foreach ($dosens as $dosen) {
            echo "$dosen->nama <br>";
        }

        echo "<hr>";
        echo "## Mahasiswa ## <br>";
        $mahasiswas = Mahasiswa::all();
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nama | $mahasiswa->jurusan <br>";
        }
    }

    public function inputBeasiswa1()
    {
        $dosen = Dosen::where('nama', 'Lessie Hamill M.T')->first();

        $beasiswa = new Beasiswa;
        $beasiswa->nama = "Beasiswa Unggulan Dosen Indonesia";
        $beasiswa->jumlah_dana = 50000000;

        $dosen->beasiswa()->save($beasiswa);
        echo "$dosen->nama dapat beasiswa $beasiswa->nama";
    }
}
