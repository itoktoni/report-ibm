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
                <th class="text-left" style="width:2%">No.</th>
                <th class="text-left" style="width:12%">No. Order</th>
                <th class="text-left" style="width:20%">No. Sales</th>
                <th class="text-left" style="width:20%">Nama Customer</th>
                <th class="text-right" style="width:10%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($preview as $data)
            <tr>
                <td data-title="No">{{ $loop->iteration }} </td>
                <td data-title="No. Order">{{ $data->jo_code ?? '' }} </td>
                <td data-title="Nama Company">{{ $data->jo_so_code ?? '' }} </td>
                <td data-title="Nama Customer">{{ $data->has_customer->name ?? '' }} </td>
                <td class="text-right" data-title="Total">{{ Helper::createRupiah($data->jo_sum_total) }} </td>
            </tr>
            @endforeach
            <tr>
                <td class="total" data-title="" colspan="4">Grand Total</td>
                <td class="total text-right" data-title="Grand Total">{{ Helper::createRupiah($preview->sum('jo_sum_total')) }}</td>
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