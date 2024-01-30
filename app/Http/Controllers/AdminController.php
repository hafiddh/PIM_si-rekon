<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\pegawaiModel;
use DataTables;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekonExport;

class AdminController extends Controller
{
    
    public function index(){
        return view('admin/index');
    }


    public function data_pegawai(){
              
        return view('admin/data_pegawai');
    }

    public function get_data(Request $request){
        $pegawai = DB::table('data_pegawai')
                ->leftJoin('data_opd', 'data_pegawai.kode_opd', '=', 'data_opd.id_opd')
                ->select('data_pegawai.id_pegawai', 'data_pegawai.nip_baru', 'data_pegawai.nama_pegawai', 'data_opd.nama_opd')
                ->get();
        

        return Datatables::of($pegawai)->make();                        
    }

    public function edit_pegawai(Request $request){
        $request->id;
        return $request->id;             
    }
         
    public function notif_kill(Request $request)
    {
        // dd($request->id);

        DB::table('data_notifikasi')
                ->where('id', $request->id)
                ->update(['status_baca' => "1"]);

                $rekon_data = DB::table('rekon_id')
                ->leftJoin('data_opd', 'rekon_id.kode_opd', '=', 'data_opd.id_opd')
                ->select('bulan','tahun','id','waktu_up','data_opd.nama_opd AS opd','status_rev')
                ->where('status_rev', '1')
                ->orderBy('waktu_up', 'desc')
                ->get();
    
            return view('admin/data_masuk', ['data'=> $rekon_data]);
    }

    public function data_masuk(){

        $rekon_data = DB::table('rekon_id')
            ->leftJoin('data_opd', 'rekon_id.kode_opd', '=', 'data_opd.id_opd')
            ->select('bulan','tahun','id','waktu_up','data_opd.nama_opd AS opd','status_rev')
            ->where('status_rev', '1')
            ->orderBy('waktu_up', 'desc')
            ->get();

        return view('admin/data_masuk', ['data'=> $rekon_data]);
    }

    public function validasi_rekon(Request $request){

        // dd('lol');
        $id = $request->id;

        // dd($id);
        $data_rekon = DB::table('rekon_id')        
                    ->where('id', '=' , $request->id)
                    ->leftJoin('data_opd', 'rekon_id.kode_opd', '=', 'data_opd.id_opd')
                    ->first();

        $bulan = $data_rekon->bulan;
        $tahun = $data_rekon->tahun;
        $tahun_num = $tahun;
        if($bulan == 'Januari'){            
            $tahun_num = $tahun-1;
            $bulan_num = 'Desember';
        }else if($bulan == 'Februari'){
            $bulan_num = 'Januari';
        }else if($bulan == 'Maret'){
            $bulan_num = 'Februari';
        }else if($bulan == 'April'){
            $bulan_num = 'Maret';
        }else if($bulan == 'Mei'){
            $bulan_num = 'April';
        }else if($bulan == 'Juni'){
            $bulan_num = 'Mei';
        }else if($bulan == 'Juli'){
            $bulan_num = 'Juni';
        }else if($bulan == 'Agustus'){
            $bulan_num = 'Juli';
        }else if($bulan == 'September'){
            $bulan_num = 'Agustus';
        }else if($bulan == 'Oktober'){
            $bulan_num = 'September';
        }else if($bulan == 'November'){
            $bulan_num = 'Oktober';
        }else if($bulan == 'Desember'){
            $bulan_num = 'November';
        }        
        
        $data_pegawai = DB::table('data_pegawai')
                    ->select('nama_pegawai','nip_baru')
                    ->get();

        $detail_pegawai =  DB::table('rekon_data')
                            ->leftJoin('data_pegawai', 'rekon_data.nip', '=', 'data_pegawai.nip_baru')
                            ->leftjoin('data_keluarga', 'data_keluarga.nip_pegawai' , '=','data_pegawai.nip_baru')
                            ->where('rekon_data.id_rekon', $request->id)
                            ->get();


        //VALIDASI

        $rekon_old = DB::table('rekon_id')        
                            ->where('kode_opd', '=' , $data_rekon->id_opd)
                            ->where('bulan', '=' , $bulan_num)
                            ->where('tahun', '=' , $tahun_num)
                            ->first();
                            // dd($bulan_num, $tahun_num);
        

        $data_rekon_old =  DB::table('rekon_data')
                            ->leftJoin('data_pegawai', 'rekon_data.nip', '=', 'data_pegawai.nip_baru')
                            ->where('rekon_data.id_rekon', $rekon_old->id)
                            ->get();
        
        $det_valid = DB::select('select T2.* from rekon_data as T2 where id_rekon = ? and not exists (select * from rekon_data as T1 where id_rekon = ? AND T1.nip = T2.nip)', [$data_rekon->id , $rekon_old->id]);
        
        $det_valid2 = DB::select('select T2.* from rekon_data as T2 where id_rekon = ? and not exists (select * from rekon_data as T1 where id_rekon = ? AND T1.nip = T2.nip)', [$rekon_old->id , $data_rekon->id]);

        // if($det_valid != null){
        //     dd('1');
        // }else{
        //     dd('2');
        // }
        // $det_pindah = DB::table('pegawai_opd')
        //                     ->leftJoin('data_pegawai', 'pegawai_opd.id_pegawai', '=', 'data_pegawai.id_pegawai')
        //                     ->where('data_pegawai.nip_baru', $det_valid[0]->nip)
        //                     ->orderBy('tgl', 'desc')
        //                     ->first();
        foreach ($det_valid as $lol ) {            
            DB::table('rekon_data')
            ->where('nip', $lol->nip)
            ->update(['stat' => '1']);
        }

        return view('admin/detail_masuk', ['id'=>$id, 'data'=> $data_rekon, 'detail_pegawai'=>$detail_pegawai ,'pegawai'=>$data_pegawai ,'det_valid' => $det_valid, 'det_valid2' => $det_valid2]);
    }

    
    public function rekon_tolak(Request $request){
        $id = $request->id;
        $text = $request->t_revisi;
        
        // dd($id, $text);
        DB::table('rekon_id')
        ->where('id', $id)
        ->update([
            'status_rev' => '3',
            'keterangan_rev' => $text
        ]);
        
        $rekon = DB::table('rekon_id')
        ->where('id', $id )->get();
                
        $bulan = $rekon[0]->bulan;
        $tahun = $rekon[0]->tahun;
        $kode_opd =  $rekon[0]->kode_opd;
        
        $text = "Data Rekon bulan $bulan tahun $tahun ditolak, silakan periksa kembali!";
        $nootif = DB::insert('INSERT INTO data_notifikasi (tentang, isi, id_opd, status_baca) VALUES (?,?,?,?);', 
        ['Data Rekon ditolak', $text,  $kode_opd , '0']);

        $request->session()->put('kon', '0');
        $request->session()->put('status', 'Data dikembalikan untuk diubah!');
        return redirect()->route('admin.data.masuk');
    }

    
    public function rekon_valid(Request $request){
        
        $id = $request->id;
        


        // dd($id);
        DB::table('rekon_id')
        ->where('id', $id)
        ->update(['status_rev' => '2']);
        
        $rekon = DB::table('rekon_id')
        ->where('id', $id )->get();
        
        $opd = DB::table('data_opd')
                ->where('id_opd','=' , $rekon[0]->kode_opd)
                ->select('nama_opd')
                ->get();
        
        $rekon = DB::table('rekon_id')
        ->where('id', $id )->get();        
        
        $bulan = $rekon[0]->bulan;
        $tahun = $rekon[0]->tahun;
        $kode_opd =  $rekon[0]->kode_opd;
        $opd2 = $opd[0]->nama_opd;
        
        $text = "Data Rekon OPD $opd2 bulan $bulan tahun $tahun sudah divalidasi. ";
        $nootif = DB::insert('INSERT INTO data_notifikasi (tentang, isi, id_opd, status_baca) VALUES (?,?,?,?);', 
        [$opd2 , $text,  '101' , '0']);
        
        $text3 = "DATA REKON TERVALIDASI";
        $text2 = "Data Rekon bulan $bulan tahun $tahun sudah divalidasi. Terima kasih telah melakukan rekon data.";
        $nootif = DB::insert('INSERT INTO data_notifikasi (tentang, isi, id_opd, status_baca) VALUES (?,?,?,?);', 
        [$text3 , $text2,  $kode_opd , '0']);

        $request->session()->put('kon', '0');
        $request->session()->put('status', 'Data diteruskan ke Keuangan!');
        return redirect()->route('admin.data.terkirim');
    }


    public function data_terkirim(){

        $rekon_data = DB::table('rekon_id')
            ->leftJoin('data_opd', 'rekon_id.kode_opd', '=', 'data_opd.id_opd')
            ->select('bulan','tahun','id','waktu_up','data_opd.nama_opd AS opd','status_rev')
            ->where('status_rev', '2')
            ->orderBy('waktu_up', 'desc')
            ->get();

        return view('admin/data_valid', ['data'=> $rekon_data]);
    }

    
    public function detail_valid(Request $request){

        $id = $request->id;

        // dd($id);
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
                           
        // dd($data_rekon);
        return view('admin/detail_valid', ['id'=>$id, 'data'=> $data_rekon, 'detail_pegawai'=>$detail_pegawai ,'pegawai'=>$data_pegawai]);
    }



    public function getClientIps()
    {
        $clientIP = \Request::getClientIp(true);
        dd($clientIP);
    } 
    

}
