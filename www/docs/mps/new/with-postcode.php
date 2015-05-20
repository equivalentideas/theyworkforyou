<?php

$new_style_template = TRUE;

include_once '../../../includes/easyparliament/init.php';

$data = array();

$GLOBALS['postcode'] = 'L3 1EP';

MySociety\TheyWorkForYou\Renderer::output('mps/new', $data);

