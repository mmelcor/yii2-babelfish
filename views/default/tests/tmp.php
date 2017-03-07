<?php



$file = '../../common/messages/de/messages.po';
$header = [];
$translations = [];
$po = file($file);
$i = 0;
$row = 0;
$len = 0;
foreach ($po as $line) {
    $len++;
    if ($line == "\n" || $line == "\r\n") {
	break;
    }
}
foreach ($po as $line) {
    if ($row < $len) {
	if ($line == "\n" || $line == "\r\n") {
	    $row++;
	    continue;
	}
	$chunk0 = explode(' ',trim($line))[0];
	$chunk1 = substr($line, strpos($line, " ") + 1);
	if (
	    substr($chunk0, 1, 18) == 'Project-Id-Version' ||
	    substr($chunk0, 1, 17) == 'POT-Creation-Date' ||
	    substr($chunk0, 1, 16) == 'PO-Revision-Date' ||
	    substr($chunk0, 1, 15) == 'Last-Translator' ||
	    substr($chunk0, 1, 13) == 'Language-Team' ||
	    substr($chunk0, 1, 8) == 'Language' ||
	    substr($chunk0, 1, 12) == 'MIME-Version' ||
	    substr($chunk0, 1, 12) == 'Content-Type' ||
	    substr($chunk0, 1, 25) == 'Content-Transfer-Encoding'
	) {
	    $chunk0 = substr($chunk0, 1, -1);
	    $chunk1 = substr($chunk1, 0, -4);
	}
	$header[$row][$chunk0] = $chunk1;
	$row++;
    } else {
	if ($line == "\n" || $line == "\r\n") {
	    $i++;
	}
	if ($line[0] == '#') {
	    $commentId = substr($line, 2, 10);
	    if ($commentId == 'TRANSLATED' || $commentId == 'TRANSLATOR') {
		$translations[$i][$commentId] = substr($line, 12, -1);
	    } else {
		$translations[$i][$line[0]] = substr($line, 2, -1);
	    }
	}
	if (substr($line,0,7) == 'msgctxt') {
	    $category = trim(substr(trim(substr($line,7)),1,-1));
	    $translations[$i]['msgctxt'] = $category;
	}
	if (substr($line,0,5) == 'msgid') {
	    $id = trim(substr(trim(substr($line,5)),1,-1));
	    $translations[$i]['msgid'] = $id;
	}
	if (substr($line,0,6) == 'msgstr') {
	    $msgstr = trim(substr(trim(substr($line,6)),1,-1));
	    $translations[$i]['msgstr'] = $msgstr;
	}
    }
}

print "<pre>";
print_r($header);
print "</pre>";
echo '<br>';
print "<pre>";
print_r($translations);
print "</pre>";

//write back to file

$newpo ="../views/site/tests/file.po";
foreach ($header as $entry) {
    foreach ($entry as $key => $value) {
	if (
	    $key == 'Project-Id-Version' ||
	    $key == 'POT-Creation-Date' ||
	    $key == 'PO-Revision-Date' ||
	    $key == 'Last-Translator' ||
	    $key == 'Language-Team' ||
	    $key == 'Language' ||
	    $key == 'MIME-Version' ||
	    $key == 'Content-Type' ||
	    $key == 'Content-Transfer-Encoding'
	) {
	    $data .= '"' . $key . ': ' . $value . "\\n\"\n";
	} else {
	    $data .= $key . ' ' . $value;
	}
    }
}
$data .= "\n";
foreach ($translations as $translation) {
    foreach ($translation as $key => $value) {
	if ($key == '#') {
	    $data .= $key . ' ' . $value . "\n";
	} elseif ($key == 'TRANSLATED' || $key == 'TRANSLATOR') {
	    $data .= '# ' . $key . ' ' . $value . "\n";
	} else {
	    $data .= $key . ' "' . $value . '"' . "\n";
	}
    }
    $data .= "\n";
}
file_put_contents($newpo, $data);






