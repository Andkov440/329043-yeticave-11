<main>
<nav class="nav">
        <ul class="nav__list container">
            <?php foreach($categories as $value): ?>
               <li class="nav__item">
                    <a href="all-lots.html"><?=esc($value['title']);?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
<section class="lot-item container">
    <h2><?=esc($lot_data['title']); ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="../<?=esc($lot_data['image']); ?>" width="730" height="548" alt="<?=esc($lot_data['category_title']); ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?=esc($lot_data['category_title']); ?></span></p>
            <p class="lot-item__description"><?=esc($lot_data['description']); ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <?php $timer = time_left($lot_data['end_date']);?>
                <div class="<?=(int)$timer[0] === 0 ? "lot-item__timer timer timer--finishing" : "lot-item__timer timer";?>">
                    <?=$timer[0].':'.$timer[1];?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=esc($lot_data['starting_price']); ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span>12 000 р</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
    </main>
