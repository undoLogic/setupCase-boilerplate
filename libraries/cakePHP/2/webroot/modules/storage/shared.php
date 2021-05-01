<?php

function writeToLog($filename, $message, $newLine = true)
{
	if ($newLine) {
		$message = "\n" . date('Ymd-His') . ' > ' . $message;
	} else {
		$message = ' > ' . $message;
	}
	file_put_contents($filename . '.log', $message, FILE_APPEND);
}
