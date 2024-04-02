<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PenjualanController extends Controller
{
    public function index(){
        if(Auth::user()->level == 'admin'){
            $filter = Session::get('filter');
            $data = Penjualan::all()
            ->where('TglPenjualan', '>=', ($filter['start_date'] ?? date('Y-m-d')))
            ->where('TglPenjualan', '<=', ($filter['end_date'] ?? date('Y-m-d')));
            return view('Penjualan.index',compact('filter','data'));
        } else{
            Session::forget('data-penjualan');
            $data = Penjualan::all();
            return view('Penjualan.index', compact('data'));
        }
    }
    public function create(){
        $produk = Produk::get()->pluck('NamaProduk', 'id');
        $pelanggan = Pelanggan::get()->pluck('NamaPelanggan', 'id');
        $sessiondata = Session::get('data-penjualan');
        return view('Penjualan.add',compact('produk','pelanggan','sessiondata'));
    }
    public function processCreate(Request $request){
        $item = Session::get('data-penjualan');
        try {
            DB::beginTransaction();

            $sales = Penjualan::create([
                'KodePenjualan' => $request->KodePenjualan,
                'TglPenjualan' => Carbon::now()->format('Y-m-d'),
                'TotalHarga' => $request->TotalHarga,
                'user_id' => Auth::user()->id,
                'pelanggan_id' => $request->pelanggan_id,
                'bayar' => $request->bayar
            ]);
            
            foreach ($item as $k => $v){
                $itm = Produk::find($k);
                $itm->Stok = ($itm->Stok-$v[0]);
                $itm->save();
                
                $sales->detail()->create([
                    'penjualan_id' => $request->penjualan_id,
                    'KodePenjualan' => $request->KodePenjualan,
                    'produk_id' => $k,
                    'JumlahProduk' => $v[0],
                    'SubTotal' => ($v[0]*$itm->Harga)
                ]);
                DB::commit();
                return redirect()->route('sales.index')->with(['msg' => 'Berhasil', 'type' => 'successs']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('sales.add')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }
    public function addSalesItem(Request $request){
        $data = collect(Session::get('data-penjualan'));
        $prd = Produk::find($request->id);
        $data = $data->put($request->id, [($request->qty??1), $prd->Harga]);
        Session::put('data-penjualan', $data->toArray());
        return redirect()->route('sales.add');
    }
    public function deleteSalesItem($id){
        $data = collect(Session::get('data-penjualan'));
        $data = $data->forget($id);
        Session::put('data-penjualan', $data->toArray());
        return redirect()->route('sales.add');
    }
    public function detailSales($id){
        $sessiondata = Session::get('data-penjualan');
        $produk = Produk::get()->pluck('NamaProduk', 'id');
        $pelanggan = Pelanggan::get()->pluck('NamaPelanggan', 'id');
        $penjualan = Penjualan::with('detail.produk', 'pelanggan')->find($id);
        return view('Penjualan.detail', compact('sessiondata','produk','pelanggan','penjualan'));
    }
    public function delete($id){
        try {
            DB::beginTransaction();

            $pjl = Penjualan::with('detail')->find($id);

            foreach ($pjl as $key => $value) {
                $itm = Produk::find($value->produk_id);
                $itm->Stok = ($itm->Stok+$value->JumlahProduk);
                $itm->save();
            }

            $pjl->delete();

            DB::commit();
            return redirect()->route('sales.index')->with(['msg' => 'Berhasil', 'type' => 'successs']);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return redirect()->route('sales.index')->with(['msg' => 'Gagal', 'type' => 'danger']);
        }
    }
    public function printStruk($id){
        $penjualan = Penjualan::with('detail.produk', 'pelanggan')->find($id);
        return view('Penjualan.printStruk', compact('penjualan'));
    }
    public function filter(Request $request){
        $filter = Session::get('data-penjualan');
        $filter['start_date'] = $request->start_date;
        $filter['end_date'] = $request->end_date;
        Session::put('filter', $filter);
        return redirect()->route('sales.index');
    }
    public function resetFilter(){
        Session::forget('start_date');
        Session::forget('end_date');
        return redirect()->route('sales.index');
    }
}
