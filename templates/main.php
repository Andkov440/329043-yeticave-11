<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
            снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php foreach ($categories as $value): ?>
                <li class="promo__item promo__item--<?= esc($value['symbol_code']) ?>">
                    <a class="promo__link"
                       href="index.php?id=<?= esc($value['id']); ?>"><?= esc($value['title']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <?php if (!empty($category_id)): ?>
                <h2>Все лоты в категории <?= $categories[$category_id - 1]['title']; ?></h2>
            <?php else: ?>
                <h2>Открытые лоты</h2>
            <?php endif; ?>
        </div>
        <ul class="lots__list">
            <?php foreach ($goods as $item): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= esc($item['image']); ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= esc($item['lot_title']); ?></span>
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
        </ul>
    </section>
    <?= $pagination; ?>
</main>
