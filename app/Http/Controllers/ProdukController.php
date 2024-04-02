<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProdukController extends Controller
{
    public function index(){
        $data = Produk::all();
        return view('Produk.index', compact('data'));
    }
    public function create(){
        $sessiondata = Session::get('data-produk');
        return view('Produk.add',compact('sessiondata'));
    }
    public function update($id){
        $data = Produk::find($id);
        $sessiondata = Session::get('data-produk');
        return view('Produk.edit',compact('data','sessiondata'));
    }
    public function processCreate(Request $request){
        $request->validate([
            'KodeProduk' => 'required',
            'NamaProduk' => 'required',
            'Harga' => 'required',
            'Stok' => 'required'
        ], [
            'KodeProduk' => 'Kode Produk Harus diisi',
            'NamaProduk' => 'Nama Produk Harus diisi',
            'Harga' => 'Harga Harus diisi',
            'Stok' => 'Stok Harus diisi',
        ]);
        try {
            DB::beginTransaction();
            Produk::create($request->all());
            DB::commit();
            return redirect()->route('product.index')->with(['msg' => 'Berhasil', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report ($e);
            return redirect()->route('product.add')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }
    public function processUpdate(Request $request){
        $request->validate([
            'KodeProduk' => 'required',
            'NamaProduk' => 'required',
            'Harga' => 'required',
            'Stok' => 'required'
        ], [
            'KodeProduk' => 'Kode Produk Harus diisi',
            'NamaProduk' => 'Nama Produk Harus diisi',
            'Harga' => 'Harga Harus diisi',
            'Stok' => 'Stok Harus diisi',
        ]);
        try {
            DB::beginTransaction();
            Produk::find($request->id)->update($request->except('id'));
            DB::commit();
            return redirect()->route('product.index')->with(['msg' => 'Berhasil', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report ($e);
            return redirect()->route('product.edit')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }
    public function delete($id){
        try {
            DB::beginTransaction();
            Produk::find($id)->delete();
            DB::commit();
            return redirect()->route('product.index')->with(['msg' => 'Berhasil', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            report ($e);
            return redirect()->route('product.index')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }
}
