document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('price-slider');
    if (slider) {
        let form = document.querySelector('.filters')
        let min = +form.getAttribute('data-min');
        let max = +form.getAttribute('data-max');
        let inputMin = document.querySelector('[data-minPrice]');
        let inputMax = document.querySelector('[data-maxPrice]');
        let tooltips = [document.createElement('span'), document.createElement('span')];
    
        noUiSlider.create(slider, {
            start: [min, max],
            connect: true,
            range: {
                'min': min,
                'max': max
            }
    
        });
    
        slider.noUiSlider.on('update', function(values, handle) {
            let minValue = parseInt(values[0]);
            let maxValue = parseInt(values[1]);
            let circles = document.querySelectorAll(".noUi-touch-area");
            let minCircle = circles[0];
            let maxCircle = circles[1];
            inputMin.value = minValue;
            inputMax.value = maxValue;
            tooltips[handle].innerHTML = values[handle];
            tooltips[handle].classList.add('nouislider-tooltip');
            minCircle.innerHTML = `<span class="min-circle">${minValue}</span>`
            maxCircle.innerHTML = `<span class="max-circle">${maxValue}</span>`
        });
    
        let minCountInput = min;
        let maxCountInput = max;
    
        inputMin.addEventListener("input", (e) => {
            inputMin.setAttribute('value', e.target.value);
            minCountInput = e.target.value;
            slider.noUiSlider.set([minCountInput, maxCountInput]);
        });
    
        inputMax.addEventListener("input", (e) => {
            inputMax.setAttribute('value', e.target.value);
            maxCountInput = e.target.value;
            setTimeout(() => {
                slider.noUiSlider.set([minCountInput, maxCountInput]);
            }, 1500);
        });        
    }

});