let div = document.getElementById('car-select');
let clientSelect = document.getElementById('client');

clientSelect.addEventListener('change', addSelect);

function addSelect(event) {
    let clientId = clientSelect.selectedOptions[0].value;
    div.innerHTML = '';
    fetch('/cars?client_id='+clientId, {
        method: 'GET',
        headers: {
            'X-Requested-With': "XMLHttpRequest"
        }
    })
        .then(response => response.json())
        .then(data => {
            let select = document.createElement('select');
            select.classList.add('form-control', 'w-auto', 'my-2');
            select.id = 'client_car';
            select.name = 'car_id';
            if(data.length === 0) {
                let option = document.createElement('option');
                option.textContent = 'Автомобилей нет';
                select.appendChild(option);
                div.appendChild(select);
                return;
            }
            data.forEach(car => {
                let option = document.createElement('option');
                option.textContent = car.brand + ' ' + car.model;
                option.value = car.car_id;
                select.appendChild(option);
            })
            let button = document.createElement('button');
            button.classList.add('btn', 'btn-success');
            button.textContent = 'Поставить на парковку';
            button.addEventListener('click', parkCar);
            div.appendChild(select);
            div.appendChild(button);
        })
}

function parkCar(event) {
    let id = document.getElementById('client_car').selectedOptions[0].value;
    let data = new FormData();
    data.set('car_id', id);
    fetch('/park', {
        method: 'POST',
        headers: {
            'X-Requested-With': "XMLHttpRequest"
        },
        body: data
    })
}
// [
//     {
//         "car_id": "20",
//         "brand": "Toyota",
//         "model": "Camry",
//         "color": "Teal",
//         "plate_number": "876-wyy-",
//         "parked": "0",
//         "owner_id": "1"
//     },
//     {
//         "car_id": "34",
//         "brand": "Chevrolet",
//         "model": "Express 3500",
//         "color": "Teal",
//         "plate_number": "801-jyt-",
//         "parked": "0",
//         "owner_id": "1"
//     }
// ]