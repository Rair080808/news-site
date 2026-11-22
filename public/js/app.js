// Вспомогательный скрипт для вёрстки лабораторной работы №1.
// На данном этапе добавляет мобильное меню и подсветку поля поиска.

document.addEventListener('DOMContentLoaded', function () {
    const header = document.querySelector('.site-header');
    if (header) {
        header.classList.add('js-ready');
    }
});