document.addEventListener("DOMContentLoaded", () => {
    const headers = document.querySelectorAll('.season-header');

    headers.forEach(header => {
        header.addEventListener('click', () => {
            const container = header.nextElementSibling; // Это .episodes-container
            const episodesGrid = container.querySelector('.episodes');

            // Проверяем, открыт ли контейнер сейчас
            const isOpen = container.style.maxHeight && container.style.maxHeight !== "0px";

            if (isOpen) {
                // ЗАКРЫВАЕМ
                container.style.maxHeight = "0px";
                header.classList.remove('active');
                if (episodesGrid) {
                    episodesGrid.classList.remove('visible');
                }
            } else {
                // ОТКРЫВАЕМ
                // Устанавливаем высоту равную полной высоте контента (scrollHeight)
                container.style.maxHeight = container.scrollHeight + "px";
                header.classList.add('active');
                if (episodesGrid) {
                    // Добавляем класс visible для появления видео (из вашего CSS)
                    episodesGrid.classList.add('visible');
                }
            }
        });
    });

    // Исправление для адаптивности: если размер окна меняется, 
    // пересчитываем высоту открытых секций
    window.addEventListener('resize', () => {
        const activeContainers = document.querySelectorAll('.season-header.active + .episodes-container');
        activeContainers.forEach(container => {
            container.style.maxHeight = container.scrollHeight + "px";
        });
    });
});