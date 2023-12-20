<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PustakawanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // di bawah ini untuk store!!!
    // di postman pakai body yang form-data

    public function store(Request $request)
    {
        //ambil data dari postman;
        $IdPtkw = $request->id_pustakawan;
        $NamaPtkw = $request->nama_pustakawan;
        $NKP = $request->no_ktp_pustakawan;
        $NHP = $request->no_hp_pustakawan;
        $AP = $request->alamat_pustakawan;

        //memasukkan data ke database
        $inserted = DB::table('data_pustakawan')->insert(
            [
                'id_pustakawan' => $IdPtkw,
                'nama_pustakawan' => $NamaPtkw,
                'no_ktp_pustakawan' => $NKP,
                'no_hp_pustakawan' => $NHP,
                'alamat_pustakawan' => $AP
            ]
        );

        //pesan jika gagal/ berhasil
        if ($inserted) {
            return response()->json(['message' => 'Data pustakawan telah disimpan']);
        } else {
            return response()->json(['message' => 'Gagal menyimpan data pustakawan'], 500);
        }
    }

    // di bawah ini untuk get!!!
    // di postman pakai body yang form-data
    public function get()
    {

        //untuk memberikan perintah SQL
        $InsOut = DB::select('select * from data_pustakawan');

        //untuk menampilkan semua data
        return response()->json([
            'success' => true,
            'message' => 'List Semua Post',
            'data'    => $InsOut
        ], 200);
    }

    // di bawah ini buat update!!!
    // di postman pakai body yang x-www-form-urlencoded jika menggunakan put.
    // di postman pakai body-form jika menggunakan post.
    public function update(Request $request)
    {
        //mengambil data dari postman
        $id = $request->id_pustakawan;
        $IdPtkw = $request->id_pustakawan_baru;
        $NamaPtkw = $request->nama_pustakawan;
        $NKP = $request->no_ktp_pustakawan;
        $NHP = $request->no_hp_pustakawan;
        $AP = $request->alamat_pustakawan;

        //cek apakah ada datanya?
        $item = DB::table('data_pustakawan')->where('id_pustakawan', $id)->first();

        //jika tidak ketemu bukunya 
        if (!$item) {
            return response()->json(['message' => 'tidak ada pustakawan.'], 404);
        }

        //update buku di database.
        $updated = DB::table('data_pustakawan')
            ->where('id_pustakawan', $id)
            ->update([
                'id_pustakawan' => $IdPtkw,
                'nama_pustakawan' => $NamaPtkw,
                'no_ktp_pustakawan' => $NKP,
                'no_hp_pustakawan' => $NHP,
                'alamat_pustakawan' => $AP,
            ]);

        //pesan jika berhasil.
        if ($updated) {
            return response()->json(['message' => 'Data pustakawan telah diubah']);
        } else {
            return response()->json(['message' => 'Gagal mengubah data pustakawan'], 500);
        }
    }

    // di bawah ini buat hapus!!!
    // di postman pakai body yang x-www-form-urlencoded jika menggunakan put.
    // di postman pakai body-form jika menggunakan post.
    public function destroy(Request $request)
    {
        $id = $request->id_pustakawan;

        if (!$id) {
            return response()->json(['message' => 'Kunci "i d_pustakawan" tidak ditemukan.'], 400);
        }

        //cek apakah ada datanya?
        $item = DB::table('data_pustakawan')->where('id_pustakawan', $id)->first();

        //jika tidak ketemu bukunya 
        if (!$item) {
            return response()->json(['message' => 'tidak ada pustakawan.'], 404);
        }

        // hapus bukunya
        $hapus = DB::table('data_pustakawan')->where('id_pustakawan', $id)->delete();

        //respon jika berhasil diapus
        if ($hapus) {
            return response()->json(['message' => 'Data pustakawan telah dihapus']);
        } else {
            return response()->json(['message' => 'Gagal menghapus data pustakawan'], 500);
        }
    }
    //
}
