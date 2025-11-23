<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice # {{ $sale->invoice_number }}</title>
   <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, 
        table td {
            border: 1px solid #000 !important;
            padding: 6px;
        }

        @media print {
            table th,
            table td {
                border: 1px solid #000 !important;
            }
        }
    </style>

</head>
<body>

    {{-- Header --}}
    <div class="header" style="
    display: flex;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 10px;
    border-bottom: 2px solid #ddd;
">

    {{-- Logo --}}
    <div style="margin-right: 20px;">
        <img src="{{ asset('storage/' . $company->company_logo) }}"
            alt="Logo"
            style="height: 80px; object-fit: contain;">
    </div>

    {{-- Company Info --}}
    <div style="text-align: left;">
        <h2 style="margin: 0; font-size: 24px;">{{ $company->company_name }}</h2>
        <p style="margin: 3px 0;">Email: {{ $company->company_email }}</p>
        <p style="margin: 3px 0;">Phone: {{ $company->company_phone }}</p>
    </div>

</div>


    <h3>Invoice # {{ $sale->invoice_number }}</h3>
    <p>Date: {{ $sale->sale_date}}</p>
    <p>Customer: {{ $sale->client?->name ?? 'Walk-in Customer' }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sale->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->pivot->quantity }}</td>
                <td>{{ $item->price }}</td>
                <td>{{$item->pivot->quantity * $item->price}}</td>
            </tr>
        @endforeach
        <script>
            window.onload = function () {
                // Auto open print dialog
                window.print();

                // After printing → redirect back to Create Sale page
                window.onafterprint = function () {
                    window.location.href = "{{ route('admin.sales.create') }}";
                };
            };
        </script>

        </tbody>
    </table>

    <h3 class="total">Total: {{$sale->total }}</h3>
    <h3 class="total">Discout: {{$sale->discount_value }}</h3>
    <h3 class="total">Net: {{$sale->net_amount }}</h3>
    <h3 class="total">Paid: {{$sale->paid_amount }}</h3>
    <h3 class="total">Remaining: {{$sale->remaining_amount }}</h3>

</body>
</html>
