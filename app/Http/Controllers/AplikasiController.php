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

    public function inputBeasiswa2()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Earlene Lehner')->first();

        $beasiswa = new Beasiswa;
        $beasiswa->nama  = "Beasiswa PPA";
        $beasiswa->jumlah_dana = 20000000;

        $mahasiswa->beasiswa()->save($beasiswa);
        echo "$mahasiswa->nama dapat beasiswa $beasiswa->nama <br>";

        $mahasiswa = Mahasiswa::where('nama', 'Lucinda Rempel')->first();

        $beasiswa = new Beasiswa;
        $beasiswa->nama  = "Beasiswa Pertamina";
        $beasiswa->jumlah_dana = 33000000;

        $mahasiswa->beasiswa()->save($beasiswa);
        echo "$mahasiswa->nama dapat beasiswa $beasiswa->nama <br>";
    }

    public function tampilBeasiswa1()
    {
        $dosen = Dosen::where('nama', 'Lessie Hamill M.T')->first();
        echo "Dosen $dosen->nama mengambil beasiswa {$dosen->beasiswa->nama}";
    }

    public function tampilBeasiswa2()
    {
        $mahasiswas = Mahasiswa::has('beasiswa')->get();
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nama | {$mahasiswa->beasiswa->nama} <br>";
        }
    }

    public function tampilBeasiswa3()
    {
        $beasiswa = Beasiswa::find(4);
        echo "Yang dapat $beasiswa->nama adalah {$beasiswa->beasiswaable->nama}";
    }

    public function tampilBeasiswa4()
    {
        $beasiswas = Beasiswa::all();
        foreach ($beasiswas as $beasiswa) {
            echo "$beasiswa->nama | {$beasiswa->beasiswaable->nama} <br>";
        }
    }

    public function whereHasMorph1()
    {
        /**
         * To limited data from spesific model
         */
        $beasiswas = Beasiswa::whereHasMorph('beasiswaable', 'App\Models\Mahasiswa')->get();

        foreach ($beasiswas as $beasiswa) {
            echo "$beasiswa->nama | {$beasiswa->beasiswaable->nama} <br>";
        }
    }

    public function whereHasMorph2()
    {
        /**
         * Show all beasiswas who relationship with 2 table.
         */
        $beasiswas = Beasiswa::whereHasMorph(
            'beasiswaable',
            ['App\Models\Mahasiswa', 'App\Models\Dosen']
        )->get();

        //  $beasiswas1 = Beasiswa::whereHasMorph('beasiswaable', '*')->get();

        foreach ($beasiswas as $beasiswa) {
            echo "$beasiswa->nama | {$beasiswa->beasiswaable->nama} <br>";
        }
    }

    public function updateBeasiswa1()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Earlene Lehner')->first();

        echo "Sebelum update: $mahasiswa->nama mendapatkan
                                {$mahasiswa->beasiswa->nama}";

        echo "<hr>";

        $mahasiswa->beasiswa()->update([
            'nama' => "Beasiswa Telkom"
        ]);

        //alternative
        $mahasiswa->beasiswa->nama = 'Beasiswa Pertamina';
        $mahasiswa->push();

        $mahasiswa = Mahasiswa::where('nama', 'Earlene Lehner')->first();
        echo "Setelah update: $mahasiswa->nama mendapatkan
                               {$mahasiswa->beasiswa->nama}";
    }

    public function updateBeasiswa2()
    {
        $beasiswa = Beasiswa::where('nama', 'Beasiswa Pertamina')->first();
        echo "Sebelum update: $beasiswa->nama diambil oleh
            {$beasiswa->beasiswaable->nama}";

        echo "<hr>";

        $mahasiswa = Mahasiswa::where('nama', 'Marta Quezada')->first();
        $beasiswa->beasiswaable_id = $mahasiswa->id;
        $beasiswa->push();

        $beasiswa = Beasiswa::where('nama', 'Beasiswa Pertamina')->first();
        echo "Setelah update: $beasiswa->nama diambil oleh
            {$beasiswa->beasiswaable->nama}";
    }
}
