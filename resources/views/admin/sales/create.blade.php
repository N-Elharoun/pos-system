@extends('admin.layouts.app', [
    'pageName' => __('trans.sales'),
])

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.sales_create')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.sales.store') }}" id="main-form">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="client_id">@lang('trans.client')</label>
                                    <select
                                        name="client_id"
                                        id="client_id"
                                        class="form-control select2 @error('client_id') is-invalid @enderror">
                                        <option value="">@lang('trans.choose')</option>
                                        @foreach($clients as $client)
                                            <option
                                            @if(old('client_id') == $client->id) selected @endif
                                            value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="sale_date">@lang('trans.date')</label>
                                    <input
                                        type="date"
                                        class="form-control datepicker @error('sale_date') is-invalid @enderror"
                                        id="sale_date"
                                        value="{{ old('sale_date',date('Y-m-d')) }}"
                                        placeholder="@lang('trans.date')"
                                        name="sale_date">
                                    @error('sale_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoice_number">@lang('trans.invoice_number')</label>
                                    <input
                                        type="text"
                                        class="form-control @error('invoice_number') is-invalid @enderror"
                                        id="invoice_number"
                                        value="{{ old('invoice_number') }}"
                                        placeholder="@lang('trans.invoice_number')"
                                        name="invoice_number">
                                    @error('invoice_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="safe_id">@lang('trans.safe')</label>
                                    <select
                                        name="safe_id"
                                        id="safe_id"
                                        class="form-control select2 @error('safe_id') is-invalid @enderror">
                                        @foreach($safes as $safe)
                                            <option
                                            @if(old('safe_id') == $safe->id) selected @endif
                                            value="{{ $safe->id }}">{{ $safe->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('safe_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="item_id">@lang('trans.item')</label>
                                    <select
                                        id="item_id"
                                        class="form-control select2">
                                        <option value="">@lang('trans.choose')</option>
                                        @foreach($items as $item)
                                            <option
                                                data-price="{{$item->price}}"
                                                data-quantity="{{$item->quantity}}"
                                                value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="qty">@lang('trans.qty')</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="qty"
                                        placeholder="@lang('trans.qty')">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="notes">@lang('trans.notes')</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="notes"
                                        placeholder="@lang('trans.notes')">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <button
                                    type="button"
                                    id="add_item"
                                    class="btn btn-primary mb-2 btn-block"
                                    style="margin-top: 32px">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" style="width: 40px">#</th>
                                    <th>@lang('trans.name')</th>
                                    <th>@lang('trans.price')</th>
                                    <th>@lang('trans.qnt')</th>
                                    <th style="width: 50px" >@lang('trans.total')</th>
                                    <th>@lang('trans.notes')</th>
                                </tr>
                                <tbody id="items_list">
                                    @if(old('items'))
                                        @foreach(old('items') as $itemID => $item)
                                            <tr>
                                                <td>{{$loop->iteration }}</td>
                                                <td>{{$item['item_name']}}</td>
                                                <td>{{$item['price']}}</td>
                                                <td>{{$item['quantity']}}</td>
                                                <td>{{$item['total']}}</td>
                                                <td>{{$item['notes']}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm delete-item">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                                <input type="hidden" name="items[{{$itemID}}][item_id]" value="{{$itemID}}">
                                                <input type="hidden" name="items[{{$itemID}}][item_name]" value="{{ $item['item_name'] }}">
                                                <input type="hidden" name="items[{{$itemID}}][price]" value="{{ $item['price'] }}">
                                                <input type="hidden" name="items[{{$itemID}}][quantity]" value="{{ $item['quantity'] }}">
                                                <input type="hidden" name="items[{{$itemID}}][total]" value="{{ $item['total'] }}">
                                                <input type="hidden" name="items[{{$itemID}}][notes]" value="{{ $item['notes']}}">
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">@lang('trans.total')</th>
                                    <th id="total_price">0</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">@lang('trans.discount')</th>
                                    <th id="discount"> 0 </th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">@lang('trans.net')</th>
                                    <th id="net">0</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">@lang('trans.paid')</th>
                                    <th id="paid">0</th>
                                </tr><tr>
                                    <th colspan="4" class="text-right">@lang('trans.remaining')</th>
                                    <th id="remaining">0</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class='discount-box'>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="form-check-label" >@lang('trans.discount_type')</label>
                                    @foreach ( $discountTypes as $discountValue => $discountType )
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="{{ $discountValue }}"
                                        name="discount_type" value='{{ $discountValue }}' @if(old("discount_type",$loop->first) == $discountValue)   checked @endif>
                                        <label class="form-check-label" for="{{ $discountValue }}">{{ $discountType }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="discount-value">@lang('trans.discount_value')</label>
                                        <input
                                            type="text"
                                            class="form-control datepicker @error('discount_value') is-invalid @enderror"
                                            id="discount-value"
                                            name="discount_value"
                                            value="{{ old('discount_value') }}"
                                            placeholder="@lang('trans.discount_value')">
                                        @error('discount_value')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='payment-type'>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="form-check-label" >@lang('trans.payment_type')</label>
                                    @foreach ( $paymentTypes as $paymentValue => $paymentType )
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="payment_type{{ $paymentValue }}"
                                        name="payment_type" value='{{ $paymentValue }}' @if(old("payment_type",$loop->first) == $paymentValue)   checked @endif>
                                        <label class="form-check-label" for="payment_type{{ $paymentValue }}">{{ $paymentType }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="payment-value">@lang('trans.payment_amount')</label>
                                        <input
                                            type="text"
                                            class="form-control datepicker @error('payment_amount') is-invalid @enderror"
                                            id="payment-amount"
                                            name="payment_amount"
                                            value="{{ old('payment_amount') }}"
                                            placeholder="@lang('trans.payment_amount')">
                                        @error('payment_amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <x-form-submit text="Create"></x-form-submit>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('js')
    <script>
        var counter = 1
        var totalPrice = 0;
        $("#add_item").on('click', function (e) {
            e.preventDefault();
            let item = $("#item_id");
            let itemID = item.val();
            let selectedItem = $("#item_id option:selected");
            let itemName = selectedItem.text()
            let itemPrice = selectedItem.data('price');
            let qnt = $("#qty")
            var itemQty = qnt.val();
            let notes = $("#notes")
            let itemNotes = notes.val();
            let itemTotal = Math.round((itemPrice * itemQty) * 100) / 100;
            console.log(itemTotal)

            // validate inputs : item chosen , qnt , qnt > 0 , qnt <= available qnt
            if (!itemID) {
                // sweelalet error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please choose an item',
                })
                return;
            }
            if (!itemQty || itemQty <= 0 || itemQty > selectedItem.data('quantity')) {
                // sweelalet error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter a valid quantity',
                })
                return;
            }
           $("#items_list").append(`
                <tr>
                    <td>${counter}</td>
                    <td>${itemName}</td>
                    <td>${itemPrice}</td>
                    <td>${itemQty}</td>
                    <td>${itemTotal}</td>
                    <td>${itemNotes}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-item">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                    <input type="hidden" name="items[${itemID}][item_id]" value="${itemID}">
                    <input type="hidden" name="items[${itemID}][item_name]" value="${itemName}">
                    <input type="hidden" name="items[${itemID}][price]" value="${itemPrice}">
                    <input type="hidden" name="items[${itemID}][quantity]" value="${itemQty}">
                    <input type="hidden" name="items[${itemID}][total]" value="${itemTotal}">
                    <input type="hidden" name="items[${itemID}][notes]" value="${itemNotes}">
                </tr>
            `);
            counter++

            totalPrice = Math.round((totalPrice + itemTotal) * 100 ) / 100;
            $("#total_price").text(totalPrice);
            calculateDiscount();
            item.val("").trigger('change')
            qnt.val("")
            notes.val("")
            
        });
            // Delete item
        $(document).on('click', '.delete-item', function () {
            let row = $(this).closest('tr');
            let rowTotal = parseFloat(row.find('td:eq(4)').text()) || 0;

            // Update totals
            totalPrice = Math.round((totalPrice - rowTotal) * 100) / 100;
            $("#total_price").text(totalPrice.toFixed(2));

            // Remove row
            row.remove();

            // Re-number rows
            $("#items_list tr").each(function (index) {
                $(this).find('td:first').text(index + 1);
            });

            calculateDiscount();
        });
        //  Discount Calculator Function
        function calculateDiscount() {
            let discountType = $("input[name='discount_type']:checked").val();
            let discountValue = parseFloat($("#discount-value").val()) || 0;
            let total = parseFloat($("#total_price").text()) || 0;
            let discountAmount = 0;
            let net = 0;

            if (discountType === '{{ App\Enums\DiscountTypeEnum::Percentage->value }}') {
                if (discountValue > 100) {
                    discountValue = 100;
                    $("#discount-value").val(100);
                }
                discountAmount = Math.round(((discountValue / 100) * total)* 100) / 100;
            } else if (discountType ==='{{ App\Enums\DiscountTypeEnum::Fixed->value}}') {
                discountAmount = discountValue;
                if (discountAmount > total) discountAmount = total;
            }

            net = Math.round((total - discountAmount) * 100) / 100;

            $("#discount").text(discountAmount);
            $("#net").text(net);

            calculateRemaining();

        }
        $("#discount-value").on('input', calculateDiscount);
        $("input[name='discount_type']").on('change', calculateDiscount);
        
        $(document).ready(function() {
        // Calculate total from old data if any
            let totalFromOld = 0;
            $("#items_list tr").each(function() {
                let totalCell = parseFloat($(this).find('td:eq(4)').text()) || 0;
                totalFromOld += totalCell;
            });
            totalPrice = Math.round(totalFromOld * 100) / 100;
            $("#total_price").text(totalPrice);
            calculateDiscount();
        });
        //  Payment Calculator Function
        function calculateRemaining() {
            //  Read values
            const paymentType = $("input[name='payment_type']:checked").val();
            const net = parseFloat($("#net").text()) || 0;
            let paid = parseFloat($("#payment-amount").val()) || 0;

            //  Handle payment type
            if (paymentType == '{{ App\Enums\paymentTypeEnum::Cash->value}}') {
                // For cash: pay full amount and lock input
                paid = net;
                $("#payment-amount").val(0).prop('readonly', true);
            } else if (paymentType == '{{ App\Enums\paymentTypeEnum::Debt->value}}') {
                // For debt: allow partial payment
                $("#payment-amount").prop('readonly', false);
                if (paid > net) paid = net; // Prevent overpayment
            }

            //  Calculate remaining
            let remaining = Math.round((net - paid) * 100) / 100;
            if (remaining < 0) remaining = 0;

            //  Update table display
            $("#paid").text(paid);
            $("#remaining").text(remaining);
        }


        // Trigger when payment type changes
        $("input[name='payment_type']").on("change", calculateRemaining);

        // Trigger when payment amount changes
        $("#payment-amount").on("input", calculateRemaining);



    </script>
@endpush