<div class="container" id="main">
    <h2>Создание клиента</h2>
    <form>
        <div>
            <label class="form-label" for="name">ФИО клиента</label>
            <input class="form-control w-auto" type="text" name="name" id="name" required>
        </div>
        <div>
            <label class="form-label" for="gender">Пол</label>
            <select class="form-control w-auto" name="gender" id="gender" required>
                <option value="Мужчина">Мужчина</option>
                <option value="Женщина">Женщина</option>
                <option value="КА-50">КА-50</option>
            </select>
        </div>
        <div>
            <label class="form-label" for="phone">Телефон</label>
            <input type="text" class="form-control w-auto" name="phone" id="phone" required>
        </div>
        <div>
            <label class="form-label" for="address">Адрес</label>
            <input type="text" class="form-control w-auto" name="address" id="address" required>
        </div>
        <div id="cars"></div>
        <button class="btn btn-primary my-3" type="button" id="add-car">Добавить автомобиль</button>
        <div>
            <button class="btn btn-success" type="button" id="send-request">Отправить запрос</button>
        </div>
    </form>
</div>
<script src="./js/create.js"></script>