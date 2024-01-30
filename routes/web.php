<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
        return view('welcome');
})->name('login');

Route::get('/home', function(){
        return view('welcome');
})->name('login');

Route::get('/login', function(){
        return view('welcome');
})->name('login');

Route::get('/up_data', function(){
        return view('up');
});
Route::post('/up', 'Con_upload_data@store');

Route::post('/login', 'LoginController@login')->name('login');
Route::get('/logout', 'LoginController@logout')->name('logout');

//bkd
Route::group(['middleware'=> ['auth' , 'ceklevel:3']], function () {
        
        Route::get('/admin', 'AdminController@index');  

        Route::get('/admin/data_pegawai', 'AdminController@data_pegawai');        
        Route::get('/admin/edit_pegawai/', 'AdminController@edit_pegawai');    
        Route::get('/admin/data_pegawai/get_data', 'AdminController@get_data');   

        Route::get('/admin/data_terkirim', 'AdminController@data_terkirim')->name('admin.data.terkirim');       
        Route::get('/admin/detail_valid/{id}', 'AdminController@detail_valid');  

        Route::get('/admin/data_masuk', 'AdminController@data_masuk')->name('admin.data.masuk');        
        Route::get('/admin/validasi_rekon/{id}', 'AdminController@validasi_rekon');  
        
        Route::post('/admin/rekon_tolak', 'AdminController@rekon_tolak');        
        Route::post('/admin/rekon_valid', 'AdminController@rekon_valid');          

        Route::get('/admin/kill_notif/{id}', 'AdminController@notif_kill');
        Route::get('/admin/ip/', 'AdminController@getClientIps');
});

//opd
Route::group(['middleware'=> ['auth' , 'ceklevel:1']], function () {

        Route::get('/opd', function(){
                return view('opd/index');
        });

        Route::get('/opd/input_data', function(){
                return view('opd/data_input');
        });

        Route::get('/opd/detail', function(){
                return view('opd/detail_input');
        });

        Route::get('/opd/detail_revisi', function(){
                return view('opd/detail_revisi');
        });


        Route::get('/opd/detail_terkirim', function(){
                return view('opd/detail_terkirim');
        });

        
        Route::get('/opd/input_data', 'opdController@input_data')->name('opd.input.rekon');
        Route::get('/opd/lihat_data', 'opdController@lihat_data_rekon')->name('opd.lihat.rekon');  

        
        Route::post('/opd/tambah_pegawai', 'opdController@tambah_pegawai')->name('opd.tambah.pegawai');
              
        Route::get('/opd/id_pegawai/{id}', 'opdController@data_pegawai_id');
        Route::get('/opd/data_pegawai', 'opdController@data_pegawai');
        Route::put('/opd/up_pegawai', 'opdController@updatePegawai')->name('pegawai.up');
        
        Route::get('/opd/data_revisi', 'opdController@data_revisi');
        Route::get('/opd/get_pegawai', 'opdController@get_pegawai');
        Route::get('/opd/get_pegawai_opd', 'opdController@get_pegawai_opd');

        Route::post('/opd/input_data/edit_rekon/{id}/tambah_pegawai', 'opdController@edit_rekon_tambah');
        Route::get('/opd/input_data/edit_rekon/{id}', 'opdController@edit_rekon');

        
        Route::get('/opd/data_terkirim', 'opdController@data_verifikasi');
        Route::get('/opd/ambil_detail_valid/{id}', 'opdController@ambil_detail_valid');

        Route::post('/opd/input_rekon', 'opdController@input_rekon');

        Route::get('/opd/data_revisi_det', 'opdController@data_revisi');
        Route::post('/opd/data_revisi_det', 'opdController@data_revisi_det');
        Route::post('/opd/buat_data', 'opdController@buat_data');
        Route::get('/opd/kill_notif', 'opdController@notif_kill');

        Route::delete('/opd/input_data/edit_rekon/hapus_rekon/{id}', 'opdController@delete_detail_rekon');
        Route::delete('/opd/input_data/hapus_rekon/{id}', 'opdController@delete_rekon');
});

//Keuangan
Route::group(['middleware'=> ['auth' , 'ceklevel:2']], function () {

        Route::get('/keuangan', function(){
                return view('keuangan/index');
        });
        
        Route::get('/keuangan/data_masuk', 'KeuanganController@data_masuk')->name('keu.data.terkirim');       
        Route::get('/keuangan/detail_valid/{id}', 'KeuanganController@detail_valid')->name('keu.detail.masuk'); 
        Route::get('/keuangan/kill_notif/{id}', 'KeuanganController@notif_kill'); 
        
});

