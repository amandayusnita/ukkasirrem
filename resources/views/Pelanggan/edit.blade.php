@extends('base')

@section('title', 'Pelanggan')

@section('content_header')
    <h1>Edit Pelanggan</h1>
@stop

@section('content')
    @if (session('msg'))
        <div class="alert alert-{{ session('type') ?? 'info' }}" role="alert">
            {{ session('msg') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $e)
                {{ $e }}
            @endforeach
        </div>
    @endif
    <div class="card border border-dark">
        <div class="card-header bg-dark clearfix">
            <h5 class="mb-0 float-left">
                Tambah
            </h5>
            <div class="form-actions float-right">
                <a href="{{ route('customer.index') }}" name="Find" class="btn btn-sm btn-primary" title="Back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <form action="{{ route('customer.edit-process') }}" method="post">
            <div class="card-body">
                @csrf
                <div class="row">
                    <input name="id" type="hidden" value="{{ $data->id }}" />
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input name="NamaPelanggan" value="{{ $data->NamaPelanggan }}" class="form-control" rows="6" placeholder="Masukkan">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>No Telp</label>
                            <input name="NoTelp" value="{{ $data->NoTelp }}" class="form-control" rows="6" placeholder="Masukkan">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="Alamat" class="form-control" rows="3" placeholder="Masukkan">{{ $data->Alamat }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="form-actions float-right">
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <button type="submit" class="btn btn-success" onclick="$(this).addClass('disabled');$('form').submit();">Submit</button>
                </div>
            </div>
        </form>
    </div>
@stop