<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PelangganController extends Controller
{
    public function index(){
        $data = Pelanggan::all();
        return view('Pelanggan.index', compact('data'));
    }
    public function create(){
        $sessiondata = Session::get('data-pelanggan');
        return view('Pelanggan.add',compact('sessiondata'));
    }
    public function update($id){
        $data = Pelanggan::find($id);
        $sessiondata = Session::get('data-pelanggan');
        return view('Pelanggan.edit',compact('data','sessiondata'));
    }
    public function processCreate(Request $request){
        $request->validate([
            'NamaPelanggan' => 'required',
            'NoTelp' => 'required',
            'Alamat' => 'required'
        ], [
            'NamaPelanggan' => 'Nama Pelanggan Harus diisi',
            'NoTelp' => 'No Telepon Harus diisi',
            'Alamat' => 'Alamat Harus diisi',
        ]);
        try {
            DB::beginTransaction();
            Pelanggan::create($request->all());
            DB::commit();
            return redirect()->route('customer.index')->with(['msg' => 'Berhasil', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report ($e);
            return redirect()->route('customer.add')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }
    public function processUpdate(Request $request){
        $request->validate([
            'NamaPelanggan' => 'required',
            'NoTelp' => 'required',
            'Alamat' => 'required'
        ], [
            'NamaPelanggan' => 'Nama Pelanggan Harus diisi',
            'NoTelp' => 'No Telepon Harus diisi',
            'Alamat' => 'Alamat Harus diisi',
        ]);
        try {
            DB::beginTransaction();
            Pelanggan::find($request->id)->update($request->except('id'));
            DB::commit();
            return redirect()->route('customer.index')->with(['msg' => 'Berhasil', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report ($e);
            return redirect()->route('customer.edit')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }
    public function delete($id){
        try {
            DB::beginTransaction();
            Pelanggan::find($id)->delete();
            DB::commit();
            return redirect()->route('customer.index')->with(['msg' => 'Berhasil', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report ($e);
            return redirect()->route('customer.index')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }
}
