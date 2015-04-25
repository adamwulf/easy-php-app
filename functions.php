<?

function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

function page_self_url(){
	$url = 'http' . ($_SERVER["HTTPS"] == "on" ? "s" : "") . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	if(strpos($url, "?") !== false){
		$url = substr($url, 0, strpos($url, "?"));
	}
	if(strrpos($url, "/") != strlen($url)-1){
		$url .= "/";
	}
	return $url;
}

function prettyPrint($obj){
	echo str_replace("  ", " &nbsp;\n", str_replace("\n", "<br>\n", print_r($obj,true)));
}

?>