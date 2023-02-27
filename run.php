<?php

$settingsFilePath = './settings.php';
$dir = '';
$mappings = [];
if (file_exists($settingsFilePath)){
	include_once ($settingsFilePath);
} else {
	die('Settings file not found, exit.');
}


$dryRun = false;
$verbose = false;
$interactive = true;
$excludeHidden = true;
foreach ($argv as $param) {
    if($param === '--dry' || $param === '-d') {
        $dryRun = true;
        echo "\n🔧 option dry run set";
    }
	if($param === '--verbose' || $param === '-v') {
		$verbose = true;
		echo "\n🔧 option verbose set";
	}
	if($param === '--non-interactive' || $param === '-y') {
		$interactive = false;
		echo "\n🔧 option non-interactive set";
	}
	if($param === '--include-hidden' || $param === '-h') {
		$excludeHidden = false;
		echo "\n🔧 option include-hidden set";
	}
}



echo "\n\n";
echo "👀 Start scanning \n";

$files = scandir($dir);

echo "found ".count($files)." files\n\n";

foreach ($files as $file) {
	if ($file === "." || $file === "..") {
		continue;
	}

	if ($excludeHidden && str_starts_with($file, ".")) {
		continue;
	}

    if ($verbose) {
        echo "File found: ".$file."\n";
		echo "------------------------------------------\n\n";
    }

    foreach ($mappings as $key => $value) {
        if ($verbose) {
            echo "Try mapping: ".$key."\n\n";
        }
        if(isMatch($value['keywords'], $value['excludes'], $file)) {
            echo "🔎 Found match in '".$file."' for rule '".$key."'\n";
			echo "Want to move to ".$value['folder']."\n";
            if ($dryRun) {
                echo "Dry run, will stop here.\n\n";
            } else {
                if($verbose) {
                    echo "Want to move\n";
                    echo "-> file: ".$file."\n";
                    echo "-> into folder: ".$value['folder']."\n\n";
                }
				moveFileAction($dir, $file, $value['folder'], $verbose, $interactive);
			}
        }
    }
	if ($verbose) {
		echo "\n\n\n";
	}

}
exit("No more files, end.\n");

function isMatch(array $keywords, array $excludes, string $string): bool
{
    foreach ($keywords as $keyword) {
        if(!strstr($string, $keyword)) {
            return false;
        }
    }
    foreach ($excludes as $exclude) {
        if(strstr($string, $exclude)) {
            return false;
        }
    }
    return true;
}

function escapePath($path): string {
    return str_replace(" ", "\ ", $path);
}

function moveFileAction($dir, $file, $destinationFolderPath, $verbose, $interactive): void
{
	$cmd = "mv ".escapePath($dir.'/'.$file)." ".escapePath($destinationFolderPath.'/'.$file);
	if ($verbose)
		echo "cmd: ".$cmd."\n";
	if($interactive) {
		$readline = readline_terminal('❔ Move file? [y,N]: ');
		if (strtolower($readline) === 'y') {
			$result = shell_exec($cmd);
		} else {
			echo "File not moved.\n\n";
			return;
		}
	} else {
		$result = shell_exec($cmd);
	}
	if ($verbose)
		echo "run bash mv result: ".$result;
	if ($result === '' || $result === null) {
		echo "✅ file moved to (".$destinationFolderPath.")\n\n";
	} else {
		echo "❌ error\n\n";
	}

}

function readline_terminal($prompt = ''): bool|string
{
	$prompt && print $prompt;
	$terminal_device = '/dev/tty';
	$h = fopen($terminal_device, 'r');
	if ($h === false) {
		#throw new RuntimeException("Failed to open terminal device $terminal_device");
		return false; # probably not running in a terminal.
	}
	$line = rtrim(fgets($h),"\r\n");
	fclose($h);
	return $line;
}