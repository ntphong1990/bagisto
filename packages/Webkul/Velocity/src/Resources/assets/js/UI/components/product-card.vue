<template>
    <div class="swiper-slide swiper-slide-active" v-if="list">

        <div class="swiper-slide swiper-slide-active" style="width: 274px; margin-right: 24px;">
            <a class="product-card" :href="`${baseUrl}/${product.slug}`">
                <div class="product-card__image">
                    <div class="product-card__image__background" style="background-color: #898f4b">
                    </div>
                    <img class="product-card__image__img" :src="product.image || product.product_image"
                        :alt="product.name">
                    <div class="product-card__image__badge product-card__image__badge--small" v-if="product.new">
                        <div class="product-card__image__badge__text">
                            product.new </div>
                    </div>
                </div>
                <div class="product-card__content">
                    <div class="product-card__content__price">
                        <span class="from">From</span> <span class="woocommerce-Price-amount amount"><span
                                class="woocommerce-Price-currencySymbol">$</span>{{product.priceHTML}}</span> </div>
                    <div class="product-card__content__title">{{product.name}}</div>
                    <div class="product-card__content__excerpt">{{product.shortDescription}}</div>
                </div>
            </a>
        </div>
    </div>

    <div class="swiper-slide swiper-slide-active" style="width: 280px; margin-right: 16px;" v-else>
        <a class="product-card" :href="`${baseUrl}/${product.slug}`">
            <div class="product-card__image">
                <div class="product-card__image__background" style="background-color: #898f4b">
                </div>
                <img class="product-card__image__img" :src="product.image || product.product_image" :alt="product.name">
                <div class="product-card__image__badge product-card__image__badge--small" v-if="product.new">
                    <div class="product-card__image__badge__text">
                        product.new </div>
                </div>
            </div>
            <div class="product-card__content">
                <div class="product-card__content__price" v-html="product.priceHTML">
                </div>
                <div class="product-card__content__title">{{product.name}}</div>
                <div class="product-card__content__excerpt" v-html="product.shortDescription"></div>
            </div>
        </a>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: [
            'list',
            'product',
        ],

        data: function () {
            return {
                'addToCart': 0,
                'addToCartHtml': '',
            }
        },

        methods: {
            'isMobile': function () {
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
</script>