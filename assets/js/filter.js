let activeTitles = document.querySelectorAll('.filter-toggle');
let fillterTitles = document.querySelector('.filters__top');
if (fillterTitles) {
    activeTitles.forEach(item => {
        item.addEventListener('click', () => {
            item.parentNode.classList.toggle('active');
        })
    })
    fillterTitles.addEventListener('click', ()=> {
        fillterTitles.parentNode.classList.toggle('active');
    })
}
