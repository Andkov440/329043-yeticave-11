<?= $nav_menu; ?>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($rates_result as $item): ?>
            <?php if ((strtotime($item['lot_end_date']) - 86400) < strtotime(date("Y-m-d"))): ?>
                <tr class="rates__item rates__item--end">
            <?php elseif (isset($item['winner'])): ?>
                <tr class="rates__item rates__item--win">
            <?php else: ?>
                <tr class="rates__item">
            <?php endif ?>
            <td class="rates__info">
                <div class="rates__img">
                    <img src="../<?= esc($item['lot_image']); ?>" width="54" height="40"
                         alt="<?= esc($item['category_title']); ?>">
                </div>
                <?php if (isset($item['winner'])): ?>
                    <div>
                        <h3 class="rates__title"><a
                                href="lot.php?id=<?= esc($item['lotid']); ?>"><?= esc($item['lot_title']); ?></a></h3>
                        <p><?= esc($item['user_contacts']); ?></p>
                    </div>
                <?php else : ?>
                    <h3 class="rates__title"><a
                            href="lot.php?id=<?= esc($item['lotid']); ?>"><?= esc($item['lot_title']); ?></a></h3>
                <?php endif ?>

            </td>
            <td class="rates__category">
                <?= esc($item['category_title']); ?>
            </td>
            <td class="rates__timer">
                <?php $timer = time_left($item['lot_end_date']); ?>
                <?php if ((strtotime($item['lot_end_date']) - 86400) < strtotime(date("Y-m-d"))): ?>
                    <div class="timer timer--end">
                        Торги окончены
                    </div>
                <?php elseif (isset($item['winner'])): ?>
                    <div class="timer timer--win">
                        Ставка выиграла
                    </div>
                <?php else: ?>
                    <div class="timer">
                        <?= $timer[0] . ':' . $timer[1] . ':' . $timer[2]; ?>
                    </div>
                <?php endif ?>
            </td>
            <td class="rates__price">
                <?= price_format(esc($item['rate_price'])); ?>
            </td>
            <td class="rates__time">
                <?= time_to_human_format(esc($item['creation_rate'])); ?>
            </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
