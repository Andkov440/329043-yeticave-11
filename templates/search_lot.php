<?= $nav_menu; ?>
<div class="container">
    <section class="lots">
        <?php if (empty($result)): ?>
            <h2>Ничего не найдено по вашему запросу</h2>
        <?php else: ?>
        <h2>Результаты поиска по запросу «<span><?= $search; ?></span>»</h2>
        <ul class="lots__list">
            <?php foreach ($result as $item): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= esc($item['image']); ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= esc($item['title']); ?></span>
                        <h3 class="lot__title"><a class="text-link"
                                                  href="lot.php?id=<?= $item['id'] ?>"><?= esc($item['title']); ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= price_format(esc($item['starting_price'])); ?></span>
                            </div>
                            <?php $timer = time_left($item['end_date']); ?>
                            <div
                                class="<?= (int)$timer[0] === 0 ? "lot__timer timer timer--finishing" : "lot__timer timer"; ?>">
                                <?= $timer[0] . ':' . $timer[1]; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </section>
    <?= $pagination; ?>
    </main>
