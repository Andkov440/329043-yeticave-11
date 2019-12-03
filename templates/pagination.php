<?php if ($pages_count > 1): ?>
    <ul class="pagination-list">
        <?php if (isset($search)): ?>
            <li class="pagination-item pagination-item-prev"><?php if ($cur_page > 1): ?><a
                    href="/<?= $filename; ?>?search=<?= $search; ?>&page=<?= ($cur_page - 1); ?>"><?php endif; ?>
                    Назад</a></li>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page == $cur_page) : ?>pagination-item-active<?php endif; ?>"><a
                        href="/<?= $filename; ?>?search=<?= $search; ?>&page=<?= $page; ?>"><?= $page; ?></a></li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><?php if ($cur_page < $pages_count): ?><a
                    href="/<?= $filename; ?>?search=<?= $search; ?>&page=<?= ($cur_page + 1); ?>"><?php endif; ?>
                    Вперед</a></li>
        <?php else: ?>
            <li class="pagination-item pagination-item-prev"><?php if ($cur_page > 1): ?><a
                    href="/?page=<?= ($cur_page - 1); ?>"><?php endif; ?>Назад</a></li>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page == $cur_page) : ?>pagination-item-active<?php endif; ?>"><a
                        href="/?page=<?= $page; ?>"><?= $page; ?></a></li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><?php if ($cur_page < $pages_count): ?><a
                    href="/?page=<?= ($cur_page + 1); ?>"><?php endif; ?>Вперед</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
