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
                            <a @if($slider['slider_path']) href="{{ $slider['slider_path'] }}" @endif>
                                <img
                                    class="col-12 no-padding banner-icon"
                                    src="{{ url()->to('/') . '/uploads/' . $slider['path'] }}" />

                                <div class="show-content" v-html="'{{ $textContent }}'">
                                </div>
                            </a>
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
            
            <div class="carousel-caption" style="top:0px">
            <img src="/uploads/movin sport final-05.png" style="width:70vw"/>
          <h1 style="font-size: 6.5rem;">COMING SOON</h1>
          
        </div>
        </div>
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