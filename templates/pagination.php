<?php if ($pages_count > 1): ?>
    <ul class="pagination-list">


        <?php if (isset($search)): ?>
            <li class="pagination-item pagination-item-prev"><?php if ($CURRENT_PAGE > 1): ?><a
                    href="/<?= $filename; ?>?search=<?= $search; ?>&page=<?= ($CURRENT_PAGE - 1); ?>"><?php endif; ?>
                    Назад</a></li>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page == $CURRENT_PAGE) : ?>pagination-item-active<?php endif; ?>">
                    <a
                        href="/<?= $filename; ?>?search=<?= $search; ?>&page=<?= $page; ?>"><?= $page; ?></a></li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><?php if ($CURRENT_PAGE < $pages_count): ?><a
                    href="/<?= $filename; ?>?search=<?= $search; ?>&page=<?= ($CURRENT_PAGE + 1); ?>"><?php endif; ?>
                    Вперед</a></li>
        <?php elseif (isset($category_id)): ?>
            <li class="pagination-item pagination-item-prev"><?php if ($CURRENT_PAGE > 1): ?><a
                    href="/<?= $filename; ?>?id=<?= $category_id; ?>&page=<?= ($CURRENT_PAGE - 1); ?>"><?php endif; ?>
                    Назад</a></li>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page == $CURRENT_PAGE) : ?>pagination-item-active<?php endif; ?>">
                    <a
                        href="/<?= $filename; ?>?id=<?= $category_id; ?>&page=<?= $page; ?>"><?= $page; ?></a></li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><?php if ($CURRENT_PAGE < $pages_count): ?><a
                    href="/<?= $filename; ?>?id=<?= $category_id; ?>&page=<?= ($CURRENT_PAGE + 1); ?>"><?php endif; ?>
                    Вперед</a></li>
        <?php else: ?>
            <li class="pagination-item pagination-item-prev"><?php if ($CURRENT_PAGE > 1): ?><a
                    href="/?page=<?= ($CURRENT_PAGE - 1); ?>"><?php endif; ?>Назад</a></li>
            <?php foreach ($pages as $page): ?>
                <li class="pagination-item <?php if ($page == $CURRENT_PAGE) : ?>pagination-item-active<?php endif; ?>">
                    <a
                        href="/?page=<?= $page; ?>"><?= $page; ?></a></li>
            <?php endforeach; ?>
            <li class="pagination-item pagination-item-next"><?php if ($CURRENT_PAGE < $pages_count): ?><a
                    href="/?page=<?= ($CURRENT_PAGE + 1); ?>"><?php endif; ?>Вперед</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
