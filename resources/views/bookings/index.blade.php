@extends('layouts.limitless')

@section('title', 'Data Pesanan')

@section('content')

<div class="card" id="live-table">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Daftar Transaksi</h5>
        <div class="header-elements">
            <div class="list-icons">
                {{-- TOMBOL BULK DELETE --}}
                <button type="button" class="btn btn-danger btn-sm" id="bulk-delete" style="display: none;">
                    <i class="icon-trash mr-2"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                </button>
                
                {{-- TOMBOL EXPORT --}}
                <a href="{{ route('bookings.export_excel') }}" class="btn btn-outline bg-success-400 text-success-800 btn-icon ml-2">
                    <i class="icon-file-excel mr-2"></i> Excel
                </a>
                <a href="{{ route('bookings.export_pdf') }}" class="btn btn-outline bg-danger-400 text-danger-800 btn-icon ml-2">
                    <i class="icon-file-pdf mr-2"></i> PDF
                </a>
            </div>
        </div>
    </div>

    <table class="table datatable-basic table-hover" id="bookings-table">
        <thead>
            <tr>
                <th width="10"><input type="checkbox" id="master-checkbox"></th>
                <th>No</th>
                <th>Penyewa</th>
                <th>Barang</th>
                <th>Harga</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
    </table>
</div>

@endsection

@section('scripts')
<script src="{{ asset('limitless/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('limitless/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        // Config DataTable
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Cari...',
                lengthMenu: '<span>Tampil:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
        });

        // Init DataTable
        var table = $('#bookings-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('bookings.index') }}',
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'user.name', name: 'user.name' },
                { data: 'item.name', name: 'item.name' },
                { data: 'item_price', name: 'item_price' }, 
                { data: 'start_date', name: 'start_date' },
                { data: 'end_date', name: 'end_date' },
                { data: 'total_price', name: 'total_price' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" }
            ],
            drawCallback: function() {
                $('#master-checkbox').prop('checked', false);
                toggleBulkButton();
                
                if($('[data-popup="tooltip"]').length) {
                    $('[data-popup="tooltip"]').tooltip();
                }
            }
        });

        // --- AUTO REFRESH DATATABLES ---
        setInterval(function() {
            table.ajax.reload(null, false); 
            console.log('Data pesanan direfresh...');
        }, 10000); 

        // --- LOGIC CHECKBOX ---
        $('#master-checkbox').on('click', function() {
            var isChecked = $(this).is(':checked');
            $('.booking-checkbox').prop('checked', isChecked);
            toggleBulkButton();
        });

        $('body').on('click', '.booking-checkbox', function() {
            if($('.booking-checkbox:checked').length == $('.booking-checkbox').length){
                $('#master-checkbox').prop('checked', true);
            } else {
                $('#master-checkbox').prop('checked', false);
            }
            toggleBulkButton();
        });

        function toggleBulkButton() {
            var totalSelected = $('.booking-checkbox:checked').length;
            $('#selected-count').text(totalSelected);
            
            if (totalSelected > 0) {
                $('#bulk-delete').fadeIn();
            } else {
                $('#bulk-delete').fadeOut();
            }
        }

        // --- LOGIC BULK DELETE ---
        $('#bulk-delete').on('click', function() {
            var ids = [];
            $('.booking-checkbox:checked').each(function() {
                ids.push($(this).val());
            });

            if (ids.length > 0) {
                Swal.fire({
                    title: 'Hapus ' + ids.length + ' data terpilih?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Semua!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('bookings.bulk_delete') }}",
                            type: "POST",
                            data: { ids: ids },
                            success: function(response) {
                                table.ajax.reload();
                                $('#master-checkbox').prop('checked', false);
                                $('#bulk-delete').hide();
                                Swal.fire('Terhapus!', response.success, 'success');
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            }
        });

        // --- LOGIC DELETE SATUAN ---
        $('body').on('click', '.delete-booking', function () {
             var id = $(this).data("id");
             Swal.fire({
                title: 'Hapus Pesanan?',
                text: "Data akan hilang permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
             }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('bookings.index') }}" + '/' + id,
                        success: function (data) {
                            table.ajax.reload();
                            Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                        }
                    });
                }
             });
        });
    });
</script>
@endsection