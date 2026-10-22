<?php if (!empty($totalPages) && $totalPages > 1): ?>
    <?php
    $currentPage = $page ?? 1;
    $queryParams = $_GET;
    ?>
    <nav aria-label="Navigasi Halaman" class="mt-4">
        <ul class="pagination justify-content-center">
            <!-- Sebelumnya -->
            <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                <?php
                $queryParams['page'] = $currentPage - 1;
                $prevUrl = '?' . http_build_query($queryParams);
                ?>
                <a class="page-link" href="<?= $prevUrl ?>" aria-label="Sebelumnya">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <!-- Nomor Halaman -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php
                $queryParams['page'] = $i;
                $pageUrl = '?' . http_build_query($queryParams);
                ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $pageUrl ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Berikutnya -->
            <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                <?php
                $queryParams['page'] = $currentPage + 1;
                $nextUrl = '?' . http_build_query($queryParams);
                ?>
                <a class="page-link" href="<?= $nextUrl ?>" aria-label="Berikutnya">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
