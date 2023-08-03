<div class="container" id="main">
    <h2>Редактирование клиента</h2>
    <form>
        <input name="client_id" value="<?=$client['client_id']?>" hidden="hidden">
        <div>
            <label class="form-label" for="name">ФИО клиента</label>
            <input class="form-control w-auto" type="text" name="name" id="name" required
                   value="<?= $client['full_name'] ?>">
        </div>
        <div>
            <label class="form-label" for="gender">Пол</label>
            <select class="form-control w-auto" name="gender" id="gender" required>
                <option value="Мужчина" <?php
                if ($client['gender'] == 'Мужчина'): echo 'selected';endif; ?> >Мужчина
                </option>
                <option value="Женщина" <?php
                if ($client['gender'] == 'Женщина'): echo 'selected';endif; ?>>Женщина
                </option>
                <option value="КА-50" <?php
                if ($client['gender'] == 'КА-50'): echo 'selected';endif; ?>>КА-50
                </option>
            </select>
        </div>
        <div>
            <label class="form-label" for="phone">Телефон</label>
            <input type="text" class="form-control w-auto" name="phone" id="phone" required
                   value="<?= $client['phone'] ?>">
        </div>
        <div>
            <label class="form-label" for="address">Адрес</label>
            <input type="text" class="form-control w-auto" name="address" id="address" required
                   value="<?= $client['address'] ?>">
        </div>
        <div id="cars">
            <?php
            for($i = 0; $i < count($cars); $i++): ?>
            <div id="car-<?=$i?>">
                <h2>Автомобиль</h2>
                <input id="id-<?=$i?>" name="car-id-<?=$i?>" value="<?=$cars[$i]['car_id']?>" hidden="hidden">
                <div>
                    <label class="form-label" for="brand">Производитель</label>
                    <input type="text" class="form-control w-auto" name="brand-<?=$i?>" id="brand" value="<?=$cars[$i]['brand']?>">
                </div>
                <div>
                    <label class="form-label" for="model">Модель</label>
                    <input type="text" class="form-control w-auto" name="model-<?=$i?>" id="model" value="<?=$cars[$i]['model']?>">
                </div>
                <div>
                    <label class="form-label" for="color">Цвет</label>
                    <input type="text" class="form-control w-auto" name="color-<?=$i?>" id="color" value="<?=$cars[$i]['color']?>">
                </div>
                <div>
                    <label class="form-label" for="plate_number">Гос номер</label>
                    <input type="text" class="form-control w-auto" name="plate_number-<?=$i?>" id="plate_number" value="<?=$cars[$i]['plate_number']?>">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="parked-<?=$i?>" id="parked" <?php if($cars[$i]['parked']): echo 'checked'; endif;?>>
                    <label class="form-label" for="parked">На парковке?</label>
                </div>
                <button class="btn" type="button" id="delete-car-<?=$i?>">
                    <img src="<?= base_url('/img/delete.png')?>"/>
                </button>
            </div>
            <?php endfor;?>
        </div>
        <button class="btn btn-primary my-3" type="button" id="add-car">Добавить автомобиль</button>
        <div>
            <button class="btn btn-success" type="button" id="send-request">Сохранить</button>
        </div>
    </form>
    <script src="<?= base_url('/js/edit.js')?>"></script>
</div>