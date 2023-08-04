<div class="container w-auto d-grid justify-content-center my-5">
    <h2>Автомобили на парковке</h2>
    <table class="table table-hover table-sm w-auto mx-auto">
        <caption></caption>
        <thead>
        <tr>
            <th scope="col">Клиент</th>
            <th scope="col">Автомобиль</th>
            <th scope="col">Номер</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data as $car): ?>
            <tr>
                <th scope="row"><?= $car['full_name'] ?></th>
                <th scope="row"><?= $car['brand'] . ' ' . $car['model'] ?></th>
                <th scope="row"><?= $car['phone'] ?></th>
                <th scope="row">
                    <div class="d-flex justify-content">
                        <form action="<?=site_url('/park')?>" method="post">
                            <input name="car_id" value="<?=$car['car_id']?>" hidden="hidden">
                            <button class="btn btn-primary" type="submit">
                                Вывести с парковки
                            </button>
                        </form>
                    </div>
                </th>
            </tr>
        <?php
        endforeach; ?>
        </tbody>
    </table>
    <h2>Добавить автомобиль на парковку</h2>
    <div>
        <div id="add-car">
            <label class="form-label" for="client">Клиент</label>
            <select class="form-control w-auto" name="client" id="client">
                <option hidden="hidden" selected>Выберите клиента</option>
                <?php foreach ($clients as $client):?>
                    <option value="<?=$client['client_id']?>"><?=$client['full_name']?></option>
                <?php endforeach;?>
            </select>
            <div id="car-select">
            </div>
        </div>
    </div>
</div>
<script src="./js/report.js"></script>