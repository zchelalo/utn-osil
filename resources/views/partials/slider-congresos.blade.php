@if(isset($congreso->img[0]))

  @if(count($congreso->img) > 1)

  <div class="swiper">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->

        @foreach($congreso->img as $key => $value)
        <div class="swiper-slide" data-swiper-autoplay="3500">
          <img style="filter:brightness(1);" src="{{ $value }}" class="d-block w-100" alt="{{ $congreso->nombre }}">
          <div class="carousel-caption">

          </div>
        </div>
        @endforeach
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>

    <!-- If we need scrollbar -->
    <div class="swiper-scrollbar"></div>
  </div>

  @else
  <img style="filter:brightness(1);" src="{{ $congreso->img[0] }}" class="d-block w-100" alt="{{ $congreso->nombre }}">
  @endif

@endif