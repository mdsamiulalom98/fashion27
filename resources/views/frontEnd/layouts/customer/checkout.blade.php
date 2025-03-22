@extends('frontEnd.layouts.master') @section('title', 'Customer Checkout') @push('css')
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/select2.min.css') }}" />
@endpush @section('content')
<section class="chheckout-section">
    @php
        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
        $coupon = Session::get('coupon_amount') ? Session::get('coupon_amount') : 0;
        $discount = Session::get('discount') ? Session::get('discount') : 0;
        $cart = Cart::instance('shopping')->content();
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-5 cus-order-2">
                <div class="checkout-form-container">

                    <div class="checkout-shipping">
                        <form action="{{ route('customer.ordersave') }}" id="orderSave" method="POST"
                            data-parsley-validate="">
                            @csrf
                            <div class="checkout-card">
                                <div class="checkout-header">
                                    <h6 class="check-position">ক্যাশ অন ডেলিভারিতে অর্ডার করতে আপনার তথ্য দিন</h6>
                                </div>
                                <div class="checkout-body">
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <div class="form-group checkout-input-box mb-3">
                                                <label for="name"> নামঃ *</label>
                                                <input type="text" id="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    name="name" value="{{ old('name') }}"
                                                    placeholder="আপনার নাম লিখুন" required />
                                                <i class="fa-solid fa-user"></i>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-12">
                                            <div class="form-group checkout-input-box mb-3">
                                                <label for="phone"> মোবাইলঃ *</label>
                                                <input type="text" minlength="11" maxlength="11" pattern="0[0-9]+"
                                                    title="please enter number only and 0 must first character"
                                                    title="Please enter an 11-digit number." id="phone"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    name="phone" value="{{ old('phone') }}"
                                                    placeholder="১১ ডিজিটের মোবাইল নাম্বার লিখুন" required />
                                                <i class="fa-solid fa-phone"></i>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-12">
                                            <div class="form-group checkout-input-box mb-3">
                                                <label for="address"> ঠিকানাঃ *</label>
                                                <input type="address" id="address"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    name="address"
                                                    placeholder="আপনার এলাকা থানা ও জেলার নাম লিখুন এখানে"
                                                    value="{{ old('address') }}" required />
                                                <i class="fa-solid fa-map"></i>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                           <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="area"> ডেলিভারি এরিয়া নিবার্চন করুন *</label>
                                            <select type="area" id="area"
                                                class="form-control @error('area') is-invalid @enderror" name="area"
                                                required>
                                                <option value="">ডেলিভারি এরিয়া নিবার্চন করুন</option>
                                                @foreach ($shippingcharge as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('area')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                        <div class="col-sm-12">
                                            <div class="radio_payment">
                                                <label id="payment_method">পেমেন্ট মেথড</label>
                                            </div>
                                            <div class="payment-methods">

                                                <div class="form-check p_cash payment_method" data-id="cod">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        id="inlineRadio1" value="Cash On Delivery" checked required />
                                                    <label class="form-check-label" for="inlineRadio1">
                                                        ক্যাশ অন ডেলিভারি
                                                    </label>
                                                </div>
                                                @if ($bkash_gateway)
                                                    <div class="form-check p_bkash payment_method" data-id="bkash">
                                                        <input class="form-check-input" type="radio"
                                                            name="payment_method" id="inlineRadio2" value="bkash"
                                                            required />
                                                        <label class="form-check-label" for="inlineRadio2">
                                                            বিকাশ
                                                        </label>
                                                    </div>
                                                @endif
                                                @if ($shurjopay_gateway)
                                                    <div class="form-check p_shurjo payment_method" data-id="nagad">
                                                        <input class="form-check-input" type="radio"
                                                            name="payment_method" id="inlineRadio3" value="shurjopay"
                                                            required />
                                                        <label class="form-check-label" for="inlineRadio3">
                                                            নগদ
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- card end -->


                    </div>

                    <div class="cart_details mt-2">
                        <div class="checkout-card">
                            <div class="checkout-header">
                                <h5>অর্ডার ইনফরমেশন</h5>
                            </div>
                            <div class="card-body cartlist">
                                <div class="table-responsive checkout-cart-wrapper">
                                    <table class="cart_table table table-striped text-center mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 25%;">Product</th>
                                                <th style="width: 20%;">Quantity</th>
                                                <th style="width: 15%;">Price</th>
                                                <th style="width: 25%;">Total Price</th>
                                                <th style="width: 15%;">Delete</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach (Cart::instance('shopping')->content() as $value)
                                                <tr>
                                                    <td class="text-left checkout-cart-product">
                                                        <div class="checkout-cart-image">
                                                            <img src="{{ asset($value->options->image) }}" />
                                                        </div>
                                                        <div class="checkout-cart-name">
                                                            <p>
                                                                {{ Str::limit($value->name, 20) }}
                                                            </p>
                                                            @if ($value->options->product_size)
                                                                <p>Size: {{ $value->options->product_size }}</p>
                                                            @endif
                                                            @if ($value->options->product_color)
                                                                <p>Color: {{ $value->options->product_color }}</p>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="cart_qty">
                                                        <div class="qty-cart vcart-qty">
                                                            <div class="quantity">
                                                                <button class="minus cart_decrement"
                                                                    data-id="{{ $value->rowId }}">-</button>
                                                                <input type="text" value="{{ $value->qty }}"
                                                                    readonly />
                                                                <button class="plus cart_increment"
                                                                    data-id="{{ $value->rowId }}">+</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><strong class="checkout-product-price">{{ $value->price }}
                                                            TK</strong></td>
                                                    <td><strong class="checkout-product-price">{{ $value->price }}
                                                            TK</strong></td>
                                                    <td>
                                                        <a class="cart_remove" data-id="{{ $value->rowId }}"><i
                                                                class="fas fa-trash text-danger"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                                <div>
                                    <div class="price-summary-item">
                                        <strong colspan="3" class="text-end ">Sub Total:</strong>
                                        <strong id="net_total">{{ $subtotal }}TK</strong>
                                    </div>
                                    <div class="price-summary-item">
                                        <strong colspan="3" class="text-end ">Delivery Charge:</strong>
                                        <strong id="cart_shipping_cost">{{ $shipping }} TK</strong>
                                    </div>
                                    <!--<div class="price-summary-item">-->
                                    <!--    <strong colspan="3" class="text-end ">Discount:</strong>-->
                                    <!--    <strong id="cart_shipping_cost">{{ $discount + $coupon }} TK</strong>-->
                                    <!--</div>-->
                                    <div class="price-summary-item">
                                        <strong colspan="3" class="text-end ">Payable Total:</strong>
                                        <strong id="grand_total">{{ $subtotal + $shipping - ($discount + $coupon) }}
                                            TK</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="order_place custom-shake" type="submit"> অর্ডার কনফার্ম করুন </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!-- col end -->
        </div>
    </div>
</section>


@endsection
@push('script')
<script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $(".select2").select2();
        var questionModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        questionModal.show();
    });
</script>

<script>
    $("#area").on("change", function() {
        var id = $(this).val();
        draft_order();
        $.ajax({
            type: "GET",
            data: {
                id: id
            },
            url: "{{ route('shipping.charge') }}",
            dataType: "html",
            success: function(response) {
                $(".cartlist").html(response);
            },
        });
    });

    function draft_order() {
        var area = $('#area').val();
        var name = $("#name").val();
        var phone = $("#phone").val();
        var address = $("#address").val();
        if (area && name && phone && address) {
            $.ajax({
                type: "GET",
                data: {
                    area,
                    name,
                    phone,
                    address
                },
                url: "{{ route('order.store.draft') }}",
                success: function(data) {
                    if (data) {
                        return data;
                    }
                },
            });
        }
    }
</script>


<script>
    $("#phone").on("input", function() {
        var code = $(this).val();
        code = code.replace(/\D/g, '');
        $(this).val(code);
        var isValid = false;
        // Check if the input is a number and has exactly 11 digits
        if (/^\d{11}$/.test(code)) {
            // Check if it starts with one of the allowed prefixes
            if (code.startsWith("013") || code.startsWith("014") ||
                code.startsWith("015") || code.startsWith("016") ||
                code.startsWith("017") || code.startsWith("018") ||
                code.startsWith("019")) {
                isValid = true;
            }
        }
        console.log('test: ' + isValid);
            if (isValid) {
                $("#phone").addClass('border-success');
                $("#phone").removeClass('border-danger');
                $(".send_otp").prop('disabled', false);
            } else {
                $("#phone").addClass('border-danger');
                $("#phone").removeClass('border-success');
                $(".send_otp").prop('disabled', true);
            }
         });

    });
</script>

<script type="text/javascript">
    dataLayer.push({
        ecommerce: null
    }); // Clear the previous ecommerce object.
    dataLayer.push({
        event: "view_cart",
        ecommerce: {
            items: [
                @foreach (Cart::instance('shopping')->content() as $cartInfo)
                    {
                        item_name: "{{ $cartInfo->name }}",
                        item_id: "{{ $cartInfo->id }}",
                        price: "{{ $cartInfo->price }}",
                        item_brand: "{{ $cartInfo->options->brand }}",
                        item_category: "{{ $cartInfo->options->category }}",
                        item_size: "{{ $cartInfo->options->size }}",
                        item_color: "{{ $cartInfo->options->color }}",
                        currency: "BDT",
                        quantity: {{ $cartInfo->qty ?? 0 }}
                    },
                @endforeach
            ]
        }
    });
</script>
<script type="text/javascript">
    // Clear the previous ecommerce object.
    dataLayer.push({
        ecommerce: null
    });

    // Push the begin_checkout event to dataLayer.
    dataLayer.push({
        event: "begin_checkout",
        ecommerce: {
            items: [
                @foreach (Cart::instance('shopping')->content() as $cartInfo)
                    {
                        item_name: "{{ $cartInfo->name }}",
                        item_id: "{{ $cartInfo->id }}",
                        price: "{{ $cartInfo->price }}",
                        item_brand: "{{ $cartInfo->options->brands }}",
                        item_category: "{{ $cartInfo->options->category }}",
                        item_size: "{{ $cartInfo->options->size }}",
                        item_color: "{{ $cartInfo->options->color }}",
                        currency: "BDT",
                        quantity: {{ $cartInfo->qty ?? 0 }}
                    },
                @endforeach
            ]
        }
    });
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
