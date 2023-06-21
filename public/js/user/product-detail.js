// alert("sdfsdsdf");
let callApi = document.querySelector('.js-call-api');
let color = document.querySelector('.js-color');
let memory = document.querySelector('.js-memory');
console.log(color);

// console.log('sadfsdfsdf');

callApi.addEventListener("click", function() {
    if (color && memory) {
        color.addEventListener("change", function(e) {
            if (e.target.checked) {
                console.log("sadfsdf");
            }
        });
    } else {

    }
    fetch('http://127.0.0.1:8000/api/productDetails/125/23/37')
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error(error));
});