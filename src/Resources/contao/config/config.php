<?php

declare(strict_types=1);

$GLOBALS['TL_HOOKS']['getPageLayout'][] = [
    'contao_bootstrap.form.listener.default_form_layout',
    'onGetPageLayout',
];
