<?php
$query_text="(".
    "product_id int(5) not null, ".
    "region_id int(5) not null, ".
    "priceVal float, ".
    "currency_id int(2) not null, ".
    "comment varchar(128), ".
    "primary key (product_id, region_id, currency_id)".
    ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";