<?php
echo "<div class='contentBlock-frame'><div class='contentBlock-center'>".
    "<div class='contentBlock-wrap'>".
    "<div class='query-block'>".
    "<form class='form-option'>".
    "<div class='form-option-line'>".
    "<label for='tagretQuery'>Enter query:</label>"."<label></label>".
    "</div>".
    "<div class='form-option-line'>".
    "<textarea name='tagretQuery' rows='5' placeholder='select...'></textarea>".
    "</div>".
    "<div class='form-option-line'>".
    "<label for='tagretQuery'>limit </label>".
    "<input type='number' name='qp-limit' min='1' max='100' value='10'>".
    "</div>".
    "<div class='form-option-cntrl'>".
    "<input type='button' value='print' onclick='queryPrint()'>".
    "</div>".
    "</form>".
    "</div>".
    "<div class='query-result'>".
    "<span class='resTxt'>Result: </span>".
    "<div class='result-info'>-</div>".
    "<div class='query-result-table'></div>".
    "</div>".
    "</div>".
    "</div></div>";