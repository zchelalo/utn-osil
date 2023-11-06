document.addEventListener('DOMContentLoaded', function() {
  // SLIDER
  // SLIDER
  // SLIDER
  const swiper = new Swiper('.swiper', {
    // Optional parameters
    speed: 400,
    direction: 'horizontal',
    // slidesPerView: 2,
    effect: 'slide', // 'fade', 'cube', 'coverflow', 'flip', 'slide' or 'creative'
    loop: true,

    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },

    autoplay: {
      delay: 3500,
    },
  })
})