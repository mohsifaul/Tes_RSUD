<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Exports\DataExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class dataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $today = Carbon::now();
        $data = DB::table('verifikasi_koder')
            ->join('kasus', 'verifikasi_koder.kasus_id', '=', 'kasus.id')
            ->join('pasien', 'kasus.pasien_id', '=', 'pasien.id')
            ->join('icd_10', 'verifikasi_koder.icd_10', '=', 'icd_10.id')
            ->select(
                'icd_10.code_icd',
                'icd_10.long_desc',
                'pasien.gender',
                'pasien.date_of_birth',
                'kasus.krs_alasan',
            )
            // ->limit(100)
            ->get();

        $ageGroups = [
            '0-5' => [0, 5],
            '6-10' => [6, 10],
            '11-15' => [11, 15],
            '16-20' => [16, 20],
            '21-25' => [21, 25],
            '26-30' => [26, 30],
            '31-35' => [31, 35],
            '36-40' => [36, 40],
            '>=41' => [41, 50],
        ];

        $result = [];
        $krs_meninggal = ['L' => 0, 'P' => 0];  

        foreach ($data as $item) {
            $umur = Carbon::parse($item->date_of_birth)->age;
            $gender = $item->gender == 1 ? 'L' : 'P';
            $kode = $item->code_icd;
            $nama = $item->long_desc;

            if (!isset($result[$kode])) {
                $result[$kode] = [
                    'code_icd' => $kode,
                    'long_desc' => $nama,
                    'groups' => [],
                    'total' => ['L' => 0, 'P' => 0],
                    'krs_meninggal' => ['L' => 0, 'P' => 0],  
                ];
            }

            if ($item->krs_alasan == 4) {
                $result[$kode]['krs_meninggal'][$gender]++;
                $krs_meninggal[$gender]++;
            }

            foreach ($ageGroups as $label => [$min, $max]) {
                if ($umur >= $min && $umur <= $max) {
                    if (!isset($result[$kode]['groups'][$label])) {
                        $result[$kode]['groups'][$label] = ['L' => 0, 'P' => 0];
                    }

                    $result[$kode]['groups'][$label][$gender]++;
                    $result[$kode]['total'][$gender]++;
                    break;
                }
            }
        }

        return view('RS_Soal1', [
            'data' => $result,
            'ageGroups' => array_keys($ageGroups)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
