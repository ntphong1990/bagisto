@extends('shop::layouts.master')

@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('customHelper', 'Webkul\Velocity\Helpers\Helper')
@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')

@php
$total = $reviewHelper->getTotalReviews($product);

$avgRatings = $reviewHelper->getAverageRating($product);
$avgStarRating = round($avgRatings);

$productImages = [];
$images = $productImageHelper->getGalleryImages($product);

foreach ($images as $key => $image) {
array_push($productImages, $image['medium_image_url']);
}
@endphp

@section('page_title')
{{ trim($product->meta_title) != "" ? $product->meta_title : $product->name }}
@stop

@section('seo')
<meta name="description"
    content="{{ trim($product->meta_description) != "" ? $product->meta_description : \Illuminate\Support\Str::limit(strip_tags($product->description), 120, '') }}" />

<meta name="keywords" content="{{ $product->meta_keywords }}" />

@if (core()->getConfigData('catalog.rich_snippets.products.enable'))
<script type="application/ld+json">
            {!! app('Webkul\Product\Helpers\SEO')->getProductJsonLd($product) !!}
        </script>
@endif

<?php $productBaseImage = app('Webkul\Product\Helpers\ProductImage')->getProductBaseImage($product); ?>

<meta name="twitter:card" content="summary_large_image" />

<meta name="twitter:title" content="{{ $product->name }}" />

<meta name="twitter:description" content="{{ $product->description }}" />

<meta name="twitter:image:alt" content="" />

<meta name="twitter:image" content="{{ $productBaseImage['medium_image_url'] }}" />

<meta property="og:type" content="og:product" />

<meta property="og:title" content="{{ $product->name }}" />

<meta property="og:image" content="{{ $productBaseImage['medium_image_url'] }}" />

<meta property="og:description" content="{{ $product->description }}" />

<meta property="og:url" content="{{ route('shop.productOrCategory.index', $product->url_key) }}" />
@stop

@push('css')
<style type="text/css">
    .related-products {
        width: 100%;
    }

    .recently-viewed {
        margin-top: 20px;
    }

    .store-meta-images>.recently-viewed:first-child {
        margin-top: 0px;
    }

    .main-content-wrapper {
        margin-bottom: 0px;
    }
</style>
@endpush

@section('full-content-wrapper')
{!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <div>
            <div class="single-product">
                <div class="single-product__background" style="background-color: rgb(164, 63, 65);"></div>
                <div class="grid-container">
                    <div class="single-product__content">
                        @include ('shop::products.view.gallery')

                        <div class="single-product__content__summary" style="">
                            <div class="single-product__content__summary--intro"><a href="/shop/?category=blends"
                                    class="single-product__content__summary__category">Blends</a>
                                <h2 class="single-product__content__summary__title">Roma Espresso Blend</h2>
                                <div class="single-product__content__summary__price"><span class="from">From</span>
                                    <span class="woocommerce-Price-amount amount"><span
                                            class="woocommerce-Price-currencySymbol">$</span>15.00</span></div>
                                <div class="roast">
                                    <div class="roast__label">Roast</div>
                                    <div class="roast__level">
                                        <div class="roast__level__inner" style="width: 90%;"></div>
                                        <div class="roast__level__bean" style="left: 90%;"></div>
                                    </div>
                                </div>
                                <div class="single-product__content__summary__excerpt">
                                    <div class="single-product__content__summary__excerpt__label">
                                        Taste
                                    </div>
                                    <div class="single-product__content__summary__excerpt__text">Powerful, chocolatey
                                        with milk, thick crema</div>
                                </div>
                            </div>
                            <form class="add-to-cart">
                                <div>
                                    <div class="add-to-cart__label">Bag Size</div> <label class="select"><select
                                            class="pa_weight">
                                            <option disabled="disabled" value="">Please select</option>
                                            <option value="250g">250g</option>
                                            <option value="500g">500g</option>
                                            <option value="1kg">1kg</option>
                                            <option value="3kg">3kg: 3 x 1kg bags (save 8%)</option>
                                            <option value="6kg">6kg: 6 x 1kg bags (save from 10%)</option>
                                        </select></label>
                                </div>
                                <div>
                                    <div class="add-to-cart__label">Grind</div>
                                    <div class="button-group">
                                        <div class="button-group__button"><input type="radio" id="wholebeans-true"
                                                name="wholebeans" value="true"> <label for="wholebeans-true"
                                                class="button-group__label pa_grind"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="56" height="56"
                                                    viewBox="0 0 56 56"
                                                    class="injected-svg svg-icon button-group__label__icon"
                                                    data-src="https://camposcoffee.com/wp-content/themes/campos-codeshare/assets/images/icons/wholebeans.svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <path fill="#000" fill-rule="evenodd" stroke="#000"
                                                        stroke-width=".1"
                                                        d="M11.428 12.443c-3.137 1.404-4.9 4.627-5.499 8.41-.596 3.782-.068 8.177 1.512 12.231 1.571 4.033 4.062 7.301 7.002 9.289 2.939 1.984 6.388 2.678 9.669 1.4l.022-.008c3.247-1.36 5.221-4.246 5.938-7.707.544-2.64.386-5.626-.416-8.687.375.353.769.69 1.186 1.013.21.158.404.306.59.444 2.443 1.932 5.727 2.984 8.85 3.078 3.094.094 6.078-.746 7.868-2.867.096-.104.128-.162.19-.233 1.517-1.981 1.57-4.699.626-7.32-.965-2.685-2.94-5.36-5.59-7.452-2.758-2.177-6.116-3.387-9.203-3.376-1.542.005-3.049.335-4.34 1.002a7.257 7.257 0 0 0-2.554 2.191c-.213.303-.397.613-.562.881-.785 1.288-1.121 2.715-1.13 4.16-1.234-1.632-2.66-3.079-4.18-4.216-3.099-2.317-6.673-3.426-9.912-2.26l-.067.027zm.708 1.371c2.57-.86 5.564.008 8.349 2.09 2.835 2.12 5.381 5.46 6.819 9.155 1.475 3.796 1.894 7.617 1.256 10.704-.469 2.263-1.46 4.127-3.044 5.414-.158-.079-.34-.177-.486-.253-2.882-1.428-4.11-2.88-4.678-4.486-.59-1.658-.46-3.595-.389-5.876.137-4.496-.204-10.238-7.824-16.749l-.003.001zm-1.395.823a.968.968 0 0 0 .111.084c7.637 6.368 7.727 11.306 7.589 15.783-.07 2.239-.273 4.376.462 6.442.684 1.924 2.205 3.685 5.09 5.193a8.36 8.36 0 0 1-.435.201l-.022.01c-2.778 1.07-5.63.51-8.242-1.253-2.62-1.77-4.949-4.781-6.426-8.564-1.485-3.811-1.992-7.972-1.445-11.43.442-2.806 1.557-5.095 3.318-6.466zM30.555 13c1.04-.534 2.283-.787 3.625-.792 2.684-.01 5.74 1.05 8.233 3.017 2.438 1.925 4.27 4.431 5.115 6.789.645 1.795.737 3.466.215 4.807-.876-1.64-1.978-2.693-3.228-3.33-1.568-.801-3.277-1.01-5.03-1.282-3.457-.536-7.137-1.211-11.003-6.608-.085-.137-.182-.243-.271-.36a5.638 5.638 0 0 1 2.343-2.24V13zm-3.087 3.784c4.054 5.48 8.33 6.409 11.78 6.944 1.78.274 3.334.491 4.58 1.127 1.158.59 2.133 1.546 2.94 3.447-1.413 1.448-3.805 2.158-6.431 2.08-2.66-.08-5.505-.97-7.607-2.496-.157-.109-.285-.219-.417-.32-2.324-1.66-3.979-3.778-4.742-5.93-.595-1.672-.636-3.322-.103-4.852z">
                                                    </path>
                                                </svg>
                                                <div class="button-group__label__text">Whole Beans</div>
                                            </label></div>
                                        <div class="button-group__button"><input type="radio" id="wholebeans-false"
                                                name="wholebeans" value="false"> <label for="wholebeans-false"
                                                class="button-group__label"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="56" height="56" viewBox="0 0 56 56"
                                                    class="injected-svg svg-icon button-group__label__icon"
                                                    data-src="https://camposcoffee.com/wp-content/themes/campos-codeshare/assets/images/icons/ground.svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <g fill="#000" fill-rule="evenodd">
                                                        <path
                                                            d="M29.015 44.873c0 1.483-2.227 1.483-2.227 0s2.227-1.483 2.227 0">
                                                        </path>
                                                        <path stroke="#FFF" stroke-width=".25"
                                                            d="M41.263 32.642a1.112 1.112 0 1 0 0-2.223h-6.345a12.236 12.236 0 0 0 5.232-8.896h1.18c.614 0 1.114-.497 1.114-1.111 0-.615-.5-1.112-1.113-1.112H31.242v-5.56a3.34 3.34 0 1 0-6.48-1.112h-5.014V7.07a3.339 3.339 0 0 0-3.34-3.336 3.339 3.339 0 0 0-3.34 3.336v6.671a1.11 1.11 0 0 0 1.113 1.112h10.38V19.3h-10.02a1.112 1.112 0 1 0 0 2.223h1.113a12.226 12.226 0 0 0 5.167 8.896h-6.28a1.112 1.112 0 1 0 0 2.223h1.113V48.21h-1.113a1.112 1.112 0 1 0 0 2.223h26.723a1.112 1.112 0 1 0 0-2.223H40.15V32.642h1.113zM15.293 7.07c0-.615.499-1.112 1.114-1.112.615 0 1.113.497 1.113 1.112v5.56h-2.226v-5.56zm11.495 6.671c0-.614.498-1.112 1.114-1.112.615 0 1.113.498 1.113 1.112v5.56h-2.227v-5.56zm-8.797 7.783h19.932a9.958 9.958 0 0 1-5.259 7.662 9.984 9.984 0 0 1-9.303 0 9.963 9.963 0 0 1-5.258-7.662h-.112zm4.343 26.686v-6.672H33.47v6.672H22.334zm15.589 0h-2.227v-7.784a1.11 1.11 0 0 0-1.114-1.111H21.221c-.616 0-1.114.497-1.114 1.111v7.784h-2.226V32.642h20.042V48.21z">
                                                        </path>
                                                    </g>
                                                </svg>
                                                <div class="button-group__label__text">Ground</div>
                                            </label></div>
                                    </div>
                                    <div class="add-to-cart__fields add-to-cart__fields--grind">
                                        <div class="radio"><input type="radio" id="pa_grind-whole-beans" name="pa_grind"
                                                value="whole-beans"> <label for="pa_grind-whole-beans"
                                                style="display: none;">Whole Beans</label></div>
                                        <div class="radio"><input type="radio" id="pa_grind-espresso-commercial"
                                                name="pa_grind" value="espresso-commercial"> <label
                                                for="pa_grind-espresso-commercial">Espresso - Commercial</label></div>
                                        <div class="radio"><input type="radio" id="pa_grind-espresso-home"
                                                name="pa_grind" value="espresso-home"> <label
                                                for="pa_grind-espresso-home">Espresso - Home</label></div>
                                        <div class="radio"><input type="radio" id="pa_grind-stovetop" name="pa_grind"
                                                value="stovetop"> <label for="pa_grind-stovetop">Stovetop</label></div>
                                        <div class="radio"><input type="radio" id="pa_grind-aeropress" name="pa_grind"
                                                value="aeropress"> <label for="pa_grind-aeropress">Aeropress</label>
                                        </div>
                                        <div class="radio"><input type="radio" id="pa_grind-filter" name="pa_grind"
                                                value="filter"> <label for="pa_grind-filter">Filter</label></div>
                                        <div class="radio"><input type="radio" id="pa_grind-cold-brew" name="pa_grind"
                                                value="cold-brew"> <label for="pa_grind-cold-brew">Cold Brew</label>
                                        </div>
                                        <div class="radio"><input type="radio" id="pa_grind-plunger" name="pa_grind"
                                                value="plunger"> <label for="pa_grind-plunger">Plunger</label></div>
                                    </div>
                                </div>
                                <div class="add-to-cart__label">Frequency</div>
                                <div class="button-group">
                                    <div class="button-group__button"><input type="radio" id="subscription-false"
                                            name="subscription" value="false"> <label for="subscription-false"
                                            class="pa_frequency button-group__label"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="56" height="56"
                                                viewBox="0 0 56 56"
                                                class="injected-svg svg-icon button-group__label__icon"
                                                data-src="https://camposcoffee.com/wp-content/themes/campos-codeshare/assets/images/icons/onceoff.svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <g fill="#000" fill-rule="evenodd">
                                                    <path
                                                        d="M13.689 5.787c-.374 0-.622.248-.622.623v42.746c0 .374.248.622.622.622H42.31c.374 0 .622-.248.622-.622V6.41c0-.375-.248-.623-.622-.623H13.69zm.622 42.683V11.76h.311c.375 0 .622-.249.622-.623s-.247-.622-.622-.622h-.31V6.969h27.377v3.546h-.311c-.375 0-.622.248-.622.622s.247.622.622.622h.31V48.47H14.312z">
                                                    </path>
                                                    <path
                                                        d="M24.019 31.797c1.68 0 3.111-1.68 3.111-3.734 0-2.053-1.368-3.733-3.111-3.733-1.68 0-3.111 1.68-3.111 3.733 0 2.115 1.43 3.734 3.111 3.734zm1.803-3.673c0 .87-.374 1.68-.87 2.115a5.55 5.55 0 0 0-.374-.997c-.187-.31-.311-.622-.311-1.181s.124-.87.311-1.181c.124-.248.248-.498.374-.87.496.372.87 1.18.87 2.114zM23.708 25.7c-.063.248-.124.435-.248.622-.187.374-.498.87-.498 1.803 0 .934.248 1.369.498 1.743.124.248.248.435.311.685-.87-.187-1.555-1.18-1.555-2.425-.064-1.247.62-2.241 1.492-2.428zM29.181 30.054c-.685.685-1.12 1.556-1.244 2.426-.124.933.187 1.803.746 2.365.498.498 1.18.809 1.99.809h.375c.87-.124 1.742-.56 2.425-1.244 1.432-1.432 1.62-3.61.435-4.791-1.118-1.245-3.295-1.06-4.727.435zm3.485 3.422c-.498.498-1.057.81-1.68.87h-.434c.248-.374.311-.685.435-.996.124-.375.187-.686.622-1.058.435-.435.686-.498 1.057-.622.248-.063.56-.187.87-.374.064.749-.247 1.558-.87 2.18zm.188-3.174c-.188.124-.375.187-.623.248-.435.124-.933.31-1.618.933-.686.622-.81 1.181-.934 1.619a1.705 1.705 0 0 1-.31.685c-.188-.31-.312-.685-.249-1.12.063-.622.375-1.181.87-1.68.56-.559 1.308-.87 1.93-.87.372-.063.683-.002.934.185zM28.622 25.511c.81.81 1.867 1.245 2.8 1.245.746 0 1.493-.248 1.99-.81 1.182-1.181.997-3.359-.434-4.79-1.432-1.432-3.61-1.62-4.79-.436-1.185 1.182-.997 3.299.434 4.791zm.934-.933c-.499-.498-.81-1.058-.87-1.68v-.435c.374.248.685.311.996.435.374.124.685.187 1.057.622.435.436.499.686.622 1.058.064.248.188.559.375.87a2.608 2.608 0 0 1-2.18-.87zm2.552-2.552c.87.87 1.12 2.054.622 2.8-.124-.187-.187-.375-.248-.623-.124-.435-.311-.933-.933-1.618-.623-.686-1.182-.81-1.62-.934a1.705 1.705 0 0 1-.685-.31c.248-.188.56-.249.934-.249.685.064 1.368.375 1.93.934zM34.47 39.137H21.59c-.374 0-.622.247-.622.622 0 .374.248.622.622.622h12.88c.374 0 .622-.248.622-.622a.624.624 0 0 0-.622-.622zM25.822 11.759h1.245c.374 0 .622-.248.622-.622 0-.375-.248-.623-.622-.623h-1.245c-.374 0-.622.248-.622.623 0 .374.248.622.622.622zM17.733 10.514H16.49c-.374 0-.622.248-.622.623 0 .374.248.622.622.622h1.244c.375 0 .623-.248.623-.622 0-.372-.248-.623-.623-.623zM22.711 11.759h1.245c.374 0 .622-.248.622-.622 0-.375-.248-.623-.622-.623H22.71c-.374 0-.622.248-.622.623 0 .374.248.622.622.622zM39.511 10.514h-1.244c-.375 0-.623.248-.623.623 0 .374.248.622.623.622h1.244c.374 0 .622-.248.622-.622 0-.372-.248-.623-.622-.623zM32.044 11.759h1.245c.374 0 .622-.248.622-.622 0-.375-.248-.623-.622-.623h-1.245c-.374 0-.622.248-.622.623 0 .374.248.622.622.622zM28.933 11.759h1.245c.374 0 .622-.248.622-.622 0-.375-.248-.623-.622-.623h-1.245c-.374 0-.622.248-.622.623 0 .374.248.622.622.622zM21.467 11.137c0-.375-.248-.623-.623-.623H19.6c-.374 0-.622.248-.622.623 0 .374.248.622.622.622h1.244c.375 0 .623-.248.623-.622zM36.4 10.514h-1.244c-.375 0-.623.248-.623.623 0 .374.248.622.623.622H36.4c.374 0 .622-.248.622-.622 0-.372-.248-.623-.622-.623z">
                                                    </path>
                                                </g>
                                            </svg>
                                            <div class="button-group__label__text">Once off</div>
                                        </label></div>
                                    <div class="button-group__button"><input type="radio" id="subscription-true"
                                            name="subscription" value="true"> <label for="subscription-true"
                                            class="button-group__label"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="56" height="56" viewBox="0 0 56 56"
                                                class="injected-svg svg-icon button-group__label__icon"
                                                data-src="https://camposcoffee.com/wp-content/themes/campos-codeshare/assets/images/icons/subscription.svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <g fill="#000" fill-rule="evenodd">
                                                    <path
                                                        d="M44.49 12.407h-3.04V9.722h-1.555v2.685H36.4V9.722h-1.555v2.685H21.157V9.722h-1.555v2.685h-3.495l-.001-2.685H14.55v2.685H11.51c-1.2 0-2.177.915-2.177 2.041v29.789c0 1.124.978 2.041 2.177 2.041h32.98c1.2 0 2.177-.917 2.177-2.041V14.448c0-1.126-.977-2.041-2.177-2.041zm-32.98 1.555h3.04v2.685h1.555v-2.685H19.6v2.685h1.555v-2.685h13.688v2.685h1.555v-2.685h3.495v2.685h1.555v-2.685h3.04c.34 0 .624.222.624.486v4.583H10.888v-4.583c0-.264.285-.486.622-.486zm32.98 30.76H11.51c-.337 0-.622-.223-.622-.485V20.586H45.11v23.65c.002.263-.283.486-.62.486z">
                                                    </path>
                                                    <path
                                                        d="M23.471 35.714c1.596 0 2.956-1.596 2.956-3.547s-1.3-3.547-2.956-3.547c-1.595 0-2.955 1.596-2.955 3.547 0 2.009 1.358 3.547 2.955 3.547zm1.714-3.49c0 .827-.356 1.596-.827 2.01a5.273 5.273 0 0 0-.356-.947c-.177-.296-.295-.591-.295-1.122 0-.531.118-.827.295-1.123.118-.235.236-.473.356-.826.471.353.827 1.122.827 2.009zm-2.01-2.304c-.06.236-.117.414-.235.591-.177.356-.473.827-.473 1.714 0 .886.235 1.3.473 1.655.118.236.236.414.296.651-.827-.177-1.478-1.122-1.478-2.304-.06-1.184.589-2.129 1.418-2.307zM28.375 34.058c-.65.651-1.064 1.478-1.182 2.304-.118.887.178 1.714.709 2.247a2.627 2.627 0 0 0 1.891.769h.356c.826-.118 1.655-.531 2.304-1.182 1.36-1.36 1.538-3.43.413-4.551-1.062-1.183-3.13-1.007-4.49.413zm3.311 3.251c-.473.473-1.004.769-1.595.827h-.413c.235-.356.295-.652.413-.947.118-.356.178-.651.591-1.004.413-.414.651-.474 1.004-.592.236-.06.532-.177.827-.355.06.711-.235 1.48-.827 2.071zm.178-3.016c-.178.118-.355.178-.59.236-.414.118-.888.296-1.539.887-.65.59-.769 1.122-.886 1.537a1.62 1.62 0 0 1-.296.652c-.178-.296-.295-.652-.235-1.065.06-.591.355-1.122.826-1.595.531-.531 1.242-.827 1.834-.827.353-.06.648-.002.886.175zM27.844 29.742c.77.77 1.774 1.182 2.66 1.182.71 0 1.418-.235 1.892-.768 1.122-1.123.946-3.192-.414-4.552-1.36-1.36-3.429-1.537-4.55-.413-1.125 1.122-.948 3.133.412 4.551zm.887-.886c-.473-.474-.769-1.005-.826-1.596v-.413c.355.235.65.295.946.413.356.118.651.178 1.005.591.413.413.473.651.59 1.005.06.235.179.53.356.826a2.478 2.478 0 0 1-2.07-.826zm2.425-2.425c.826.827 1.064 1.951.59 2.66-.117-.178-.177-.356-.235-.591-.118-.413-.295-.887-.886-1.538-.592-.651-1.123-.769-1.538-.887a1.62 1.62 0 0 1-.651-.295c.235-.178.53-.236.886-.236.651.06 1.3.356 1.834.887z">
                                                    </path>
                                                </g>
                                            </svg>
                                            <div class="button-group__label__text">Subscription</div>
                                        </label></div>
                                </div>
                                <div class="add-to-cart__fields add-to-cart__fields--hidden">
                                    <div class="radio"><input type="radio" id="pa_frequency-weekly" name="pa_frequency"
                                            value="weekly"> <label for="pa_frequency-weekly">Weekly</label></div>
                                    <div class="radio"><input type="radio" id="pa_frequency-fortnightly"
                                            name="pa_frequency" value="fortnightly"> <label
                                            for="pa_frequency-fortnightly">Fortnightly</label></div>
                                    <div class="radio"><input type="radio" id="pa_frequency-monthly" name="pa_frequency"
                                            value="monthly"> <label for="pa_frequency-monthly">Monthly</label></div>
                                </div>
                                <div class="add-to-cart__quantity">
                                    <div class="quantity-input"><a
                                            class="quantity-input__icon quantity-input__icon--minus quantity-input__icon--disabled"></a>
                                        <input type="tel" name="quantity-input"> <a
                                            class="quantity-input__icon quantity-input__icon--plus"></a></div>
                                </div> <a class="button add-to-cart__button">
                                    <div>Select Bag Size</div>
                                </a>
                                <!---->
                            </form>
                        </div>
                        <div class="single-product__content__details">
                            <div class="single-product__content__details__description">
                                <h3>About this espresso coffee</h3>
                                <div class="page" title="Page 2">
                                    <div class="layoutArea">
                                        <div class="column">
                                            <p>Our darkest roast, Southern Italian style. A chocolatey, full rich cup.
                                                If you want powerful then this is the one. Big cocoa flavours, perfect
                                                with milk.</p>
                                        </div>
                                    </div>
                                </div>
                                <p><span id="ctl00_MainContent_lblSummary" class="summary">A touch of extremely high
                                        quality robusta makes this one very different from our usual 100% arabica
                                        blends.</span></p>
                                <p><span id="ctl00_MainContent_lblSummary" class="summary">Very flavourful and not for
                                        the faint-hearted.</span></p>
                            </div>
                            <div class="single-product__content__information">
                                <h3 class="single-product__content__information__section-title">
                                    INFORMATION
                                </h3>
                                <div class="grid-x medium-up-2">
                                    <div class="cell">
                                        <div class="single-product__content__information__item-title">Varietal</div>
                                        <div class="single-product__content__information__item-description">Arabican
                                            varietals with one high altitude Robusta</div>
                                    </div>
                                    <div class="cell">
                                        <div class="single-product__content__information__item-title">Certifications
                                        </div>
                                        <div class="single-product__content__information__item-description">Contains
                                            coffee from Rainforest Alliance farms</div>
                                    </div>
                                    <div class="cell">
                                        <div class="single-product__content__information__item-title">Cupping Notes
                                        </div>
                                        <div class="single-product__content__information__item-description">Powerful,
                                            chocolatey with milk, thick crema</div>
                                    </div>
                                </div>
                            </div>
                            <div class="content-accordion">
                                <div class="content-accordion__section accordion__section">
                                    <h5 class="content-accordion__toggle accordion__toggle">About robusta coffee</h5>
                                    <div class="content-accordion__content accordion__content">
                                        <p>Using the highest quality robusta coffee and roasting very dark, this one has
                                            the most aggressive flavour profile of all our blends.</p>
                                        <p>The robusta component stays below 15%, but still delivers its comparatively
                                            harsh chocolatey influence on the whole blend.</p>
                                        <p>Overall, the blend comes through beautifully in milk coffees (chocolate
                                            milkshake flavour with the sweetness brought on by high quality arabicas)
                                            and quite well in black, though, again, a little on the more powerful side,
                                            so it is not for the faint hearted.</p>
                                        <p>Interesting on the robusta – most robusta are significantly lower in quality
                                            and taste – this one is grown at the same altitude as most specialty
                                            arabican coffees.</p>
                                        <p>The sorting is as meticulous and the product is as good as it can get when it
                                            comes to Robusta.&nbsp; We thought we just had to give this coffee a chance
                                            and we are very happy with the results.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<div class="row no-margin">
    <section class="col-12 product-detail">
        <div class="layouter">
            <product-view>
                <div class="form-container">
                    @csrf()

                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                    {{-- product-gallery --}}
                    <div class="left col-lg-5">
                        @include ('shop::products.view.gallery')
                    </div>

                    {{-- right-section --}}
                    <div class="right col-lg-7">
                        {{-- product-info-section --}}
                        <div class="row info">
                            <h2 class="col-lg-12">{{ $product->name }}</h2>

                            @if ($total)
                            <div class="reviews col-lg-12">
                                <star-ratings push-class="mr5" :ratings="{{ $avgStarRating }}"></star-ratings>

                                <div class="reviews">
                                    <span>
                                        {{ __('shop::app.reviews.ratingreviews', [
                                                        'rating' => $avgRatings,
                                                        'review' => $total])
                                                    }}
                                    </span>
                                </div>
                            </div>
                            @endif
                            {{ __('shop::app.reviews.ratingreviews', [
                                                        'rating' => $avgRatings,
                                                        'review' => $total])
                                                    }}          
                            @include ('shop::products.view.stock', ['product' => $product])

                            <div class="col-12 price">
                                @include ('shop::products.price', ['product' => $product])
                            </div>

                            <div class="product-actions">
                                @include ('shop::products.add-to-cart', [
                                'form' => false,
                                'product' => $product,
                                'showCartIcon' => false,
                                'showCompare' => core()->getConfigData('general.content.shop.compare_option') == "1"
                                ? true : false,
                                ])
                            </div>
                        </div>

                        {!! view_render_event('bagisto.shop.products.view.short_description.before', ['product' =>
                        $product]) !!}

                        @if ($product->short_description)
                        <div class="description">
                            <h3 class="col-lg-12">{{ __('velocity::app.products.short-description') }}</h3>

                            {!! $product->short_description !!}
                        </div>
                        @endif

                        {!! view_render_event('bagisto.shop.products.view.short_description.after', ['product' =>
                        $product]) !!}


                        {!! view_render_event('bagisto.shop.products.view.quantity.before', ['product' => $product]) !!}

                        @if ($product->getTypeInstance()->showQuantityBox())
                        <div>
                            <quantity-changer></quantity-changer>
                        </div>
                        @else
                        <input type="hidden" name="quantity" value="1">
                        @endif

                        {!! view_render_event('bagisto.shop.products.view.quantity.after', ['product' => $product]) !!}

                        @include ('shop::products.view.configurable-options')

                        @include ('shop::products.view.downloadable')

                        @include ('shop::products.view.grouped-products')

                        @include ('shop::products.view.bundle-options')

                        @include ('shop::products.view.attributes', [
                        'active' => true
                        ])

                        {{-- product long description --}}
                        @include ('shop::products.view.description')

                        {{-- reviews count --}}
                        @include ('shop::products.view.reviews', ['accordian' => true])
                    </div>
                </div>
            </product-view>
        </div>
    </section>

    <div class="related-products">
        @include('shop::products.view.related-products')
        @include('shop::products.view.up-sells')
    </div>

    <div class="store-meta-images col-3">
        @if(
        isset($velocityMetaData['product_view_images'])
        && $velocityMetaData['product_view_images']
        )
        @foreach (json_decode($velocityMetaData['product_view_images'], true) as $image)
        @if ($image && $image !== '')
        <img src="{{ url()->to('/') }}/storage/{{ $image }}" />
        @endif
        @endforeach
        @endif
    </div>
</div>
{!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}
@endsection

@push('scripts')
<script type='text/javascript' src='https://unpkg.com/spritespin@4.1.0/release/spritespin.js'></script>

<script type="text/x-template" id="product-view-template">
        <form
            method="POST"
            id="product-form"
            @click="onSubmit($event)"
            action="{{ route('cart.add', $product->product_id) }}">

            <input type="hidden" name="is_buy_now" v-model="is_buy_now">

            <slot v-if="slot"></slot>

            <div v-else>
                <div class="spritespin"></div>
            </div>

        </form>
    </script>

<script>
    Vue.component('product-view', {
        inject: ['$validator'],
        template: '#product-view-template',
        data: function () {
            return {
                slot: true,
                is_buy_now: 0,
            }
        },

        mounted: function () {
            let currentProductId = '{{ $product->url_key }}';
            let existingViewed = window.localStorage.getItem('recentlyViewed');

            if (!existingViewed) {
                existingViewed = [];
            } else {
                existingViewed = JSON.parse(existingViewed);
            }

            if (existingViewed.indexOf(currentProductId) == -1) {
                existingViewed.push(currentProductId);

                if (existingViewed.length > 3)
                    existingViewed = existingViewed.slice(Math.max(existingViewed.length - 4, 1));

                window.localStorage.setItem('recentlyViewed', JSON.stringify(existingViewed));
            } else {
                var uniqueNames = [];

                $.each(existingViewed, function (i, el) {
                    if ($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                });

                uniqueNames.push(currentProductId);

                uniqueNames.splice(uniqueNames.indexOf(currentProductId), 1);

                window.localStorage.setItem('recentlyViewed', JSON.stringify(uniqueNames));
            }
        },

        methods: {
            onSubmit: function (event) {
                if (event.target.getAttribute('type') != 'submit')
                    return;

                event.preventDefault();

                this.$validator.validateAll().then(result => {
                    if (result) {
                        this.is_buy_now = event.target.classList.contains('buynow') ? 1 : 0;

                        setTimeout(function () {
                            document.getElementById('product-form').submit();
                        }, 0);
                    }
                });
            },
        }
    });

    window.onload = function () {
        var thumbList = document.getElementsByClassName('thumb-list')[0];
        var thumbFrame = document.getElementsByClassName('thumb-frame');
        var productHeroImage = document.getElementsByClassName('product-hero-image')[0];

        if (thumbList && productHeroImage) {
            for (let i = 0; i < thumbFrame.length; i++) {
                thumbFrame[i].style.height = (productHeroImage.offsetHeight / 4) + "px";
                thumbFrame[i].style.width = (productHeroImage.offsetHeight / 4) + "px";
            }

            if (screen.width > 720) {
                thumbList.style.width = (productHeroImage.offsetHeight / 4) + "px";
                thumbList.style.minWidth = (productHeroImage.offsetHeight / 4) + "px";
                thumbList.style.height = productHeroImage.offsetHeight + "px";
            }
        }

        window.onresize = function () {
            if (thumbList && productHeroImage) {

                for (let i = 0; i < thumbFrame.length; i++) {
                    thumbFrame[i].style.height = (productHeroImage.offsetHeight / 4) + "px";
                    thumbFrame[i].style.width = (productHeroImage.offsetHeight / 4) + "px";
                }

                if (screen.width > 720) {
                    thumbList.style.width = (productHeroImage.offsetHeight / 4) + "px";
                    thumbList.style.minWidth = (productHeroImage.offsetHeight / 4) + "px";
                    thumbList.style.height = productHeroImage.offsetHeight + "px";
                }
            }
        }
    };
</script>
@endpush