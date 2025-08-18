document.addEventListener('DOMContentLoaded', () => {
    let searchElements = document.querySelectorAll('.search__element-form-option');
    let searchTitle = document.querySelector(".search__element-form-title");
    let searchForm = document.getElementById('search');
    searchElements.forEach(element => {
        element.addEventListener("click", (e) => {
            searchTitle.innerHTML = element.innerText;
            let searchData = element.getAttribute('data-search');
            searchForm.action = searchData
        })
    });
});