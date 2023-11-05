document.addEventListener('DOMContentLoaded', function() {
  const flipCheckbox = document.getElementById("switchFlip");
  const flipCard = document.querySelector(".flip-card");

  flipCheckbox.addEventListener("change", function () {
    if (flipCheckbox.checked) {
      flipCard.querySelector(".flip-card-inner").style.transform = "rotateY(180deg)";
    } else {
      flipCard.querySelector(".flip-card-inner").style.transform = "rotateY(0deg)";
    }
  });
});