@extends('admin::layouts.master')

@section('page_title')
{{ __('admin::app.sales.orders.view-title', ['order_id' => '']) }}
@stop

@section('content-wrapper')
<create></create>
@stop

@push('scripts')

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>

<script type="text/x-template" id="create-template">
    <div class="content full-page">

<div class="page-header">

    <div class="page-title">
        <h1>
           

            <i class="icon angle-left-icon back-link" onclick="window.location = history.length > 1 ? document.referrer : '{{ route('admin.dashboard.index') }}'"></i>

            {{ __('admin::app.sales.orders.view-title', ['order_id' => '']) }}

           
        </h1>
    </div>
   

    <div class="page-action"><button type="submit" v-on:click="submit()" class="btn btn-lg btn-primary" style="width:120px" :disabled="loading">
            <span v-if="!loading">Save Order</span>
            <div v-if="loading" class="spinner-border m-5">
  
            </div>
        </button></div>

</div>

<div class="page-content">

    <tabs>
       

        <tab name="{{ __('admin::app.sales.orders.info') }}" :selected="true">
            <div class="sale-container">
                <accordian :title="'{{ __('admin::app.sales.orders.order-and-account') }}'" :active="true">
                    <div slot="body">



                        <div class="sale-section">
                            <!-- <div class="secton-title">
                                    <span>{{ __('admin::app.sales.orders.account-info') }}</span>
                                </div> -->

                            <div class="section-content" >
                            <div class="row">
                                <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                    <label for="name" class="required">Name</label>
                                    <input type="text" id="name" class="control" placeholder="Enter customer name" v-validate="'required'" name="name" v-model="order.customer_first_name">
                                    <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                                </div>
                                <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                                    <label for="phone" class="required">Phone</label>
                                    <input type="text" id="phone" class="control" placeholder="Enter customer phone number" v-validate="'required'" name="phone" v-model="order.billing_address.phone">
                                    <span class="control-error" v-if="errors.has('name')">@{{ errors.first('phone') }}</span>
                                </div>
                                </div>
                                <div class="control-group" :class="[errors.has('address') ? 'has-error' : '']">
                                    <label for="phone" >Address</label>
                                    <input type="text" class="control" placeholder="Enter address" name="address"  v-model="order.billing_address.address1">
                                    <span class="control-error" v-if="errors.has('address')">@{{ errors.first('address') }}</span>
                                </div>
                                <!-- <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.customer-name') }}
                                    </span>

                                    <span class="value">
                                       
                                    </span>


                                </div>

                               

                                <div class="row">
                                    <span class="title">
                                        Phone
                                    </span>

                                    <span class="value">
                                        0377035247
                                    </span>
                                </div>
                                <a href="#">Change</a> -->


                            </div>
                        </div>

                    </div>
                </accordian>
                <!-- <accordian :title="'{{ __('admin::app.sales.orders.address') }}'" :active="true">
                    <div slot="body">

                        <div class="sale-section">
                            <div class="section-content">
                                
                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.address') }}
                                    </span>

                                    <span class="value">
                                        186bis Trần Quang Khải, Tân Định, Quận 1, Hồ Chí Minh,Việt Nam
                                    </span>
                                </div>
                                <a href="#">Change</a>

                               
                            </div>
                        </div>
                        

                    </div>
                </accordian> -->
                <accordian :title="'{{ __('admin::app.sales.orders.products-ordered') }}'" :active="true">
                    <div slot="body">
                        <div class="control-group" :class="[errors.has('first_name') ? 'has-error' : '']">

                            <div class="profile-info">
                                <input autocomplete="off" type="text" class="control dropdown-toggle" v-model="search_key" placeholder="Enter product SKU or name" >
                                <div class="dropdown-list bottom" style="width:100%; display: none;">
                                    <div class="dropdown-container" style="height:50vh">
                                        <ul >
                                            <li v-for="product in products" class="row" style="padding:0px">

                                                <div class="col-12" style="width:100%" v-if="product.url_key.indexOf(search_key) > -1 || product.search_name.indexOf(search_key) >-1">
                                                    <div class="row">
                                                        <label class="inline_block ml10" data-bind="text:Value" v-html="product.name"></label>
                                                        <div class="" v-if="product.images.length > 0">
                                                            <img class="thumb-image" :src="product.images[0].url" style="width:50px">
                                                        </div>
                                                    </div>
                                                    <ul class="list-group" v-if="product.variants.length > 0">
                                                        <li v-for="variant in product.variants" class="list-group-item list-group-item-action product-variant" v-on:click="addItem(variant,product)">
                                                            <div class="row">    
                                                                <div>
                                                                    <a class="color_green pull-left" style="pointer-events:none">
                                                                        <span  v-html="variant.color_label + ' / ' + variant.size_label"></span>
                                                                    </a>
                                                                    <div class="pull-right" style="pointer-events:none">

                                                                        <span  v-html="variant.formated_price"></span>
                                                                    </div>
                                                                </div>    
                                                                <div style="color:#0041FF" v-html="'còn lại ' + variant.stock"></div>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                    <ul v-else> 
                                                    <li class="list-group-item list-group-item-action product-variant" v-on:click="addItem(null,product)">
                                                        <div class="row">
                                                            <div>
                                                                <a class="color_green pull-left" style="pointer-events:none">
                                                                    <span  v-html="product.color_label + ' / ' + product.size_label"></span>
                                                                </a>
                                                                <div class="pull-right" style="pointer-events:none">

                                                                    <span  v-html="product.formated_price"></span>
                                                                </div>
                                                            </div>
                                                            <div style="color:#0041FF" v-html="'còn lại ' + product.stock"></div>
                                                        </div>   
                                                        </li>
                                                    </ul>
                                                </div>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>{{ __('admin::app.sales.orders.SKU') }}</th>
                                        <th>{{ __('admin::app.sales.orders.product-name') }}</th>
                                        <th>{{ __('admin::app.sales.orders.price') }}</th>
                                        <th>{{ __('admin::app.sales.orders.qty') }}</th>
                                        <!-- <th>{{ __('admin::app.sales.orders.item-status') }}</th> -->
                                        <th>{{ __('admin::app.sales.orders.subtotal') }}</th>
                                        <!-- <th>{{ __('admin::app.sales.orders.tax-percent') }}</th> -->
                                        <!-- <th>{{ __('admin::app.sales.orders.tax-amount') }}</th> -->
                                       
                                        <!-- <th>{{ __('admin::app.sales.orders.grand-total') }}</th> -->
                                    </tr>
                                </thead>

                                <tbody>

                                   
                                    <tr v-for="item in order.items">
                                        <td v-html="item.product.sku">
                                            
                                        </td>

                                        <td >
                                            <span v-html="item.product.name"></span>
                                            <div class="item-options" v-if="item.additional.attributes">
                                            <span  v-for="attribute in Object.entries(item.additional.attributes)"><b  v-html="attribute[1].attribute_name + ':'+ ' '"> </b><span v-html="attribute[1].option_label"></span><br/></span>                                
                                            </div>
                                           
                                        </td>

                                        <td><input v-model="item.price" @change="calculate()" class="control" style="" type="number"/></td>

                                       
                                        <td><input v-model="item.qty_ordered" @change="calculate()" class="control" type="number"/></td>
                                        <td v-html="numberFormat(item.total)"></td>

                                        
                                    </tr>
                                </tbody>   
                            </table>
                        </div>

                        <div class="summary-comment-container">
                            
                            <table class="sale-summary">
                                <tr>
                                    <td>{{ __('admin::app.sales.orders.subtotal') }}</td>
                                    <td>-</td>
                                    <td v-html="numberFormat(order.sub_total)"></td>
                                </tr>

                                
                                <tr>
                                    <td>{{ __('admin::app.sales.orders.shipping-handling') }}</td>
                                    <td>-</td>
                                    <td v-html="numberFormat(parseInt(order.shipping_amount))"></td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <a hred="#" style="font-weight: 400;
    color: #007bff;
    background-color: transparent;cursor: pointer;">{{ __('admin::app.sales.orders.discount') }}+</a>
                                        
                                       
                                    </td>
                                    <td>-</td>
                                    <td><input @change="calculate()" v-model="order.base_discount_amount" type="number"/></td>
                                </tr>
                                
                               
                                <tr class="bold">
                                    <td>{{ __('admin::app.sales.orders.grand-total') }}</td>
                                    <td>-</td>
                                    <td v-html="numberFormat(order.grand_total)"></td>
                                </tr>

                              
                            </table>
                        </div>
                    </div>
                </accordian>




                <accordian :title="'{{ __('admin::app.sales.orders.payment-and-shipping') }}'" :active="true">
                    <div slot="body">

                        <div class="sale-section">
                            <div class="secton-title">
                                <span>{{ __('admin::app.sales.orders.payment-info') }}</span>
                            </div>

                            <div class="section-content">
                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.payment-method') }}
                                    </span>

                                    <span class="value">
                                    <select v-model="order.payment.method" name="type" class="control" style="width:100%">
                                        <option value="cashondelivery">
                                            Cash On Delivery
                                        </option> 
                                        <option value="moneytransfer">
                                            Money Transfer
                                        </option> 
                                    </select>
                                    </span>
                                   
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.currency') }}
                                    </span>

                                    <span class="value">
                                       VND
                                    </span>
                                </div>

                      

                               
                            </div>
                        </div>

                       
                        <div class="sale-section">
                            <div class="secton-title">
                                <span>{{ __('admin::app.sales.orders.shipping-info') }}</span>
                            </div>

                            <div class="section-content">
                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.shipping-method') }}
                                    </span>

                                    <span class="value">
                                    <select v-model="order.shipping_method" name="type" class="control" style="width:100%">
                                        <option value="free_free">
                                            Free Ship
                                        </option> 
                                        <option value="flatrate_flatrate" >
                                            Default Shipment
                                        </option> 
                                    </select>
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('admin::app.sales.orders.shipping-price') }}
                                    </span>

                                    <span class="value">
                                    <input autocomplete="off" @change="calculate()" v-model="order.shipping_amount"  class="control" style="width:100%" type="number" placeholder="Enter shipping fee" >
                                    </span>
                                </div>

                               
                            </div>
                        </div>
                        
                    </div>
                </accordian>



            </div>
        </tab>


    </tabs>
</div>
    <!-- <modal id="open_modal" :is-open="open_modal">
        <h3 slot="header">Coupon</h3>
        <div slot="body">

        <input style="width:100%" autocomplete="off" type="text" class="control" v-model="coupon_code" placeholder="Enter coupon" >
        <button class="btn btn-primary">Apply</button>
        </div>
    </modal> -->
</div>
</script>
<style>
    .control {
        background: #fff;
        border: 2px solid #c7c7c7;
        border-radius: 3px;
        width: 70%;
        height: 36px;
        display: inline-block;
        vertical-align: middle;
        transition: .2s cubic-bezier(.4, 0, .2, 1);
        padding: 0 10px;
        font-size: 15px;
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .list-group-item-action {
        width: 100%;

        text-align: inherit;
        cursor: pointer;

    }

    .list-group-item-action:hover {
        text-decoration: none;
        background-color: #ced4da;
    }
    @keyframes spinner-border {
    to { transform: rotate(360deg); }
    }
    .spinner-border {
        display: inline-block;
        width: 1.2rem;
        height: 1.2rem;
        vertical-align: text-bottom;
        border: .25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        -webkit-animation: spinner-border .75s linear infinite;
        animation: spinner-border .75s linear infinite;
    }
</style>

<script>
    Vue.component('create', {

        template: '#create-template',

        data: function() {
            return {
                products: [],
                search_key:"",
                open_modal:true,
                loading:false,
                order: {
                    "customer_id": null,
                    "is_guest": 1,
                    "customer_email": "",
                    "customer_first_name": "",
                    "customer_last_name": "",
                    "customer": null,
                    "total_item_count": 0,
                    "total_qty_ordered": "0",
                    "base_currency_code": "VND",
                    "channel_currency_code": "VND",
                    "order_currency_code": "VND",
                    "grand_total": "0.0000",
                    "base_grand_total": "0.0000",
                    "sub_total": "0.0000",
                    "base_sub_total": "0.0000",
                    "tax_amount": "0.0000",
                    "base_tax_amount": "0.0000",
                    "coupon_code": null,
                    "applied_cart_rule_ids": "",
                    "discount_amount": "0.0000",
                    "base_discount_amount": "0.0000",
                    "billing_address": {
                        "address_type": "cart_billing",
                        "customer_id": null,
                        "order_id": null,
                        "first_name": "",
                        "last_name": "",
                        "gender": null,
                        "company_name": "",
                        "address1": "",
                        "address2": null,
                        "postcode": "700000",
                        "city": "Ho Chi Minh",
                        "state": "Ho Chi Minh",
                        "country": "VN",
                        "email": "",
                        "phone": "",
                        "vat_id": null,
                        "default_address": 0,
                        "additional": null,
                        "created_at": "2020-12-21T07:26:46.000000Z",
                        "updated_at": "2020-12-21T07:26:46.000000Z"
                    },
                    "payment": {
                        "method": "cashondelivery",
                        "method_title": null,
                        "created_at": "2020-12-21T07:30:43.000000Z",
                        "updated_at": "2020-12-21T07:30:43.000000Z"
                    },
                    "channel": {
                        "id": 1,
                        "code": "default",
                        "name": "Default",
                        "description": "",
                        "timezone": null,
                        "theme": "velocity",
                        "hostname": "",
                        "logo": "channel\/1\/WI4HFdtbAG7i1Dl6gHyElAsbfeYnE2KHnspk9PL4.png",
                        "favicon": "channel\/1\/fANQBp74AVeeslmOKWjaiEGJVVYNqwk3fAxayD40.png",
                        "default_locale_id": 5,
                        "base_currency_id": 3,
                        "created_at": null,
                        "updated_at": "2020-12-10T09:30:51.000000Z",
                        "root_category_id": 1
                    },
                    "shipping_method": "flatrate_flatrate",
                    "shipping_title": "Default Shipment",
                    "shipping_description": "Default Shipment",
                    "shipping_amount": 0,
                    "base_shipping_amount": 0,
                    "shipping_address": {
                        "address_type": "cart_shipping",
                        "customer_id": null,
                        "order_id": null,
                        "first_name": "",
                        "last_name": "",
                        "gender": null,
                        "company_name": "",
                        "address1": "",
                        "address2": null,
                        "postcode": "700000",
                        "city": "Ho Chi Minh",
                        "state": "Ho Chi Minh",
                        "country": "VN",
                        "email": "",
                        "phone": "",
                        "vat_id": null,
                        "default_address": 0,
                        "additional": null,
                        "created_at": "2020-12-21T07:26:46.000000Z",
                        "updated_at": "2020-12-21T07:26:46.000000Z"
                    },
                    "shipping_discount_amount": "0.0000",
                    "base_shipping_discount_amount": "0.0000",
                    "items": []
                }
            }
        },
        created() {

            const vm = this;
            axios.get('/api/products').then(function(response) {
                response.data.data.forEach(element => {
                    element.url_key = element.url_key.replaceAll('-', ' ');
                    element.search_name = element.name.toLowerCase();
                });
                vm.products = response.data.data;
            });
        },
        methods: {
            calculate() {
                let total = 0;
                this.order.items.forEach((element, index) => {
                    const subtotalline = element.price * element.qty_ordered;
                    this.order.items[index].total = subtotalline;
                    total += subtotalline;
                });
                this.order.total = total;
                this.grand_total = total;
                this.base_grand_total = total;
                this.sub_total = total;
                this.base_sub_total = total;

            },
            addItem(variant, product) {
                this.search_key = "";
                let item = {};
                item.product = product;
                item.product.attribute_family = {
                    "id": 1,
                    "code": "default",
                    "name": "Default",
                    "status": 0,
                    "is_user_defined": 1
                };
                item.sku = product.sku;
                item.type = product.type;
                item.name = product.name;
                item.weight = "0";
                item.total_weight = "0";
                if (variant) {
                    item.price = variant.price;
                    item.base_price = variant.price;
                    item.total = variant.price;
                    item.base_total = variant.price;
                } else {
                    item.price = product.price;
                    item.base_price = product.price;
                    item.total = product.price;
                    item.base_total = product.price;
                }
                item.tax_percent = "0.0000";
                item.tax_amount = "0.0000";
                item.base_tax_amount = "0.0000";
                item.discount_percent = "0.0000";
                item.discount_amount = "0.0000";
                item.base_discount_amount = "0.0000";
                item.qty_ordered = 1;
                item.additional = {
                    product_id: variant ? variant.id : product.id,
                    locale: "vn"
                };
                if (product.type != 'single') {
                    item.additional.parent_id = product.id;
                }
                if (variant != null) {
                    item.children = [variant];
                }
                console.log(product);
                if (product.type == "configurable") {

                    item.additional.quantity = "1";
                    item.additional.attributes = variant.attributes;

                    item.additional.is_buy_now = "0";
                    item.additional.product_id = product.id;

                    item.additional.locale = "vn";

                }

                this.order.items.push(item);
                this.calculate();
            },
            calculate() {
                this.order.grand_total = 0;
                this.order.base_grand_total = 0;
                this.order.sub_total = 0;
                this.order.base_sub_total = 0;
                this.order.total_item_count = 0;
                this.order.total_qty_ordered = 0;
                this.order.items.forEach(element => {
                    element.total = element.price * element.qty_ordered;
                    this.order.sub_total += element.price * element.qty_ordered
                });
                this.order.base_sub_total = this.order.sub_total;
                this.order.discount_amount = this.order.base_discount_amount;
                this.order.grand_total = this.order.sub_total + parseInt(this.order.shipping_amount) - this.order.discount_amount;
                this.order.base_grand_total = this.order.grand_total;
            },

            numberFormat(value) {

                return value.toLocaleString(); // displaying other groupings/separators is possible, look at the docs
            },
            submit() {
                this.order.billing_address.first_name = this.order.customer_first_name;
                this.order.shipping_address.first_name = this.order.customer_first_name;
                this.order.shipping_address.phone = this.order.billing_address.phone;
                this.order.customer_email = this.order.billing_address.phone + '@gmail.com';
                this.order.shipping_address.address1 = this.order.billing_address.address1;
                this.loading = true;
                var vm = this;
                axios.post('/admin/sales/orders/save_order', this.order).then(function(response) {
                    console.log(response.data);
                    window.location.href = "/admin/sales/orders/view/" + response.data.id;
                    this.loading = false;
                });
            }
        }
    });
</script>

@endpush