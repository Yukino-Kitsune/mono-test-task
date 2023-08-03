let carsCount = 0;
function init(){
    carsCount = document.getElementById('cars').querySelectorAll("[id^='car-']").length;
    for (let i = 0; i < carsCount; i++) {
        let button = document.getElementById('delete-car-'+i);
        button.addEventListener('click', deleteCar);
    }
    document.getElementById('add-car').addEventListener('click', addCar);
    document.getElementById('send-request').addEventListener('click', sendRequest);
}

function deleteCar(event) {
    let button = event.target.parentNode;
    let id = button.id.split('-')[button.id.split('-').length - 1]
    let carId = document.getElementById('id-'+id).value;
    let formData = new FormData();
    formData.set('id', carId);
    fetch('/delete',{
        method: 'POST',
        headers: {
            'X-Requested-With': "XMLHttpRequest"
        },
        body: formData
    })
        .then(response => {
            if(response.status === 200)
            {
                let div = event.target.parentNode.parentNode;
                div.remove();
                carsCount--;
            }
        })
}

function deleteNewForm(event){
    let div = event.target.parentNode.parentNode;
    div.remove();
    carsCount--;
}
function addCar() {
    let id = 0;
    let cars = document.getElementById('cars').querySelectorAll("[id^='car-']")
    if (cars.length > 0) {
        let last = cars[cars.length - 1];
        let currentId = last.id.split('-')[last.id.split('-').length - 1];
        id = parseInt(currentId) + 1;
    }
    let car = document.createElement("div");
    car.id = 'car-'+id;
    car.innerHTML =
        '<h2>Автомобиль</h2>'+
        '<div>\n' +
        '<label class="form-label" for="brand">Производитель</label>\n' +
        '<input type="text" class="form-control w-auto" name="brand-'+id+'" id="brand">\n' +
        '</div>\n' +
        '<div>\n' +
        '<label class="form-label" for="model">Модель</label>\n' +
        '<input type="text" class="form-control w-auto" name="model-'+id+'" id="model">\n' +
        '</div>\n' +
        '<div>\n' +
        '<label class="form-label" for="color">Цвет</label>\n' +
        '<input type="text" class="form-control w-auto" name="color-'+id+'" id="color">\n' +
        '</div>\n' +
        '<div>\n' +
        '<label class="form-label" for="plate_number">Гос номер</label>\n' +
        '<input type="text" class="form-control w-auto" name="plate_number-'+id+'" id="plate_number">\n' +
        '</div>\n' +
        '<div class="form-check">\n' +
        '<input type="checkbox" class="form-check-input" name="parked-'+id+'" id="parked">\n' +
        '<label class="form-label" for="parked">На парковке?</label>\n' +
        '</div>\n' +
        '<button class="btn btn-success" type="button" id="submit-car-'+id+'">\n'+
        'Подтвердить\n' +
        '</button>\n' +
        '<button class="btn" type="button" id="delete-car-'+id+'">\n'+
        '<img src="/img/delete.png"/>\n' +
        '</button>'
    document.getElementById("cars").appendChild(car);
    document.getElementById('submit-car-'+id).addEventListener("click", submitCar);
    document.getElementById('delete-car-'+id).addEventListener("click", deleteNewForm);
    carsCount++;
}

function submitCar(event) {
    let div = event.target.parentNode;
    let id = div.id.split('-')[div.id.split('-').length - 1]
    let formData = new FormData();
    formData.set('brand', document.getElementsByName('brand-'+id)[0].value);
    formData.set('model', document.getElementsByName('model-'+id)[0].value);
    formData.set('color', document.getElementsByName('color-'+id)[0].value);
    formData.set('plate_number', document.getElementsByName('plate_number-'+id)[0].value)
    formData.set('parked', document.getElementsByName('parked-'+id)[0].checked ? '1' : '0');
    formData.set('owner_id', document.getElementsByName('client_id')[0].value);
    fetch('/car/create', {
        method: 'POST',
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    })
        .then(response => {
            if(response.status === 200) {
                let button = document.getElementById('submit-car-'+id);
                button.remove();
            }
        })
}

function sendRequest() {
    let formData = new FormData(document.querySelector("form"));
    formData.set('cars', carsCount);
    fetch('/edit', {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    })
        .then(response => {
            if(response.redirected)
            {
                window.location.href = response.url;
                return;
            }
            return response.json();
    })
}

init();