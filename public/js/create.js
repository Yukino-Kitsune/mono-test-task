
let carsCount = 0;

function addCar() {
    let id = 0;
    let cars = document.getElementById("cars")
    if (cars.childNodes.length > 0) {
        let last = cars.childNodes[cars.childNodes.length - 1];
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
        '<button class="btn" type="button" id="delete-car-'+id+'">\n'+
        '<img src="./img/delete.png"/>\n' +
        '</button>'
    document.getElementById("cars").appendChild(car);
    document.getElementById('delete-car-'+id).addEventListener("click", deleteCar);
    carsCount++;
}

function deleteCar(event) {
    let div = event.target.parentNode.parentNode;
    div.remove();
    carsCount--;
}

document.getElementById("add-car").addEventListener("click", addCar);


function sendRequest() {
    let formData = new FormData(document.querySelector("form"));
    formData.set('cars', carsCount);
    fetch('/create', {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    }).then(response => {
        if(response.redirected)
        {
            window.location.href = response.url;
            return;
        }
        return response.json();
    })
    .then(response => {
        if('msg' in response)
        {
            createAlert(response['msg']);
        }
    });
}
function createAlert(msg) {
    let oldAlerts = document.getElementsByClassName('alert');
    for (const alert of oldAlerts) {
        alert.remove();
    }
    let alert = document.createElement('div')
    alert.classList.add('alert', 'alert-danger', 'text-center');
    alert.textContent = msg;
    document.getElementById('main').insertAdjacentElement('afterbegin', alert);
}

document.getElementById("send-request").addEventListener("click", sendRequest);
