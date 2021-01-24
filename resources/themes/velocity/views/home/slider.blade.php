@php
    $direction = core()->getCurrentLocale()->direction;
@endphp

@if ($velocityMetaData && $velocityMetaData->slider)
    <slider-component direction="{{ $direction }}"></slider-component>
@endif

@push('scripts')
    <script type="text/x-template" id="slider-template">
        <div class="slides-container {{ $direction }}">
            <carousel-component
                loop="true"
                timeout="5000"
                autoplay="true"
                slides-per-page="1"
                navigation-enabled="hide"
                locale-direction="direction"
                :slides-count="{{ ! empty($sliderData) ? sizeof($sliderData) : 1 }}">

                @if (! empty($sliderData))
                    @foreach ($sliderData as $index => $slider)

                    @php
                        $textContent = str_replace("\r\n", '', $slider['content']);
                    @endphp
                        <slide slot="slide-{{ $index }}">
                        <div  class="hero hero--grey">
                            <div class="hero__background" style="background-color: #f2efed;">
                                <img width="1600" height="600" src="{{ url()->to('/') . '/storage/' . $slider['path'] }}" class="hero__background__img" alt="Man with coffee" > 
                            </div>
                            <div class="hero__content">
                                <div class="grid-container">
                                    <div class="grid-x align-middle ">
                                        <div class="cell large-10 ">
                                            <!-- <h1 class="hero__content__title hero__content__title--lighter-text">
                                            Everyone is barista </h1> -->
                                            <a class="hero__content__a button button--primary" href="{{ $slider['slider_path'] }}" target="">{{ $slider['content'] }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        </slide>

                    @endforeach
                @else
                    <slide slot="slide-0">
                        <img
                            loading="lazy"
                            class="col-12 no-padding banner-icon"
                            src="{{ asset('/themes/velocity/assets/images/banner.png') }}" />
                    </slide>
                @endif

            </carousel-component>
            
    </script>

    <script type='text/javascript'>
        (() => {
            Vue.component('slider-component', {
                template: '#slider-template',
                props: ['direction'],

                mounted: function () {
                    let banners = this.$el.querySelectorAll('img');
                    banners.forEach(banner => {
                        banner.style.display = 'block';
                    });
                }
            })
        })()
    </script>
@endpush