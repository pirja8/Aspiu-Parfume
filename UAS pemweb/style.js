

const track = document.querySelector('.carousel-track');
const leftBtn = document.querySelector('.left-btn');
const rightBtn = document.querySelector('.right-btn');

let currentIndex = 0;

rightBtn.addEventListener('click', () => {
  const cardWidth = track.firstElementChild.getBoundingClientRect().width;
  const trackWidth = track.getBoundingClientRect().width;
  const maxScroll = Math.ceil((track.scrollWidth - trackWidth) / cardWidth);

  if (currentIndex < maxScroll) {
    currentIndex++;
    track.style.transform = `translateX(-${cardWidth * currentIndex}px)`;
  }
});

leftBtn.addEventListener('click', () => {
  if (currentIndex > 0) {
    const cardWidth = track.firstElementChild.getBoundingClientRect().width;
    currentIndex--;
    track.style.transform = `translateX(-${cardWidth * currentIndex}px)`;
  }
});



const uniqueTrack = document.querySelector('.unique-carousel-track');
const uniqueLeftBtn = document.querySelector('.unique-left-btn');
const uniqueRightBtn = document.querySelector('.unique-right-btn');

let uniqueIndex = 0;

uniqueRightBtn.addEventListener('click', () => {
  const uniqueCardWidth = uniqueTrack.firstElementChild.getBoundingClientRect().width + 16; // Including gap
  const uniqueMaxScroll = uniqueTrack.childElementCount - 3; // Adjust for visible items

  if (uniqueIndex < uniqueMaxScroll) {
    uniqueIndex++;
    uniqueTrack.style.transform = `translateX(-${uniqueCardWidth * uniqueIndex}px)`;
  }
});

uniqueLeftBtn.addEventListener('click', () => {
  if (uniqueIndex > 0) {
    const uniqueCardWidth = uniqueTrack.firstElementChild.getBoundingClientRect().width + 16;
    uniqueIndex--;
    uniqueTrack.style.transform = `translateX(-${uniqueCardWidth * uniqueIndex}px)`;
  }
});


