console.log("Файл 2 прочтён");

window.addEventListener('DOMContentLoaded', function (event) 
{
  console.log("DOM2 fully loaded and parsed");
});

const gallery = document.getElementById('gallery');
  const images = gallery.getElementsByTagName('img');
  let currentIndex = 1; // Индекс для отображения центрального изображения вначале (начиная со второго)

  function updateGallery() {
    // Убираем класс active у всех изображений
    for (let img of images) {
      img.classList.remove('active');
    }
    // Добавляем класс active трем видимым изображениям (или одной на мобильных устройствах)
    images[currentIndex].classList.add('active');
    if (window.innerWidth > 600) {
      if (currentIndex > 0) images[currentIndex - 1].classList.add('active');
      if (currentIndex < images.length - 1) images[currentIndex + 1].classList.add('active');
    }

    // Сдвигаем галерею так, чтобы нужная тройка или одиночное изображение отображались по центру
    const offset = -(currentIndex - (window.innerWidth > 600 ? 1 : 0)) * (images[0].width + 10);
    gallery.style.transform = `translateX(${offset}px)`;
  }

  function moveLeft() {
    if (currentIndex > 0) {
      currentIndex--;
    } else {
      currentIndex = 0; // Для случая крайнего левого
    }
    updateGallery();
  }

  function moveRight() {
    if (currentIndex < images.length - 1) {
      currentIndex++;
    } else {
      currentIndex = images.length - 1; // Для случая крайнего правого
    }
    updateGallery();
  }

  updateGallery(); // Инициализация отображения

  // Обновление галереи при изменении размера окна
  window.addEventListener('resize', updateGallery);