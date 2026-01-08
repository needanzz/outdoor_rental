@extends('layouts.limitless')

@section('title', 'Kelola Barang')

@section('content')

<div class="card">
    {{-- HEADER & TOMBOL TAMBAH --}}
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Stok Barang Rental</h5>
        <div class="header-elements">
            <a href="{{ route('items.create') }}" class="btn bg-blue-400 btn-labeled btn-labeled-left rounded-round">
                <b><i class="icon-plus3"></i></b> Tambah Barang
            </a>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <table class="table datatable-basic table-hover" id="items-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Harga / Hari</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        {{-- Body kosong karena akan diisi oleh AJAX DataTables --}}
        <tbody></tbody>
    </table>
</div>

@endsection

@section('scripts')
{{-- 1. Plugin DataTables Limitless --}}
<script src="{{ asset('limitless/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('limitless/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>

{{-- 2. Plugin SweetAlert2 (Ambil dari CDN biar praktis & pasti jalan) --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Cari barang...',
                lengthMenu: '<span>Tampil:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
        });

        var table = $('#items-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('items.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'stock', name: 'stock' },
                { data: 'price', name: 'price' },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false, 
                    className: "text-center" 
                }
            ]
        });

        // --- LOGIKA DELETE DENGAN SWEETALERT ---
        $('body').on('click', '.delete-item', function () {
            var id = $(this).data("id");
            
            Swal.fire({
                title: 'Yakin mau hapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('items.index') }}" + '/' + id,
                        success: function (data) {
                            table.ajax.reload();
                            Swal.fire(
                                'Terhapus!',
                                'Data barang berhasil dihapus.',
                                'success'
                            );
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endsection