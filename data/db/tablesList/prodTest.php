<?php
$query_text="(".
    "product_id int(5) AUTO_INCREMENT, ".
    "prodName varchar(128) not null, ".
    "prodAlias varchar(128) not null, ".
    "shortDescr varchar(128), ".
    "longDescr text, ".
    "cat_id int(5), ".
    "active boolean, ".
    "primary key (product_id)".
    ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";