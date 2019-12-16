<?= $nav_menu; ?>
<section class="lot-item container">
    <h2><?= esc($lot_data['title']); ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="../<?= esc($lot_data['image']); ?>" width="730" height="548"
                     alt="<?= esc($lot_data['category_title']); ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= esc($lot_data['category_title']); ?></span></p>
            <p class="lot-item__description"><?= esc($lot_data['description']); ?></p>
        </div>
        <div class="lot-item__right">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="lot-item__state">
                    <?php $timer = time_left($lot_data['end_date']); ?>
                    <div
                        class="<?= (int)$timer[0] === 0 ? "lot-item__timer timer timer--finishing" : "lot-item__timer timer"; ?>">
                        <?= $timer[0] . ':' . $timer[1]; ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= $max_rate ?? esc($lot_data['starting_price']); ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= $min_rate; ?> р</span>
                        </div>
                    </div>
                    <form class="lot-item__form" action="" method="post" autocomplete="off">
                        <p class="lot-item__form-item form__item <?= isset($errors['cost']) ? "form__item--invalid" : ""; ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="<?= $min_rate; ?>"
                                   value="<?= isset($errors['cost']) ? $_POST['cost'] : $min_rate; ?>">
                            <span class="form__error"><?= $errors['cost']; ?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>
            <?php endif; ?>
            <div class="history">
                <h3>История ставок (<span><?= $count_rates; ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($rate_data

                    as $item): ?>
                    <tr class="history__item">
                        <td class="history__name"><?= esc($item['name']); ?></td>
                        <td class="history__price"><?= esc($item['price']); ?> р</td>
                        <td class="history__time"><?= time_to_human_format($item['creation_date']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>
</main>
