@extends('frontEnd.layouts.master')
@section('title', $details->name)
@push('seo')
    <meta name="app-url" content="{{ route('product', $details->slug) }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ $details->meta_description }}" />
    <meta name="keywords" content="{{ $details->slug }}" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="{{ $details->name }}" />
    <meta name="twitter:title" content="{{ $details->name }}" />
    <meta name="twitter:description" content="{{ $details->meta_description }}" />
    <meta name="twitter:creator" content="{{ $generalsetting->name }}" />
    <meta property="og:url" content="{{ route('product', $details->slug) }}" />
    <meta name="twitter:image" content="{{ asset($details->image->image) }}" />

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $details->name }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('product', $details->slug) }}" />
    <meta property="og:image" content="{{ asset($details->image->image) }}" />
    <meta property="og:description" content="{{ $details->meta_description }}" />
    <meta property="og:site_name" content="{{ $details->name }}" />
@endpush

@section('content')
    <div class="homeproduct main-details-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="details-product">
                        <div class="row">
                            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="position-relative">
                                    @if ($details->old_price)
                                        <div class="discount">
                                            <p> @php $discount=(((($details->old_price)-($details->new_price))*100) / ($details->old_price)) @endphp {{ number_format($discount, 0) }}% Discount</p>
                                        </div>
                                    @endif
                                    @if ($details->variableimages->count() > 0)
                                        <div class="details_slider owl-carousel">
                                            @foreach ($details->variableimages as $value)
                                                <div class="dimage_item">
                                                    <img src="{{ asset($value->image) }}" class="block__pic" />
                                                </div>
                                            @endforeach
                                        </div>
                                        <div
                                            class="indicator_thumb @if ($details->variableimages->count() > 4) thumb_slider owl-carousel @endif">
                                            @foreach ($details->variableimages as $key => $value)
                                                <div class="indicator-item" data-id="{{ $key }}">
                                                    <p>{{ $value->name }}</p>
                                                    <img src="{{ asset($value->image) }}" />
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- normal product image -->
                                    @else
                                        <div class="details_slider owl-carousel">
                                            @foreach ($details->images as $value)
                                                <div class="dimage_item">
                                                    <img src="{{ asset($value->image) }}" class="block__pic" />
                                                </div>
                                            @endforeach
                                        </div>
                                        <div
                                            class="indicator_thumb @if ($details->images->count() > 4) thumb_slider owl-carousel @endif">
                                            @foreach ($details->images as $key => $value)
                                                <div class="indicator-item" data-id="{{ $key }}">
                                                    <img src="{{ asset($value->image) }}" />
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="details_right">
                                    <div class="breadcrumb d-none">
                                        <ul>
                                            <li><a href="{{ url('/') }}">Home</a></li>
                                            <li><span>/</span></li>
                                            <li><a
                                                    href="{{ url('/category/' . $details->category->slug) }}">{{ $details->category->name }}</a>
                                            </li>
                                            @if ($details->subcategory)
                                                <li><span>/</span></li>
                                                <li><a
                                                        href="#">{{ $details->subcategory ? $details->subcategory->name : '' }}</a>
                                                </li>
                                            @endif
                                            @if ($details->childcategory)
                                                <li><span>/</span></li>
                                                <li> <a href="#">{{ $details->childcategory->name }}</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                    <div class="product">
                                        <div class="product-cart">
                                            <p class="name">{{ $details->name }}</p>
                                            <div class="single-product-whatsapp">
                                                <a class="" href="https://wa.me/+88{{ $contact->hotline }}">
                                                    @include('frontEnd.layouts.svg.whatsapp')
                                                    Ask For Details
                                                </a>
                                            </div>
                                            @if ($details->variable_count > 0 && $details->type == 0)
                                                <p class="details-price">
                                                    @if ($details->variable->old_price)
                                                        <del>৳ <span
                                                                class="old_price">{{ $details->variable->old_price }}</span></del>
                                                    @endif ৳ <span
                                                        class="new_price">{{ $details->variable->new_price }}</span>
                                                </p>
                                            @else
                                                <p class="details-price">
                                                    @if ($details->old_price)
                                                        <del>৳{{ $details->old_price }}</del>
                                                    @endif ৳{{ $details->new_price }}
                                                </p>
                                            @endif
                                            @if ($details->product_code)
                                                <div class="single-product-attribute">
                                                    <strong>Code: </strong>
                                                    <span>{{ $details->product_code }}</span>
                                                </div>
                                            @endif
                                            <form action="{{ route('cart.store') }}" method="POST" name="formName">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $details->id }}" />
                                                <input type="hidden" name="category_id"
                                                    value="{{ $details->category_id }}" />
                                                @if ($productcolors->count() > 0)
                                                    <div class="pro-color">
                                                        <p class="color-title">Select Color </p>
                                                        <div class="color_inner">
                                                            <div class="size-container">
                                                                <div class="selector">
                                                                    @foreach ($productcolors as $key => $procolor)
                                                                        <div class="selector-item color-item"
                                                                            data-id="{{ $key }}">
                                                                            {{ $procolor->image }}
                                                                            <input type="radio"
                                                                                id="fc-option{{ $procolor->color }}"
                                                                                value="{{ $procolor->color }}"
                                                                                name="product_color"
                                                                                class="selector-item_radio emptyalert stock_color stock_check"
                                                                                required
                                                                                data-color="{{ $procolor->color }}" />
                                                                            <label for="fc-option{{ $procolor->color }}"
                                                                                class="selector-item_label">{{ $procolor->color }}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($productsizes->count() > 0)
                                                    <div class="pro-size">
                                                        <p class="color-title">Select Size</p>
                                                        <div class="size_inner">

                                                            <div class="size-container">
                                                                <div class="selector">
                                                                    @foreach ($productsizes as $prosize)
                                                                        <div class="selector-item">
                                                                            <input type="radio"
                                                                                id="f-option{{ $prosize->size }}"
                                                                                value="{{ $prosize->size }}"
                                                                                name="product_size"
                                                                                class="selector-item_radio emptyalert stock_size stock_check"
                                                                                data-size="{{ $prosize->size }}"
                                                                                required />
                                                                            <label for="f-option{{ $prosize->size }}"
                                                                                class="selector-item_label">{{ $prosize->size }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="shipping_highlight">
                                                    <h4 class="text-bangla">২-৪ দিনের মধ্যে পণ্য হাতে পাবেন, পণ্য হাতে পেয়ে
                                                        টাকা পরিশোধ&nbsp;করবেন!
                                                    </h4>
                                                </div>
                                                <div class="pro_brand">
                                                    <p>Brand :
                                                        {{ $details->brand ? $details->brand->name : 'N/A' }}
                                                    </p>
                                                </div>
                                                <div class="pro_sold product-info-item">
                                                    <p>Sold :
                                                        {{ $details->sold }}
                                                    </p>
                                                </div>
                                                <div class="product-stock-wrapper">
                                                    <div class="pro_brand stock"></div>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="col-1">
                                                        <span>Qty: </span>
                                                    </div>
                                                    <div class="qty-cart col-5">
                                                        <div class="quantity">
                                                            <span class="minus">
                                                                <i class="fa fa-minus"></i>
                                                            </span>
                                                            <input id="details_qty" type="text" name="qty" value="1" />
                                                            <span class="plus">
                                                                <i class="fa fa-plus"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <button  type="button" data-id="{{ $details->id }}"
                                                            id="add_cart_btn" data-type="cart" class="btn px-4 add_cart_btn">
                                                            @include('frontEnd.layouts.svg.cart_updated')
                                                           কার্টে যোগ করুন
                                                        </button>
                                                        {{-- <input type="submit" class="btn px-4 add_cart_btn"
                                                        onclick="return sendSuccess();" name="add_cart"
                                                        value="Add To Cart " id="add_cart_btn" /> --}}
                                                    </div>
                                                </div>
                                                <div class="d-flex single_product col-sm-12">
                                                    <button onclick="return sendSuccess();" type="submit"
                                                        id="order_now_btn" data-id="{{ $details->id }}"
                                                        class="btn px-4 custom-shake order_now_btn order_now_btn_m">
                                                        @include('frontEnd.layouts.svg.order_now')
                                                        Order Now
                                                    </button>
                                                    {{-- <input type="submit" class="btn px-4 order_now_btn order_now_btn_m"
                                                        onclick="return sendSuccess();" name="order_now"
                                                        value="Order Now" id="order_now" /> --}}
                                                </div>


                                            </form>
                                            <div class="contact-us-container">
                                                <a href="tel:{{ $contact->phone }}" class="call-contact-us call-whats">
                                                    <div class="call-icon">
                                                        <i class="fa-solid fa-phone"></i>
                                                    </div>
                                                    <div class="contact-des">
                                                        <h5>Call Now</h5>
                                                        <h6>
                                                            {{ $contact->phone }}
                                                        </h6>
                                                    </div>
                                                </a>
                                                <a href="https://wa.me/+88{{ $contact->phone }}"
                                                    class="call-contact-us call-whats">
                                                    <div class="whats-up">
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                    </div>
                                                    <div class="contact-des">
                                                        <h5>Message Us</h5>
                                                        <h6>
                                                            {{ $contact->phone }}
                                                        </h6>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="single-product-specification-content">
                                    <div class="single-product-specification-list">
                                        <ul>
                                            <li class="">
                                                <i class="fa-solid fa-check"></i>
                                                Order today and receive it within 02 - 04 days.
                                            </li>
                                            <li class="">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                                Quality Product
                                            </li>
                                            @if ($details->has_cod)
                                                <li class="active">
                                                    <i class="fa-solid fa-handshake"></i>
                                                    Cash On Delivery Available
                                                </li>
                                            @endif
                                            @foreach ($shippingcharge as $key => $value)
                                                <li>
                                                    <i class="fa-solid fa-truck-fast"></i>
                                                    Delivery Charge {{ $value->name }}
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <div class="single-product-call-details">
                                        <div class="single-product-call-title">
                                            <p>Have question about this product ? please call</p>
                                        </div>
                                        <div class="single-product-call">
                                            <ul>
                                                <li>
                                                    <a href="tel:{{ $contact->phone }}" class="single-product-call-link">
                                                        <div class="single-product-call-content">
                                                            <i class="fa-solid fa-phone"></i>
                                                            {{ $contact->phone }}
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="tel:{{ $contact->bkash }}" class="single-product-call-link">
                                                        <div class="single-product-call-content">
                                                            <i class="fa-solid fa-phone"></i>
                                                            {{ $contact->bkash }}
                                                        </div>
                                                        <div class="single-product-call-payment-method">
                                                            <p>Bkash Personal</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="tel:{{ $contact->nagad }}"
                                                        class="single-product-call-link">
                                                        <div class="single-product-call-content">
                                                            <i class="fa-solid fa-phone"></i>
                                                           {{ $contact->nagad }}
                                                        </div>
                                                        <div class="single-product-call-payment-method">
                                                            <p>Nagad Personal</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="pro_details_area">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="details-tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description-tab-pane" type="button"
                                    role="tab">ডেসক্রিপশন</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="review-tab" data-bs-toggle="tab"
                                    data-bs-target="#review-tab-pane" type="button" role="tab">রিভিউ</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="video-tab" data-bs-toggle="tab"
                                    data-bs-target="#video-tab-pane" type="button" role="tab">ভিডিও</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel"
                                aria-labelledby="description-tab" tabindex="0">
                                <div class="description">
                                    {!! $details->description !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="review-tab-pane" role="tabpanel" aria-labelledby="review-tab"
                                tabindex="0">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="review-inner">
                                            <div class="review-head">
                                                <div class="review-title">
                                                    <h4>Reviews ({{ $reviews->count() }})</h4>
                                                    <p>Get specific details about this product from customers who own it.
                                                    </p>
                                                </div>
                                                <div class="review-btn">
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#review_modal">
                                                        Give a review
                                                    </button>
                                                </div>
                                            </div>
                                            @if ($reviews->count() > 0)
                                                <div class="customer-review">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-12">
                                                            @foreach ($reviews as $key => $review)
                                                                <div class="review-card">
                                                                    <p class="reviewer_name"><i
                                                                            data-feather="message-square"></i>
                                                                        {{ $review->name }}</p>
                                                                    <p class="review_data">
                                                                        {{ $review->created_at->format('d-m-Y') }}</p>
                                                                    <p class="review_star">{!! str_repeat('<i class="fa-solid fa-star"></i>', $review->ratting) !!}</p>
                                                                    <p class="review_content">{{ $review->review }}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            @include('frontEnd.layouts.partials.review_stars')
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="empty-review">
                                                    <i class="fa fa-clipboard-list"></i>
                                                    <p class="empty-text">This product has no reviews yet. Be the first one
                                                        to
                                                        Give a review.</p>
                                                </div>
                                            @endif
                                            <div class="modal fade" id="review_modal" tabindex="-1"
                                                aria-labelledby="review_modalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="review_modalLabel">Give your
                                                                review</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="insert-review">
                                                                @if (Auth::guard('customer')->user())
                                                                    <form action="{{ route('customer.review') }}"
                                                                        id="review-form" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id"
                                                                            value="{{ $details->id }}">
                                                                        <div class="fz-12 mb-2">
                                                                            <div class="rating">
                                                                                <label title="Excelent">
                                                                                    ☆
                                                                                    <input required type="radio"
                                                                                        name="ratting" value="5" />
                                                                                </label>
                                                                                <label title="Best">
                                                                                    ☆
                                                                                    <input required type="radio"
                                                                                        name="ratting" value="4" />
                                                                                </label>
                                                                                <label title="Better">
                                                                                    ☆
                                                                                    <input required type="radio"
                                                                                        name="ratting" value="3" />
                                                                                </label>
                                                                                <label title="Very Good">
                                                                                    ☆
                                                                                    <input required type="radio"
                                                                                        name="ratting" value="2" />
                                                                                </label>
                                                                                <label title="Good">
                                                                                    ☆
                                                                                    <input required type="radio"
                                                                                        name="ratting" value="1" />
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="message-text"
                                                                                class="col-form-label">Message:</label>
                                                                            <textarea required class="form-control radius-lg" name="review" id="message-text"></textarea>
                                                                            <span id="validation-message"
                                                                                style="color: red;"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button class="details-review-button"
                                                                                type="submit">Submit
                                                                                Review</button>
                                                                        </div>

                                                                    </form>
                                                                @else
                                                                    <form action="{{ route('customer.signin') }}"
                                                                        method="POST" data-parsley-validate="">
                                                                        @csrf
                                                                        <input type="hidden" name="review"
                                                                            value="1">
                                                                        <h6 class="mb-3">Please login first</h6>
                                                                        <div class="form-group mb-3">
                                                                            <label for="phone" class="mb-3">Mobile
                                                                                Number *</label>
                                                                            <input type="number" id="phone"
                                                                                class="form-control @error('phone') is-invalid @enderror"
                                                                                placeholder="Enter your mobile number"
                                                                                name="phone"
                                                                                value="{{ old('phone') }}" required>
                                                                            @error('phone')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <!-- col-end -->
                                                                        <div class="form-group mb-3">
                                                                            <label for="password" class="mb-3">Password
                                                                                *</label>
                                                                            <input type="password" id="password"
                                                                                class="form-control @error('password') is-invalid @enderror"
                                                                                placeholder="Enter your password"
                                                                                name="password"
                                                                                value="{{ old('password') }}" required>
                                                                            @error('password')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <!-- col-end -->
                                                                        <div class="form-group mb-3">
                                                                            <button class="submit-btn"> Login </button>
                                                                        </div>
                                                                        <!-- col-end -->
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="video-tab-pane" role="tabpanel" aria-labelledby="video-tab"
                                tabindex="0">
                                <div class="pro_vide">
                                    <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/{{ $details->pro_video }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="related-product-section d-sm-block d-none">
        <div class="container">
            <div class="row">
                <div class="related-title">
                    <h5>রিলেটেড প্রোডাক্ট</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="product-inner owl-carousel related_slider">
                        @foreach ($products as $key => $value)
                            <div class="product_item wist_item">
                                @include('frontEnd.layouts.partials.product')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="related-product-section d-sm-none d-block">
        <div class="container">
            <div class="row">
                <div class="related-title">
                    <h5>Related Products</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="product-inner related-product-mobile">
                        @foreach ($products as $key => $value)
                            <div class="product_item wist_item">
                                @include('frontEnd.layouts.partials.product')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script src="{{ asset('public/frontEnd/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/zoomsl.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".details_slider").owlCarousel({
                margin: 15,
                items: 1,
                loop: true,
                dots: false,
                nav: false,
                autoplay: false,
                onChanged: function(event) {
                    var currentIndex = event.item.index - event.relatedTarget._clones.length / 2;
                    var totalItems = event.item.count;

                    if (currentIndex < 0) {
                        currentIndex = totalItems - 1;
                    } else if (currentIndex >= totalItems) {
                        currentIndex = 0;
                    }

                    console.log("Currently showing slide index:", currentIndex);
                    $(".indicator-item").removeClass("active");

                    // Add "active" to the correct indicator
                    $(".indicator-item[data-id='" + currentIndex + "']").addClass("active");
                }
            });
            $(".indicator-item,.color-item").on("click", function() {
                var slideIndex = $(this).data('id');
                $('.details_slider').trigger('to.owl.carousel', slideIndex);
            });
        });
    </script>
    <!--Data Layer Start-->
    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            ecommerce: null
        });
        dataLayer.push({
            event: "view_item",
            ecommerce: {
                items: [{
                    item_name: "{{ $details->name }}",
                    item_id: "{{ $details->id }}",
                    @if ($details->variable_count > 0 && $details->type == 0)
                        price: "{{ $details->variable->new_price }}",
                    @else
                        price: "{{ $details->new_price }}",
                    @endif
                    item_brand: "{{ $details->brand ? $details->brand->name : '' }}",
                    item_category: "{{ $details->category->name }}",
                    item_variant: "{{ $details->pro_unit }}",
                    currency: "BDT",
                    quantity: {{ $details->stock ?? 1 }}
                }],

            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#add_to_cart').click(function() {
                gtag("event", "add_to_cart", {
                    currency: "BDT",
                    value: "1.5",
                    items: [
                        @foreach (Cart::instance('shopping')->content() as $cartInfo)
                            {
                                item_id: "{{ $details->id }}",
                                item_name: "{{ $details->name }}",
                                price: "{{ $details->new_price }}",
                                currency: "BDT",
                                quantity: {{ $cartInfo->qty ?? 1 }}
                            },
                        @endforeach
                    ]
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#order_now').click(function() {
                gtag("event", "add_to_cart", {
                    currency: "BDT",
                    value: "1.5",
                    items: [
                        @foreach (Cart::instance('shopping')->content() as $cartInfo)
                            {
                                item_id: "{{ $details->id }}",
                                item_name: "{{ $details->name }}",
                                price: "{{ $details->new_price }}",
                                currency: "BDT",
                                quantity: {{ $cartInfo->qty ?? 1 }}
                            },
                        @endforeach
                    ]
                });
            });
        });
    </script>

    <!-- Data Layer End-->
    <script>
        $(document).ready(function() {
            $(".related_slider").owlCarousel({
                margin: 10,
                items: 5,
                loop: true,
                dots: true,
                nav: false,
                autoplay: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                    },
                    600: {
                        items: 3,
                        nav: false,
                    },
                    1000: {
                        items: 5,
                    },
                },
            });
            // $('.owl-nav').remove();
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".minus").click(function() {
                var $input = $(this).parent().find("input");
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                return false;
            });
            $(".plus").click(function() {
                var $input = $(this).parent().find("input");
                $input.val(parseInt($input.val()) + 1);
                $input.change();
                return false;
            });
        });
    </script>

    <script>
        function sendSuccess() {
            // size validation
            if (document.forms["formName"]["product_size"]) {
                size = document.forms["formName"]["product_size"].value;
                if (size != "") {} else {
                    toastr.warning("Please select any size");
                    return false;
                }
            }
            if (document.forms["formName"]["product_color"]) {
                color = document.forms["formName"]["product_color"].value;
                if (color != "") {} else {
                    toastr.error("Please select any color");
                    return false;
                }
            }
        }
    </script>
    <script></script>
    <script>
        $(document).ready(function() {
            $(".rating label").click(function() {
                $(".rating label").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".thumb_slider").owlCarousel({
                margin: 15,
                items: 4,
                loop: true,
                dots: false,
                nav: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
            });
        });
    </script>

    <script type="text/javascript">
        $(".block__pic").imagezoomsl({
            zoomrange: [3, 3]
        });
    </script>
    <script>
        $(".stock_check").on("click", function() {
            var color = $(".stock_color:checked").data('color');
            var size = $(".stock_size:checked").data('size');
            var id = {{ $details->id }};
            console.log(color);
            if (id) {
                $.ajax({
                    type: "GET",
                    data: {
                        id: id,
                        color: color,
                        size: size
                    },
                    url: "{{ route('stock_check') }}",
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            $(".stock").html('<p><span>Stock : </span>' + response.product.stock +
                                '</p>');

                            $(".old_price").text(response.product.old_price);
                            $(".new_price").text(response.product.new_price);
                            // cart button enable
                            $('.add_cart_btn').prop('disabled', false);
                            $('.order_now_btn').prop('disabled', false);
                        } else {
                            toastr.warning("Please select another color or size");
                            $(".stock").empty();
                            // cart button disabled
                            $('.add_cart_btn').prop('disabled', true);
                            $('.order_now_btn').prop('disabled', true);
                        }


                    }
                });
            }
        });
    </script>

    <!--Microdata -->
    <script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"Product",
  "productID":"{{$details->id}}",
  "name":"{{$details->name}}",
  "description":"{!!$details->description!!}",
  "url":"{{Request::fullUrl()}}",
  "image":"{{asset($details->image->image)}}",
  "brand":"@if($details->brand_id !=NULL) {{$details->brand->brandName}} @endif",
  "offers": [
    {
      "@type": "Offer",
     @if ($details->variable_count > 0 && $details->type == 0)
      "price": "{{$details->variable->new_price}}",
      @else
      "price": "{{$details->new_price}}",
      @endif
      "priceCurrency": "BDT",
      "itemCondition": "https://schema.org/NewCondition",
      "availability": "https://schema.org/InStock"
    }
  ],
  "additionalProperty": [{
    "@type": "PropertyValue",
    "propertyID": "item_group_id",
    "value": "{{$details->name}}"
  }]
}
</script>
@endpush
