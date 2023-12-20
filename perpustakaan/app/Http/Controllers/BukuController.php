<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BukuController extends Controller
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

    public function store(Request $request){
        //ambil data dari postman;
        $IdBuku = $request->id_buku;
        $JudulBuku = $request->judul_buku;
        $Penulis = $request->penulis;
        $Penerbit = $request->penerbit;
        $ThnTerbit = $request->tahun_terbit; 
        $JmlHal = $request->jumlah_halaman;
        $Ktgr = $request->kategori;
        $Stk = $request->stok;

        //memasukkan data ke database
        $inserted = DB::table('buku')->insert([
            'id_buku' => $IdBuku, 
            'judul_buku' => $JudulBuku, 
            'penulis' => $Penulis, 
            'penerbit' => $Penerbit, 
            'tahun_terbit' => $ThnTerbit, 
            'jumlah_halaman' => $JmlHal,
            'kategori' => $Ktgr,
            'stok' => $Stk]
        );

        //pesan jika gagal/ berhasil
        if ($inserted) {
            return response()->json(['message' => 'Data buku telah disimpan']);
        } else {
            return response()->json(['message' => 'Gagal menyimpan data buku'], 500);
        }
    }

    // di bawah ini untuk get json!!!
    // di postman pakai body yang form-data
    public function get(){
        $InsOut = DB::select('select * from buku');

        return response()->json([
            'success' => true,
            'message' => 'List Semua Post',
            'data'    => $InsOut
        ], 200);
        
    }

    // di bawah ini untuk get xml!!!
    // di postman pakai body yang form-data
    public function getx(){

        //untuk memberikan perintah SQL
        $InsOut = DB::select('select * from buku');

        $InsOutArray = json_decode(json_encode($InsOut), true);

        //untuk menampilkan semua data
        $json = [
            'success' => true,
            'message' =>'List Semua Post',
            'data'    => $InsOutArray
        ]; 

        // Mengonversi JSON ke XML
        $xml = new \SimpleXMLElement('<root/>');
        $this->arrayToXml($json, $xml);

        // Mengembalikan response XML
        $response = response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml')
            //editan di bawah untuk tampilkan ke open API
            ->header('Access-Control-Allow-Origin', '*');

        return $response;

        /*return response()->json([
            'success' => true,
            'message' =>'List Semua Post',
            'data'    => $InsOut
        ], 200);*/
    }

    private function arrayToXml($array, &$xml){
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

    // di bawah ini buat update!!!
    // di postman pakai body yang x-www-form-urlencoded jika menggunakan put.
    // di postman pakai body-form jika menggunakan post.

    public function update(Request $request)
    {
        //mengambil data dari postman
        $id = $request->id_buku;
        $IdBuku = $request->id_buku_baru;
        $JudulBuku = $request->judul_buku;
        $Penulis = $request->penulis;
        $Penerbit = $request->penerbit;
        $ThnTerbit = $request->tahun_terbit; 
        $JmlHal = $request->jumlah_halaman;
        $Ktgr = $request->kategori;
        $Stk = $request->stok;

        //update buku di database.
        $updated = DB::table('buku')
                    ->where('id_buku', $id)
                    ->update ([
                        'id_buku' => $IdBuku, 
                        'judul_buku' => $JudulBuku, 
                        'penulis' => $Penulis, 
                        'penerbit' => $Penerbit, 
                        'tahun_terbit' => $ThnTerbit, 
                        'jumlah_halaman' => $JmlHal,
                        'kategori' => $Ktgr,
                        'stok' => $Stk,
                    ]);

        //pesan jika berhasil.
        if ($updated) {
            return response()->json(['message' => 'Data buku telah diubah']);
        } else {
            return response()->json(['message' => 'Gagal mengubah data buku'], 500);
        }
    }

    // di bawah ini buat hapus!!!
    // di postman pakai body yang x-www-form-urlencoded jika menggunakan put.
    // di postman pakai body-form jika menggunakan post.
    public function destroy(Request $request){
        $id = $request->id_buku;

        //cek apakah ada datanya?
        $item = DB::table('buku')->where('id_buku', $id)->first();

        //jika tidak ketemu bukunya 
        if (!$item) {
            return response()->json(['message' => 'tidak ada buku.'], 404);
        }

        // hapus bukunya
        $hapus = DB::table('buku')->where('id_buku', $id)->delete();

        //respon jika berhasil diapus
        if ($hapus) {
            return response()->json(['message' => 'Data buku telah dihapus']);
        } else {
            return response()->json(['message' => 'Gagal menghapus data buku'], 500);
        }
    }
    //
}
