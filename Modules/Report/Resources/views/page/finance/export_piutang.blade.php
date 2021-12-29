<div class="export">

    <table id="header">
        <tr>
            <td>
                REKAP TOTAL ORDER
            </td>
        </tr>

        <tr>
            <td>
                Tanggal Cetak : {{ date('d / m / Y') }}
            </td>
        </tr>
    </table>

    <table id="datatable" class="responsive table table-no-more table-bordered table-striped mb-none">
        <thead>
            <tr>
                <th class="text-left" style="width:3%">No</th>
                <th class="text-left" style="width:20%">Nama Me</th>
                <th class="text-left" style="width:12%">No. SO</th>
                <th class="text-left" style="width:12%">Tanggal SO</th>
                <th class="text-left" style="width:20%">Nama Customer</th>
                <th class="text-left" style="width:40%">Item Barang</th>
                <th class="text-right" style="width:12%">Status</th>
                <th class="text-right" style="width:10%">Tgl Bayar</th>
                <th class="text-right" style="width:10%">Nominal</th>
                <th class="text-right" style="width:10%">Pembayaran</th>
                <th class="text-right" style="width:10%">Tagihan</th>
            </tr>
        </thead>
        <tbody>

        @php
            $sum_pembayaran = $sum_outstanding = $sum_harga = 0;
            $barang = $tgl_bayar = '';
            @endphp
            @foreach($preview as $data)

            @php
            $total_pembayaran = $total_outstanding = $total_harga = 0;
            $pembayaran = $data->has_payment ?? false;
            
            $has_detail = $data->has_detail ?? false;
            if($has_detail){
                
                foreach($has_detail as $detail){
                    $total_detail = $detail->qty_prepare * $detail->price_prepare;
                    $total_harga = $total_harga + $total_detail;
                    $barang = $barang.' ,'.$detail->has_product->product_name;
                }
            }

            if($pembayaran){
                $total_pembayaran = $pembayaran->sum('approve_amount');
                $sum_pembayaran = $sum_pembayaran + $total_pembayaran;
                $tgl_bayar = $pembayaran->sortBy(['payment_date' => 'desc'])->first()->payment_date ?? '';
            }

            $total_outstanding = $total_pembayaran - $total_harga;
            $sum_outstanding = $sum_outstanding + $total_outstanding;
            $sum_harga = $sum_harga + $total_harga;
            @endphp

            <tr>
                <td data-title="No">{{ $loop->iteration }} </td>
                <td data-title="Nama Customer">{{ $data->has_sales->mask_name ?? '' }} </td>
                <td data-title="No. Order">{{ $data->order_id ?? '' }} </td>
                <td data-title="Tanggal">{{ $data->order_date ?? '' }} </td>
                <td data-title="Nama Company">{{ $data->has_customer->mask_name ?? '' }} </td>
                <td data-title="Item Barang">{!! $barang ?? '' !!} </td>
                <td class="text-right" data-title="Status">{{ $data->order_status }} </td>
                <td data-title="Tgl Pembayaran">{{ $tgl_bayar ?? '' }} </td>
                <td class="text-right" data-title="Total">{{ Helper::createRupiah($total_harga) }} </td>
                <td class="text-right" data-title="Pembayaran">{{ Helper::createRupiah($total_pembayaran) }} </td>
                <td class="text-right" data-title="Outstanding">{{ Helper::createRupiah($total_outstanding) }} </td>
            </tr>
            @endforeach
            <tr>
                <td class="total" data-title="" colspan="8">Grand Total</td>
                <td class="total text-right" data-title="Grand Total">{{ Helper::createRupiah($sum_harga) }}</td>
                <td class="total text-right" data-title="Total Pembayaran">{{ Helper::createRupiah($sum_pembayaran) }}</td>
                <td class="total text-right" data-title="Total Outstanding">{{ Helper::createRupiah($sum_outstanding) }}</td>
            </tr>
        </tbody>
    </table>
</div>


<style>
    .export {
        width: 100%;
    }

    #header {
        margin-bottom: 20px;
        font-weight: bold;
        width: 30%;
    }

    .text-right {
        text-align: right;
    }

    .text-left {
        text-align: left;
    }

    #datatable {
        width: 100%;
        position: relative;
    }

    table tbody tr td {
        padding: 10px 5px !important;
        border: 1px solid lightgray;
    }

    table thead tr th {
        border: 1px solid gray;
        padding: 10px 5px !important;
        font-weight: bold;
    }

    .total {
        font-weight: bold;
        color: #fff;
        background-color: grey;
    }
</style>