<div class="container">
    <h2 class="text-center">Список автомобилей</h2>
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
                        <button class="btn btn-primary">#EDIT</button>
                        <button class="btn btn-danger">#DELETE</button>
                    </th>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-center">
            <?php for($page = 1; $page < $pages; $page++):?>
                <?php if($page == $currentPage):?>
                    <li class="page-item active"><a class="page-link" href="/cars?page=<?=$page?>"><?=$page?></a></li>
                <?php else:?>
                    <li class="page-item"><a class="page-link" href="/cars?page=<?=$page?>"><?=$page?></a></li>
                <?php endif;?>
            <?php endfor;?>
        </ul>
    </nav>
</div>