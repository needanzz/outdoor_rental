@extends('layouts.limitless')

@section('title', 'Tambah Barang Baru')

@section('content')

<div class="row">
    <div class="col-md-12">
        
        {{-- Card Limitless --}}
        <div class="card">
            <div class="card-header header-elements-inline bg-white">
                <h5 class="card-title">Form Input Barang</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <p class="mb-4">Silakan isi detail barang yang akan disewakan. Pastikan gambar berukuran proporsional.</p>

                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Detail Produk</legend>

                        {{-- Nama Barang --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nama Barang <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Tenda Dome 4 Orang" required>
                            </div>
                        </div>

                        {{-- Stok & Harga (Dibuat sebelahan biar rapi) --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Stok & Harga <span class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-stack"></i></span>
                                    </span>
                                    <input type="number" name="stock" class="form-control" placeholder="Jumlah Stok" required>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </span>
                                    <input type="number" name="price" class="form-control" placeholder="Harga Sewa per Hari" required>
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Deskripsi</label>
                            <div class="col-lg-10">
                                <textarea name="description" rows="3" class="form-control" placeholder="Kondisi barang, kelengkapan, dll..."></textarea>
                            </div>
                        </div>

                        {{-- Upload Gambar --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Foto Barang</label>
                            <div class="col-lg-10">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Pilih file gambar...</label>
                                </div>
                                <span class="form-text text-muted">Format: jpg, png, jpeg.</span>
                            </div>
                        </div>

                    </fieldset>

                    <div class="text-right">
                        <a href="{{ route('items.index') }}" class="btn btn-link">Kembali</a>
                        <button type="submit" class="btn bg-primary">Simpan Data <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
        {{-- /card limitless --}}

    </div>
</div>

@endsection

@section('scripts')
<script>
    // Script kecil biar nama file muncul saat dipilih
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endsection