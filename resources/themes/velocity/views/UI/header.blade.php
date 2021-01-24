@push('scripts')
<script type="text/x-template" id="logo-template">
        <a
            :class="`left ${addClass}`"
            href="{{ route('shop.home.index') }}">

            @if ($logo = core()->getCurrentChannel()->logo_url)
                <img class="logo" src="{{ $logo }}" />
            @else
                <img class="logo" src="{{ asset('themes/velocity/assets/images/logo-text.png') }}" />
            @endif
        </a>
    </script>
<script type="text/x-template" id="content-header-template">

        <header class="header">
            
           
        
            <div class="header__inner">
                <a class="header__trigger" title="Toggle Menu" v-on:click="toggleHamburger()">
                    <span class="header__trigger__hamburger"></span>
                </a>
                <logo-component></logo-component>
                <nav class="menu">
                
                <a class="header__trigger" title="Toggle Menu" v-on:click="toggleHamburger()">
<span class="header__trigger__hamburger"></span>
</a>
                        <ul id="menu-main-menu" class="menu__ul">
                            <li v-for="(content, index) in headerContent" :key="index" class="menu-item menu-item-type-post_type menu-item-object-page menu__ul__li">
                                <a
                                    class="menu__ul__li__a"
                                    v-text="content.title"
                                    :href="`${$root.baseUrl}/${content['page_link']}`"
                                    v-if="(content['content_type'] == 'link' || content['content_type'] == 'category')"
                                    :target="content['link_target'] ? '_blank' : '_self'">
                                </a>
                            </li>
                        </ul>
                        <nav class="user-controls">
                            <ul class="user-controls__ul">
                                <li class="user-controls__ul__li user-controls__ul__li--search">
                                <form role="search" method="get" id="search" class="search" action="/">
                                <input type="text" class="search__input" value="" name="s" id="s" required="">
                                <label for="s" class="search__label">Search</label>
                                <input type="image" class="search__button" id="searchsubmit" src="https://camposcoffee.com/wp-content/themes/campos-codeshare/assets/images/icons/search.svg">
                                </form>
                                </li>
                                <li class="user-controls__ul__li user-controls__ul__li--account">
                                <a class="user-controls__ul__li__a" href="https://camposcoffee.com/my-account/">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18" class="injected-svg svg-icon user-controls__ul__li__a__icon" data-src="https://camposcoffee.com/wp-content/themes/campos-codeshare/assets/images/icons/login.svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M8.237 1.029a3.883 3.883 0 0 0-3.88 3.878c0 2.14 1.741 3.88 3.88 3.88s3.879-1.74 3.879-3.88a3.883 3.883 0 0 0-3.88-3.878m0 8.786A4.913 4.913 0 0 1 3.33 4.907 4.913 4.913 0 0 1 8.237 0a4.913 4.913 0 0 1 4.907 4.907 4.913 4.913 0 0 1-4.907 4.908"></path><path d="M1.047 16.509h14.38c-.265-3.735-3.388-6.694-7.19-6.694-3.802 0-6.925 2.959-7.19 6.694m14.912 1.028H.514A.514.514 0 0 1 0 17.023c0-4.541 3.695-8.237 8.236-8.237 4.543 0 8.238 3.696 8.238 8.237 0 .284-.23.514-.515.514"></path></svg>
                                <span class="user-controls__ul__li__a__label">Log in or Register</span>
                                </a>
                                </li>
                            
                            </ul>
                        </nav>
                        
</nav>

{!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}
@include('shop::checkout.cart.mini-cart')
{!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}


<div class="menu__region-toggle">
    <div class="menu__region-toggle__inner">
        
            <ul class="menu__region-toggle__inner__ul">
                @php
                $localeImage = null;
                
                @endphp
                @foreach (core()->getCurrentChannel()->locales as $locale)
                <li class="menu__region-toggle__inner__ul__li">
                    <a class="menu__region-toggle__inner__ul__li__a" href="/?locale={{ $locale->code }}">
                        <img src="{{ asset('/storage/' . $locale->locale_image) }}" width="24" class="menu__region-toggle__inner__ul__li__a__flag">
                        {{ $locale->name}} 
                    </a>

                </li>
                @if (app()->getLocale() == $locale->code)
                    @php
                    $localeImage = $locale->locale_image;
                    @endphp
                @endif
                @endforeach
            </ul>
            <div class="menu__region-toggle__inner__current">    
                
                <img  src="{{ asset('/storage/' . $localeImage) }}" width="24"  class="menu__region-toggle__inner__current__flag">
            </div>
        </div>
    </div>
</div>

</header>
</script>
@endpush

@php
$cart = cart()->getCart();

$cartItemsCount = trans('shop::app.minicart.zero');

if ($cart) {
$cartItemsCount = $cart->items->count();
}
@endphp

@push('scripts')
<script type="text/javascript">
    (() => {

        Vue.component('content-header', {
            template: '#content-header-template',
            props: [
                'heading',
                'headerContent',
                'categoryCount',
            ],

            data: function () {
                return {
                    'compareCount': 0,
                    'wishlistCount': 0,
                    'languages': false,
                    'hamburger': false,
                    'currencies': false,
                    'subCategory': null,
                    'isSearchbar': false,
                    'rootCategories': true,
                    'cartItemsCount': '{{ $cartItemsCount }}',
                    'rootCategoriesCollection': this.$root.sharedRootCategories,
                    'isCustomer': '{{ auth()->guard('customer')->user() ? "true" : "false" }}' == "true",
                }
            },

            watch: {
                hamburger: function (value) {
                    if (value) {
                        document.body.classList.add('header--open');
                    } else {
                        document.body.classList.remove('header--open');
                    }
                },

                '$root.headerItemsCount': function () {
                    this.updateHeaderItemsCount();
                },

                '$root.miniCartKey': function () {
                    this.getMiniCartDetails();
                },

                '$root.sharedRootCategories': function (categories) {
                    this.formatCategories(categories);
                }
            },

            created: function () {
                this.getMiniCartDetails();
                this.updateHeaderItemsCount();
            },

            methods: {
                openSearchBar: function () {
                    this.isSearchbar = !this.isSearchbar;

                    let footer = $('.footer');
                    let homeContent = $('#home-right-bar-container');

                    if (this.isSearchbar) {
                        footer[0].style.opacity = '.3';
                        homeContent[0].style.opacity = '.3';
                    } else {
                        footer[0].style.opacity = '1';
                        homeContent[0].style.opacity = '1';
                    }
                },

                toggleHamburger: function () {
                    this.hamburger = !this.hamburger;
                },

                closeDrawer: function () {
                    $('.nav-container').hide();

                    this.toggleHamburger();
                    this.rootCategories = true;
                },

                toggleSubcategories: function (index, event) {
                    if (index == "root") {
                        this.rootCategories = true;
                        this.subCategory = false;
                    } else {
                        event.preventDefault();

                        let categories = this.$root.sharedRootCategories;
                        this.rootCategories = false;
                        this.subCategory = categories[index];
                    }
                },

                toggleMetaInfo: function (metaKey) {
                    this.rootCategories = !this.rootCategories;

                    this[metaKey] = !this[metaKey];
                },

                updateHeaderItemsCount: function () {
                    if (!this.isCustomer) {
                        let comparedItems = this.getStorageValue('compared_product');
                        let wishlistedItems = this.getStorageValue('wishlist_product');

                        if (wishlistedItems) {
                            this.wishlistCount = wishlistedItems.length;
                        }

                        if (comparedItems) {
                            this.compareCount = comparedItems.length;
                        }
                    } else {
                        this.$http.get(`${this.$root.baseUrl}/items-count`)
                            .then(response => {
                                this.compareCount = response.data.compareProductsCount;
                                this.wishlistCount = response.data.wishlistedProductsCount;
                            })
                            .catch(exception => {
                                console.log(this.__('error.something_went_wrong'));
                            });
                    }
                },

                getMiniCartDetails: function () {
                    this.$http.get(`${this.$root.baseUrl}/mini-cart`)
                        .then(response => {
                            if (response.data.status) {
                                this.cartItemsCount = response.data.mini_cart.cart_items.length;
                            }
                        })
                        .catch(exception => {
                            console.log(this.__('error.something_went_wrong'));
                        });
                },

                formatCategories: function (categories) {
                    let slicedCategories = categories;
                    let categoryCount = this.categoryCount ? this.categoryCount : 9;

                    if (
                        slicedCategories
                        && slicedCategories.length > categoryCount
                    ) {
                        slicedCategories = categories.slice(0, categoryCount);
                    }

                    this.rootCategoriesCollection = slicedCategories;
                },
            },
        });
    })()
</script>
@endpush