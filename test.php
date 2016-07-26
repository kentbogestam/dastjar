<?
header('Content-Type: text/html; charset=UTF-8');


ini_set('default_charset','utf-8');
        $link = mysql_connect('localhost','root','smaka3Pudding');
        if ( ! $link )
            die( "Couldn't connect to MySQL. ".mysql_error());
        mysql_select_db( 'cumbari_admin', $link ) or die( "Couldn't open {DATABASE} database. ".mysql_error());



mysql_set_charset($link, 'utf8');
        $options = "";
        $query = "SELECT cat.category_id, ltext.text, cat.small_image FROM category as cat left join category_names_lang_list as cat_lang
            ON (cat.category_id = cat_lang.category)
            LEFT JOIN lang_text as ltext ON (cat_lang.names_lang_list = ltext.id) WHERE ltext.lang='SWE' ";
        $res = mysql_query($query) or die(mysql_error());
        while ($rs = mysql_fetch_array($res)) {
            $data[] = $rs;

            if ($selectedId == $rs['category_id']) {
                $selected = "selected='selected'";
            } else {
                $selected = "";
            }
            $options.="<option value='" . $rs['category_id'] . "' " . $selected . " >" . $rs['text'] . "</option>";
        }
	echo utf8_encode($options);
?>
