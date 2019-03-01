:plain
    html = "{!! str_replace(["\n", "\r"], '', addslashes($html)) !!}";
	$("{!! $elem !!}").html(html);