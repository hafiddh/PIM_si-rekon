<?php

namespace App\Http\Controllers;

use DB;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Session;
use Auth;

class opdController extends Controller
{
    public function show(){
        return view('opd.index');
    }


    public function buat_data(Request $request){
        
        $waktu = date('Y-m-d');
        $opd = $request->input('odp');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        
        $data = DB::table('rekon_id')
        ->where('kode_opd', '=', $opd)
        ->where('bulan', '=', $bulan)
        ->where('tahun', '=', $tahun)
        ->where('id', '>', 0)
        ->count();
        // dd($data);
        if($data>0){
            $request->session()->put('kon', '1');
            return back()->withStatus('Data rekon '.$bulan.' '.$tahun.' sudah ada!');            
        }else{            
            $request->session()->put('kon', '0');
            $spum_row = DB::insert("insert into rekon_id ( kode_opd, bulan, tahun ,status_rev, waktu_up) values (?,?,?,?,?)", [ $opd ,$bulan ,$tahun ,0,$waktu]);
            return back()->withStatus('Data rekon '.$bulan.' '.$tahun.' ditambahkan!');
        }
        

        
        // return view('opd.buat_data');
    }

    public function input_data(){        
        // $bulan = date('m');

        // dd($bulan);
        
        $rekon_data = DB::table('rekon_id')
            ->leftJoin('data_opd', 'rekon_id.kode_opd', '=', 'data_opd.id_opd')
            ->select('bulan','tahun','id','waktu_up','data_opd.nama_opd AS opd','status_rev')
            ->where('rekon_id.kode_opd', '=', auth()->user()->id )
            ->orderBy('waktu_up', 'desc')
            ->get();
            // dd($rekon_data);
// dd($rekon_data);
        return view('opd/input_data', ['data'=> $rekon_data]);        
    }

    public function delete_rekon(Request $request){   
            $del1 = DB::table('rekon_data')
            ->where('id_rekon', '=' , $request->id)
            ->delete();

            $del2 = DB::table('rekon_id')
            ->where('id', '=' , $request->id)
            ->delete();

            $request->session()->put('kon', '0');
            return back()->withStatus('Data rekon dihapus!');       
    }


    public function edit_rekon(Request $request){

        $id = $request->id;
        $data_rekon = DB::table('rekon_id')        
                    ->where('id', '=' , $request->id)
                    ->leftJoin('data_opd', 'rekon_id.kode_opd', '=', 'data_opd.id_opd')
                    ->get();
                    
        $data_pegawai = DB::table('data_pegawai')
                    ->select('nama_pegawai','nip_baru')
                    ->get();

        $detail_pegawai =  DB::table('rekon_data')
                            ->leftJoin('data_pegawai', 'rekon_data.nip', '=', 'data_pegawai.nip_baru')
                            ->leftjoin('data_keluarga', 'data_keluarga.nip_pegawai' , '=','data_pegawai.nip_baru')
                            ->where('rekon_data.id_rekon', $request->id)
                            ->get();
                           
        // dd($detail_pegawai);
        return view('opd/detail_input', ['id'=>$id, 'data'=> $data_rekon, 'detail_pegawai'=>$detail_pegawai ,'pegawai'=>$data_pegawai]);
    }
    
    public function edit_rekon_tambah(Request $request){
        
        $data = DB::table('rekon_data')
        ->where('nip', '=', $request->pegawai_rekon)
        ->where('id_rekon', '=', $request->id)
        ->count();
        // dd($data);
        if($data>0){
            $request->session()->put('kon', '1');
            return back()->withStatus('Data pegawai sudah ada!');            
        }else{            
            $tambah = DB::insert('insert into rekon_data (nip, id_rekon, stat) values (?, ?, ?)', [ $request->pegawai_rekon , $request->id, '0']);
            $request->session()->put('kon', '0');
            return back()->withStatus('Data pegawai ditambahkan!');
        }             
    }

    public function input_rekon(Request $request){   
                
        $rekon = DB::table('rekon_id')
        ->where('id', $request->id)
        ->get();
       

        DB::table('rekon_id')
        ->where('id', $request->id)
        ->update(['status_rev' => '1']);

        $opd = DB::table('data_opd')
                ->where('id_opd','=' , $rekon[0]->kode_opd)
                ->select('nama_opd')
                ->get();

        $opd2 = $opd[0]->nama_opd;
        $bulan = $rekon[0]->bulan;
        $tahun = $rekon[0]->tahun;

        $text = "Data Rekon OPD $opd2 bulan $bulan tahun $tahun sudah teriput";
        $nootif = DB::insert('INSERT INTO data_notifikasi (tentang, isi, id_opd, status_baca) VALUES (?,?,?,?);', 
        [$opd2, $text,  '100' , '0']);

        $request->session()->put('status', 'Data Rekon Terkirim!');
        $request->session()->put('kon', '0');
        return redirect()->back();
    }

    public function delete_detail_rekon(Request $request){   

        DB::table('rekon_data')
        ->where('id', '=' , $request->id)
        ->delete();

        $request->session()->put('kon', '0');
        return back()->withStatus('Data dihapus!');       
    }
    

    public function notif_kill(Request $request)
    {
        $id = $request->input('id');
        $rev = DB::table('data_notifikasi')
                ->where('id_opd', $id)
                ->update(['status_baca' => "1"]);

        return $id;
    }


    //pegawai

    public function get_pegawai(Request $request)
    {
        if ($request->has('q')) {
    		$cari = $request->q;
            $data = DB::table('data_pegawai')->where('nama_pegawai', 'LIKE', "%$cari%")->orWhere('nip_baru', 'LIKE', "%$cari%")->get();
    		return response()->json($data);
        }
        else {
            return response()->json(['pesan' => 'Input Kosong']);
        }
    }


    public function tambah_pegawai(Request $request)
    {
        
        date_default_timezone_set('Asia/Singapore');  
        $waktu = date('Y-m-d H:i:s');
        // dd($request->id_peg, $request->no_sk, $request->tgl_sk ,$waktu);
        $peg = DB::table('data_pegawai')
                ->where('id_pegawai', $request->id_peg)
                ->first();
        
        $opd_old = $peg->kode_opd;

                
        $ins = DB::table('pegawai_opd')->insert([
            'id_pegawai' => $request->id_peg,
            'no_sk' => $request->no_sk,
            'tgl' => $request->tgl_sk,
            'opd_old' => $opd_old,
            'opd' => auth()->user()->id,
            'tgl_pindah_sistem' => $waktu
        ]);

        
        $up = DB::table('data_pegawai')
                ->where('id_pegawai', $request->id_peg)
                ->update([
                    'kode_opd' => auth()->user()->id, 
                    'jab_tmt' =>  $request->tgl_sk
                    ]);

        $request->session()->put('kon', '0');
        $request->session()->put('status', 'Data pegawai dipindahkan!');
        return redirect()->back();
    }

    public function data_pegawai(){   
        
        $data_pegawai = DB::table('data_pegawai')->where('kode_opd','=', auth()->user()->id)->select('id_pegawai','nama_pegawai','nip_baru')->get();
        // dd($data_pegawai);
        
        return view('opd/data_pegawai', ['data_pegawai'=> $data_pegawai]);
    }

    public function data_pegawai_id($id){   
        
        $pegawai_id = DB::table('data_pegawai')
        ->where('id_pegawai','=', $id)
        ->leftjoin('data_keluarga', 'data_keluarga.nip_pegawai' , '=','data_pegawai.nip_baru')
        ->first();
       
        return response()->json($pegawai_id);
    }

    public function updatePegawai(Request $request){   
        
        $up_data = DB::table('data_pegawai')
                    ->where('id_pegawai', $request->id_pegawai)
                    ->update([
                        'nama_pegawai' => $request->nama_pegawai,
                        'nik' => $request->nik,
                        'npwp' => $request->npwp,
                        'no_hp' => $request->no_hp,
                        'jabatan' => $request->jabatan,
                    ]);
        
        $up_data2 = DB::table('data_keluarga')
                    ->where('nip_pegawai', $request->nip_baru)
                    ->update([
                        'stat_nikah'  => $request->stat_nikah,
                        'nama_ayah' => $request->nama_ayah,
                        'tgl_lhr_ayah' => $request->tgl_lhr_ayah,
                        'nama_ibu' => $request->nama_ibu,
                        'tgl_lhr_ibu' => $request->tgl_lhr_ibu,
                        'nama_p' => $request->nama_p,
                        'nip_p' => $request->nip_p,
                        'tgl_lhr_p' => $request->tgl_lhr_p,
                        'no_b_nikah' => $request->no_b_nikah,
                        'tgl_b_nikah' => $request->tgl_b_nikah,
                        'pekerjaan_p' => $request->pekerjaan_p,
                        'status_p' => $request->status_p,
                        'nama_a_1' => $request->nama_a_1,
                        'tgl_lhr_a_1' => $request->tgl_lhr_a_1,
                        'kerja_a_1' => $request->kerja_a_1,
                        'usia_a_1' => $request->usia_a_1,
                        'nama_a_2' => $request->nama_a_2,
                        'tgl_lhr_a_2' => $request->tgl_lhr_a_2,
                        'kerja_a_2' => $request->kerja_a_2,
                        'usia_a_2' => $request->usia_a_2
                    ]);
        
        return response()->json();
    }
}
