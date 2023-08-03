<div class="container w-auto d-grid justify-content-center">
    <h2 class="text-center">Список автомобилей</h2>
    <div class="d-flex justify-content-end">
        <a class="btn btn-primary" href="/create">Создать клиента</a>
    </div>
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
            <?php foreach ($data as $car):?>
                <tr>
                    <th scope="row"><?=$car['full_name']?></th>
                    <th scope="row"><?=$car['brand'].' '.$car['model']?></th>
                    <th scope="row"><?=$car['phone']?></th>
                    <th scope="row">
                        <div class="d-flex justify-content">
                                <a class="btn" href="<?= site_url('/edit/'.$car['client_id'])?>">
                                    <img src="./img/edit.png" title="Редактировать">
                                </a>
                            <form action="<?=site_url('/delete')?>" method="post">
                                <button class="btn" type="submit" name="id" value="<?=$car['car_id']?>">
                                    <img src="./img/delete.png" title="Удалить автомобиль">
                                </button>
                            </form>
                        </div>
                    </th>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-center">
            <?php for($page = 1; $page <= $pages; $page++):?>
                <?php if($page == $currentPage):?>
                    <li class="page-item active"><a class="page-link" href="/?page=<?=$page?>"><?=$page?></a></li>
                <?php else:?>
                    <li class="page-item"><a class="page-link" href="/?page=<?=$page?>"><?=$page?></a></li>
                <?php endif;?>
            <?php endfor;?>
        </ul>
    </nav>
</div>