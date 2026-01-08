@extends('layouts.limitless')

@section('title', 'Edit Barang')

@section('content')

<div class="row">
    <div class="col-md-12">
        
        {{-- Card Limitless --}}
        <div class="card">
            <div class="card-header header-elements-inline bg-white">
                <h5 class="card-title">Edit Data Barang</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('items.update', $Item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Detail Produk</legend>

                        {{-- Nama Barang --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nama Barang <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" name="name" class="form-control" value="{{ $Item->name }}" required>
                            </div>
                        </div>

                        {{-- Stok & Harga --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Stok & Harga <span class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-stack"></i></span>
                                    </span>
                                    <input type="number" name="stock" class="form-control" value="{{ $Item->stock }}" required>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </span>
                                    <input type="number" name="price" class="form-control" value="{{ $Item->price }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Deskripsi</label>
                            <div class="col-lg-10">
                                <textarea name="description" rows="3" class="form-control">{{ $Item->description }}</textarea>
                            </div>
                        </div>

                        {{-- Upload Gambar --}}
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Foto Barang</label>
                            <div class="col-lg-10">
                                {{-- Preview Foto Lama --}}
                                @if($Item->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $Item->image) }}" alt="Foto Lama" width="150" class="img-thumbnail rounded">
                                        <div class="text-muted font-size-xs mt-1">Foto saat ini</div>
                                    </div>
                                @endif

                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Ganti foto (Opsional)...</label>
                                </div>
                                <span class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto.</span>
                            </div>
                        </div>

                    </fieldset>

                    <div class="text-right">
                        <a href="{{ route('items.index') }}" class="btn btn-link">Batal</a>
                        <button type="submit" class="btn bg-primary">Update Data <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endsection