@push('scripts')
    <script type="text/x-template" id="cart-btn-template">
        <!-- <button
            type="button"
            id="mini-cart"
            @click="toggleMiniCart"
            :class="`btn btn-link disable-box-shadow ${itemCount == 0 ? 'cursor-not-allowed' : ''}`">

          
            <div class="down-arrow-container">
                <span class="rango-arrow-down"></span>
            </div> -->
            <a  alt="Shopping Cart" class="mini-cart" id="mini-cart"  @click="toggleMiniCart">
                       
                        <span class="mini-cart__cart-count" v-text="itemCount" v-if="itemCount != 0"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="19" viewBox="0 0 21 19" class="injected-svg svg-icon mini-cart__icon" data-src="https://camposcoffee.com/wp-content/themes/campos-codeshare/assets/images/icons/cart.svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M15.867 15.713a.836.836 0 1 0 .835.835.836.836 0 0 0-.835-.835m0 2.616c-.982 0-1.782-.799-1.782-1.781 0-.983.8-1.783 1.782-1.783.983 0 1.782.8 1.782 1.783 0 .982-.8 1.781-1.782 1.781M17.206 13.44H7.066M7.08 13.914h10.126a.474.474 0 0 0 0-.948H7.428L4.166.825A.473.473 0 0 0 3.71.474H.474a.474.474 0 0 0 0 .947h2.872l3.26 12.133a.473.473 0 0 0 .474.36z"></path><path d="M6.712 10.295h11.113l1.706-6.303H5.016l1.696 6.303zm11.475.947H6.349a.474.474 0 0 1-.458-.35L3.941 3.64a.475.475 0 0 1 .457-.597H20.15a.474.474 0 0 1 .457.597l-1.963 7.251a.474.474 0 0 1-.457.35zM8.998 15.713a.836.836 0 1 0 .835.835.836.836 0 0 0-.835-.835m0 2.616c-.983 0-1.782-.799-1.782-1.781 0-.983.8-1.783 1.782-1.783.983 0 1.782.8 1.782 1.783 0 .982-.8 1.781-1.782 1.781M10.828 10.461L8.68 3.698"></path><path d="M10.828 10.935a.474.474 0 0 1-.451-.33L8.227 3.84a.473.473 0 1 1 .904-.286l2.149 6.763a.474.474 0 0 1-.452.617M16.234 10.461l-2.149-6.763M16.234 10.935a.474.474 0 0 1-.452-.33L13.633 3.84a.473.473 0 1 1 .903-.286l2.15 6.763a.474.474 0 0 1-.452.617"></path></svg>
            </a>
        <!-- </button> -->
        
    </script>

    <script type="text/x-template" id="close-btn-template">
        <button type="button" class="close disable-box-shadow">
            <span class="white-text fs20" @click="togglePopup">×</span>
        </button>
    </script>

    <script type="text/x-template" id="quantity-changer-template">
        <div :class="`quantity control-group ${errors.has(controlName) ? 'has-error' : ''}`">
            <label class="required">{{ __('shop::app.products.quantity') }}</label>
            <button type="button" class="decrease" @click="decreaseQty()">-</button>

            <input
                :value="qty"
                class="control"
                :name="controlName"
                :v-validate="validations"
                data-vv-as="&quot;{{ __('shop::app.products.quantity') }}&quot;"
                readonly />

            <button type="button" class="increase" @click="increaseQty()">+</button>

            <span class="control-error" v-if="errors.has(controlName)">@{{ errors.first(controlName) }}</span>
        </div>
    </script>
@endpush

<!-- @include('velocity::UI.header') -->

@push('scripts')
    <script type="text/x-template" id="logo-template">
        <div class="header__logo-container">
            <a
                :class="`header__logo-container__link`"
                href="{{ route('shop.home.index') }}">

                @if ($logo = core()->getCurrentChannel()->logo_url)
                    <img class="logo" src="{{ $logo }}" width="48" />
                @else
                    <img class="logo" src="{{ asset('themes/velocity/assets/images/logo-text.png') }}" />
                @endif
            </a>
        </div>
    </script>

    <script type="text/x-template" id="searchbar-template">
        <div class="row no-margin right searchbar">
            <div class="col-lg-5 col-md-12 no-padding input-group">
                
                <!-- <form
                    method="GET"
                    role="search"
                    id="search-form"
                    action="{{ route('velocity.search.index') }}">

                    <div
                        class="btn-toolbar full-width"
                        role="toolbar">

                        <div class="btn-group full-width">
                            <div class="selectdiv">
                                <select class="form-control fs13 styled-select" name="category" @change="focusInput($event)">
                                    <option value="">
                                        {{ __('velocity::app.header.all-categories') }}
                                    </option>

                                    <template v-for="(category, index) in $root.sharedRootCategories">
                                        <option
                                            :key="index"
                                            selected="selected"
                                            :value="category.id"
                                            v-if="(category.id == searchedQuery.category)">
                                            @{{ category.name }}
                                        </option>

                                        <option :key="index" :value="category.id" v-else>
                                            @{{ category.name }}
                                        </option>
                                    </template>
                                </select>

                                <div class="select-icon-container">
                                    <span class="select-icon rango-arrow-down"></span>
                                </div>
                            </div>

                            <div class="full-width">

                                <input
                                    required
                                    name="term"
                                    type="search"
                                    class="form-control"
                                    placeholder="{{ __('velocity::app.header.search-text') }}"
                                    :value="searchedQuery.term ? decodeURIComponent(searchedQuery.term.split('+').join(' ')) : ''" />

                                <image-search-component></image-search-component>

                                <button class="btn" type="submit" id="header-search-icon">
                                    <i class="fs16 fw6 rango-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </form> -->
            </div>

            <!-- <div class="col-lg-7 col-md-12">
                {!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}
                    @include('shop::checkout.cart.mini-cart')
                {!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}

              
                

                
            </div> -->
        </div>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet" defer></script>

    <script type="text/x-template" id="image-search-component-template">
        <div class="d-inline-block">
            <label class="image-search-container" for="image-search-container">
                <i class="icon camera-icon"></i>

                <input
                    type="file"
                    class="d-none"
                    ref="image_search_input"
                    id="image-search-container"
                    v-on:change="uploadImage()" />

                <img
                    class="d-none"
                    id="uploaded-image-url"
                    :src="uploadedImageUrl" />
            </label>
        </div>
    </script>

    <script type="text/javascript">
        (() => {
            Vue.component('cart-btn', {
                template: '#cart-btn-template',

                props: ['itemCount'],

                methods: {
                    toggleMiniCart: function () {
                        let modal = $('#cart-modal-content')[0];
                        if (modal)
                            modal.classList.toggle('hide');

                        let accountModal = $('.account-modal')[0];
                        if (accountModal)
                            accountModal.classList.add('hide');

                        event.stopPropagation();
                    }
                }
            });

            Vue.component('close-btn', {
                template: '#close-btn-template',

                methods: {
                    togglePopup: function () {
                        $('#cart-modal-content').hide();
                    }
                }
            });

            Vue.component('quantity-changer', {
                template: '#quantity-changer-template',
                inject: ['$validator'],
                props: {
                    controlName: {
                        type: String,
                        default: 'quantity'
                    },

                    quantity: {
                        type: [Number, String],
                        default: 1
                    },

                    minQuantity: {
                        type: [Number, String],
                        default: 1
                    },

                    validations: {
                        type: String,
                        default: 'required|numeric|min_value:1'
                    }
                },

                data: function() {
                    return {
                        qty: this.quantity
                    }
                },

                watch: {
                    quantity: function (val) {
                        this.qty = val;

                        this.$emit('onQtyUpdated', this.qty)
                    }
                },

                methods: {
                    decreaseQty: function() {
                        if (this.qty > this.minQuantity)
                            this.qty = parseInt(this.qty) - 1;

                        this.$emit('onQtyUpdated', this.qty)
                    },

                    increaseQty: function() {
                        this.qty = parseInt(this.qty) + 1;

                        this.$emit('onQtyUpdated', this.qty)
                    }
                }
            });

            Vue.component('logo-component', {
                template: '#logo-template',
                props: ['addClass'],
            });

            Vue.component('searchbar-component', {
                template: '#searchbar-template',
                data: function () {
                    return {
                        compareCount: 0,
                        wishlistCount: 0,
                        searchedQuery: [],
                        isCustomer: '{{ auth()->guard('customer')->user() ? "true" : "false" }}' == "true",
                    }
                },

                watch: {
                    '$root.headerItemsCount': function () {
                        this.updateHeaderItemsCount();
                    }
                },

                created: function () {
                    let searchedItem = window.location.search.replace("?", "");
                    searchedItem = searchedItem.split('&');

                    let updatedSearchedCollection = {};

                    searchedItem.forEach(item => {
                        let splitedItem = item.split('=');
                        updatedSearchedCollection[splitedItem[0]] = decodeURI(splitedItem[1]);
                    });

                    if (updatedSearchedCollection['image-search'] == 1) {
                        updatedSearchedCollection.term = '';
                    }

                    this.searchedQuery = updatedSearchedCollection;

                    this.updateHeaderItemsCount();
                },

                methods: {
                    'focusInput': function (event) {
                        $(event.target.parentElement.parentElement).find('input').focus();
                    },

                    'updateHeaderItemsCount': function () {
                        if (! this.isCustomer) {
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
                    }
                }
            });

            Vue.component('image-search-component', {
                template: '#image-search-component-template',
                data: function() {
                    return {
                        uploadedImageUrl: ''
                    }
                },

                methods: {
                    uploadImage: function() {
                        var imageInput = this.$refs.image_search_input;

                        if (imageInput.files && imageInput.files[0]) {
                            if (imageInput.files[0].type.includes('image/')) {
                                this.$root.showLoader();

                                var formData = new FormData();

                                formData.append('image', imageInput.files[0]);

                                axios.post(
                                    "{{ route('shop.image.search.upload') }}",
                                    formData,
                                    {
                                        headers: {
                                            'Content-Type': 'multipart/form-data'
                                        }
                                    }
                                ).then(response => {
                                    var net;
                                    var self = this;
                                    this.uploadedImageUrl = response.data;


                                    async function app() {
                                        var analysedResult = [];

                                        var queryString = '';

                                        net = await mobilenet.load();

                                        const imgElement = document.getElementById('uploaded-image-url');

                                        try {
                                            const result = await net.classify(imgElement);

                                            result.forEach(function(value) {
                                                queryString = value.className.split(',');

                                                if (queryString.length > 1) {
                                                    analysedResult = analysedResult.concat(queryString)
                                                } else {
                                                    analysedResult.push(queryString[0])
                                                }
                                            });
                                        } catch (error) {
                                            self.$root.hideLoader();

                                            window.showAlert(
                                                `alert-danger`,
                                                this.__('shop.general.alert.error'),
                                                "{{ __('shop::app.common.error') }}"
                                            );
                                        }

                                        localStorage.searchedImageUrl = self.uploadedImageUrl;

                                        queryString = localStorage.searched_terms = analysedResult.join('_');

                                        self.$root.hideLoader();

                                        window.location.href = "{{ route('shop.search.index') }}" + '?term=' + queryString + '&image-search=1';
                                    }

                                    app();
                                }).catch(() => {
                                    this.$root.hideLoader();

                                    window.showAlert(
                                        `alert-danger`,
                                        this.__('shop.general.alert.error'),
                                        "{{ __('shop::app.common.error') }}"
                                    );
                                });
                            } else {
                                imageInput.value = '';

                                alert('Only images (.jpeg, .jpg, .png, ..) are allowed.');
                            }
                        }
                    }
                }
            });
        })()
    </script>
@endpush