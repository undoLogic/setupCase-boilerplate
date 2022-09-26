<?php
if (isset($_GET['testDate'])) {
	echo "<!-- Using TEST date " . $_GET['testDate'] . " | Server time is currently " . date('Y-m-d H:i:s') . " -->";
}
//date_default_timezone_set('UTC');
$token = '4#%&BD^*%EFHU*&^%$DCKHFD!!!ADFRGBNJF';
$pathJsonFile = '../Config/Schema/';

function writeToLog($message, $newLine = false)
{
	if (is_array($message)) {
		$message = implode("\n", $message);
	}
	if ($newLine) {
		$message = "\n" . date('Ymd-His') . ' > ' . $message;
	} else {
		$message = ' > ' . $message;
	}
	file_put_contents('updateCase.log', $message, FILE_APPEND);
}

//external communcations
if (isset($_POST['token'])) {
	if ($_POST['token'] != $token) {
		writeToLog('BAD TOKEN');
		die ('405: NO ACCESS - BAD TOKEN');

	} else {
		if (isset($_GET['test'])) {
			if ($_GET['test'] == 'true') {
				writeToLog('Test from: ' . $_SERVER['REMOTE_ADDR'], true);
				echo 'access granted';
				exit;
			}
		}

		if (isset($_GET['version'])) {
			if ($_GET['version'] == 4) {
				writeToLog('V4', true);

				$decoded = json_decode($_POST['variant']);
				//$uuid = $decoded->Variant->uuid;
				$uuid = $decoded[0]->Variant->uuid;
				$variant_id = $decoded[0]->Variant->id;

				if (empty($variant_id)) $variant_id = 'unknown';

				$pathJsonFile = $pathJsonFile . $variant_id . '/';

				if (!file_exists($pathJsonFile)) {
					mkdir($pathJsonFile);
				}

				$myfile = fopen($pathJsonFile . $uuid . ".json", "w") or die("Unable to open file!");
				fwrite($myfile, $_POST['variant']);
				fclose($myfile);

				echo 'IMPORTED';
				writeToLog('Imported', false);
			} else {
				echo 'Command not recognized';
				writeToLog('Command not recognized');
			}
		} elseif ($_GET['backup']) {

			//only allow from our main server
			$remoteAddr = $_SERVER['REMOTE_ADDR'];
			$allowedAccess = array('173.177.140.152', '192.252.156.42');
			if (in_array($remoteAddr, $allowedAccess)) {
				//we allow this server only to get data files

				//echo json_encode($_SERVER);exit;

				writeToLog('Backup: ' . $_GET['backup'], true);

				$path = $_SERVER['DOCUMENT_ROOT'] . '';
				$command = 'cd ' . $path . ' && ./app/Console/cake Backup';
				//echo $command;

				header('Content-Type: application/json');
				echo exec($command, $out);
				exit;
				//echo json_encode($out);exit;

			} else {
				die('error: you cannot access this from your location');
			}

		} elseif ($_GET['errorCheck']) {

			//only allow from our main server
			$remoteAddr = $_SERVER['REMOTE_ADDR'];
			$allowedAccess = array('173.177.140.152', '192.252.156.42');
			if (in_array($remoteAddr, $allowedAccess)) {
				//we allow this server only to get data files

				//echo json_encode($_SERVER);exit;

				writeToLog('ErrorCheck: ' . $_GET['errorCheck'], true);

				$path = $_SERVER['DOCUMENT_ROOT'] . '/logs/';
				$command = 'cd ' . $path . ' && test -f error.log && find error.log -type f -mtime -1 | xargs tail -n100';
				//$command = 'cd '.$path.' && tail -n100 error.log';
				//echo $command;

				//manual
				//cd /home/therathursdays/www/www/app/tmp/logs && test -f error.log && find error.log -type f -newer . | xargs tail -n25

				writeToLog('ErrorCheck: ' . $command, true);

				//header('Content-Type: application/json');
				$res = exec($command, $out);
				$response = array();
				$response['COMMAND'] = $command;
				if (empty($res)) {
					$response['STATUS'] = 404;
					writeToLog('NO ERRORS detected', true);
				} else {
					$response['STATUS'] = 200;
					writeToLog('FOUND ERRORS ' . strlen($res), true);
				}

				//$response['MSG'] = preg_replace("/[^a-zA-Z0-9]+/", "", $res);
				$response['LEN'] = strlen($res);
				$response['MSG'] = $out;

				header('Content-Type: application/json');
				echo json_encode($response);

				exit;
				//echo json_encode($out);exit;

			} else {
				die('error: you cannot access this from your location');
			}


		} else {
			writeToLog('NO VERSION SUPPLIED', true);
		}
	}
} else {
	//if this being accessed directly
	//writeToLog('Accessed Directly', true);
}

class UpdateCase
{

	var $host = "http://site.updatecase.com/";

	//detailed debug message
	var $debug = false;

	var $local_uuid = FALSE;
	var $variant_id = FALSE;

	var $json = '';
	var $jsonPath = '';
	var $state = 'UNKNOWN';

	var $jsonData = array(); //all the json data
	var $hostPath = 'http://site.updatecase.com/';

	var $uuid = '';

	var $variant = array();
	var $site = array();
	var $pages = array();
	var $page = array(); //this is the page information

	var $allPages = array();

	var $language = 'eng'; //default
	var $possibleLanguages = array(
		'eng' => 'eng',
		'en-us' => 'eng',
		'en-ca' => 'eng',
		'fr-ca' => 'fre',
		'fre' => 'fre',
		'fra' => 'fre',
		'ALL' => 'ALL',
		'es-la' => 'spa',
		'es-mx' => 'spa',
		'spa' => 'spa',
		'en_US' => 'eng',
		'en' => 'eng',
		'fr' => 'fre'
	);

	var $localUUID = '';

	function getCurrLang()
	{
		$setLang = $GLOBALS['currLang'];

		if (isset($this->possibleLanguages[$setLang])) {
			$setLang = $this->possibleLanguages[$setLang];
		}

		return $setLang;
	}

	////////////////////////////////////////////////////////////////////// initialization //////////////////////////////
	function getGlobal($var)
	{
		//pr ($var);
		//pr ($GLOBALS);
		if (isset($GLOBALS['UpdateCase'])) {
			//new version
			if (isset($GLOBALS['UpdateCase'][$var])) {
				return $GLOBALS['UpdateCase'][$var];
			} else {
				die("FATAL: MISSING \$GLOBALS['UpdateCase']['$var']");
			}
		} else {
			die("FATAL: MISSING \$GLOBALS['UpdateCase']['currLang'] && \$GLOBALS['UpdateCase']['variant_id']");
		}
	}

	function getVersion()
	{
		return $this->getGlobal('version');
	}

	function isPrepared($keepLogFile = false)
	{
		if (isset($_GET['resetDebug'])) {
			$this->setDebugOn();
		}

		//already loaded, we do not need to load again
		if (!empty($this->json)) {
			//$this->writeToLog('json already loaded', true);
			return true;
		} else {

			if ($this->debug) $this->writeToLog('isPrepared - first time init', true);

			$debugSTATUS = $this->decideDebug(); //always on
			$recentFilename_UUID = $this->getMostRecentFilename($this->getVariantId());

			if ($debugSTATUS == 'ON' || !$recentFilename_UUID) {

				//let's check to ensure we have the latest file
                if ($this->debug) $this->writeToLog('debugON or empty Recent file', false);
				$active_UUID = $this->downloadFromUpdateCase(
					$this->getVariantId(),
					$recentFilename_UUID
				);

			} else {

                if ($this->debug) $this->writeToLog('debugOFF - no connection to server', false);
				//debug is off, so let's be as fast as possible
				$active_UUID = $recentFilename_UUID;

			}

			//this is the UUID to use
			$this->local_uuid = $active_UUID;
			return $this->prepareJson($this->getVariantId());

		}
	}

	function getLocalUUID()
	{
		return $this->local_uuid;
	}

	private function prepareJson($variant_id)
	{
		if (!$this->local_uuid) {
			$this->writeToLog('404: no local uuid specified', true);
			die('404: lo local uuid specified');
			return false;
		} else {
			if (empty($this->json)) {
				//first time let's get our data
                if ($this->debug) $this->writeToLog('Preparing JSON (first time only)', false);

				//$this->jsonPath = APP . 'Config' . DS . 'Schema' . DS . $variant_id;
				//pr ($this->jsonPath);exit;
				$data = file_get_contents($this->jsonPath . DS . $this->local_uuid . '.json');

				//pr ($data);exit;
				$this->json = json_decode($data, true);

				if (isset($this->json[0]['Site'])) {
                    if ($this->debug) $this->writeToLog('Decoded json');
					$this->site = $this->json[0]['Site'];
					$this->variant = $this->json[0]['Variant'];
					$this->pages = $this->json[0]['Page'];
					$this->page = array();
                    if ($this->debug) $this->writeToLog(count($this->pages) . ' pages loaded', false);
				} else {
					$this->writeToLog(' - ERROR decoding json', true);
				}
			} else {
				//$this->writeToLog('JSON already loaded', false);
			}
			return true;
		}
	}

	public function getMostRecentFilename($variant_id = false)
	{
		if ($this->getVersion() == 4) {
			$this->jsonPath = '..' . DS . 'config' . DS . 'schema' . DS . $variant_id;
		} else {
			//2 old version
			$this->jsonPath = APP . 'Config' . DS . 'Schema' . DS . $variant_id;
		}

		if (!file_exists($this->jsonPath)) {
			$currDir = exec('pwd');
			$this->writeToLog($currDir . ' - mkdir: ' . $this->jsonPath, true);
			mkdir($this->jsonPath);
		}


		$files = scandir($this->jsonPath);

		foreach ($files as $fileKey => $file) {
			$ext = substr($file, -4);
			if ($ext != 'json') {
				unset($files[$fileKey]);
			}
		}

		foreach ($files as $key => $file) {
			if (strlen($file) < 20) { //we don't want to use the older manual name of sites
				unset($files[$key]);
			}
		}

		if (empty($files)) {
			return false;
		} else {
			//$this->writeToLog('found: ' . count($files) . ' file(s)');
			sort($files);
			$newestFile = end($files);
			$newestFile = str_replace(".json", '', $newestFile);
			$this->local_uuid = $newestFile;
			//$this->writeToLog('file: ' . $newestFile, false);

			return $newestFile;

		}
	}

	private function download($pathToUse)
	{

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $pathToUse);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); //improves speed
		$output = curl_exec($ch);
		curl_close($ch);

		return $output;
	}

	private function downloadFromUpdateCase($variant_id, $local_uuid = false)
	{
		//$this->writeToLog('downloadFromUpdateCase', true);

		//$this->jsonPath = APP . 'Config' . DS . 'Schema' . DS;

		$pathToUse = $this->hostPath . 'Variants/getCurrentUUID/' . $variant_id;
        if ($this->debug) $this->writeToLog('get UUID only from updateCase: ' . $pathToUse, false);

		$output = $this->download($pathToUse);

		//$this->writeToLog( 'After curl', true);

		$server_uuid = $output;

		if (empty($server_uuid)) {
			$this->writeToLog('404: uuid not avail', true);
			return false;
		} else {
			if ($local_uuid == $server_uuid) {
				//we are already up to date
				//$this->writeToLog('200: Already up to date', false);
				return $local_uuid;
			} else {
				$pathToUse = $this->hostPath . 'Variants/get/' . $variant_id;
				$this->writeToLog('GETTING NEW FILE: current_uuid: ' . $local_uuid . ' - server_uuid: ' . $server_uuid . ' - get full content updateCase: ' . $pathToUse, true);

				$newJsonContent = $this->download($pathToUse);

				//pr ($newJsonContent);exit;
				$folder = $this->jsonPath;

				$locationToWrite = $folder . DS . $server_uuid . '.json';

				// pr ($locationToWrite);
				// pr ($folder);exit;
				$this->writeToLog('Writing to : ' . $locationToWrite, false);
				file_put_contents($locationToWrite, $newJsonContent);
				$this->writeToLog('Downloaded NEW JSON: ' . $server_uuid, false);

				return $server_uuid;
			}
		}
	}

	private function getVariantId()
	{
		$this->variant_id = $this->getGlobal('variant_id');

		if (!$this->variant_id) {
			$this->writeToLog('Missing Variant_id', true);
		} else {
			//$this->writeToLog('variant_id: ' . $this->variant_id, false);
			return $this->variant_id;
		}
	}

	function getRecentFile()
	{
		if (!$this->local_uuid) {
			//get the most recent file
		} else {

		}
	}

	function getProdOrTestState()
	{
		//die ('getting: '.$this->state);
		return $this->state;
	}

	function setState($state)
	{
		$allowed = array(
			'PROD' => 'PROD',
			'TEST' => 'TEST'
		);
		if (isset($allowed[$state])) {
			$this->state = $allowed[$state];
			$this->writeToLog('STATE set to: ' . $this->state);
		}
	}

	function isCurrentLanguage($fieldLang)
	{
		$setLang = $this->getGlobal('currLang');

		if (isset($this->possibleLanguages[$setLang])) {
			$setLang = $this->possibleLanguages[$setLang];
		}
		if (isset($this->possibleLanguages[$fieldLang])) {
			$fieldLang = $this->possibleLanguages[$fieldLang];
		}
		if ($setLang == $fieldLang) {
			return true;
		} else {
			return false;
		}
	}

	private function decideDebug()
	{
//		$debug = $this->getDebugStatus();
//
//		if ($debug == 'OFF') {
//			return 'OFF';
//		} else {
//			//our debug is on so we might want to turn it off again
//			$lastTimeDebugEdited = filemtime(APP . 'Config' . DS . 'core.php');
//			$now = strtotime('now');
//			$diff = $now - $lastTimeDebugEdited;
//			if ($diff > 3600) { //it has been 15 minutes since we saved our file
//				if (isset($_SERVER['HTTP_HOST'])) {
//					if ($_SERVER['HTTP_HOST'] == 'localhost') {
//						return 'ON';
//					} else {
//						//we are NOT local so we can auto set to off
//						$this->writeToLog('Turning OFF debug', true);
//						$this->setDebugOff();
//						return 'OFF';
//					}
//				}
//			} else {
//				//$this->writeToLog('NOT Turning OFF debug YET (still time left before auto off)');
//				return 'ON';
//			}
//		}
		return 'ON';
	}

	///////////////////////////////////////////////////////////////////////////// AUTO DEBUG ///
	var $on_message = "Configure::write('debug',2);";
	var $off_message = "Configure::write('debug',0);";

	function setDebugOff()
	{

		//this will set the debug to
		$path_to_file = APP . 'Config';
		$file_contents = file_get_contents($path_to_file . DS . 'core.php');
		//print_r ($file_contents);exit;

		$file_contents = $this->turnOffDebug($file_contents);
		if ($file_contents) {
			//let's save it
			file_put_contents($path_to_file . DS . 'core.php', $file_contents);
			//$this->Session->setFlash('Debug mode is now OFF');
			//echo 'Debug mode is now OFF';

		} else {
			// echo 'Debug mode already off';
		}

	}

	function setDebugOn()
	{

		//this will set the debug to
		$path_to_file = APP . 'Config';
		$file_contents = file_get_contents($path_to_file . DS . 'core.php');
		//print_r ($file_contents);exit;

		$file_contents = $this->turnOnDebug($file_contents);
		if ($file_contents) {
			//let's save it
			file_put_contents($path_to_file . DS . 'core.php', $file_contents);
			//$this->Session->setFlash('Debug mode is now OFF');
			//echo 'Debug mode is now OFF';

		} else {
			// echo 'Debug mode already off';
		}

	}

	function getDebugStatus()
	{
		return 'ON';//fix later

		$path_to_file = APP . 'Config';
		$file_contents = file_get_contents($path_to_file . DS . 'core.php');
		//debug($file_contents);exit;
		$pos = strpos($file_contents, $this->on_message);
		if ($pos === false) {
			//there is no on message, let's check if there is an off
			$pos_off = strpos($file_contents, $this->off_message);
			if ($pos_off === false) {
				//there is a problem,manual intervention is required
				$msg = 'manual intervention required the debug message needs to be exactly: ' . $this->off_message;
				$this->writeToLog($msg);
				die ($msg);
			} else {
				//it's ok, there is an off, so let's repalce it
				//$this->writeToLog('Debug OFF');
				return 'OFF';
			}
		} else {
			//$this->writeToLog('Debug ON');
			return 'ON';
		}
	}

	private function turnOnDebug($contents)
	{

		//if the debug mode is on then return same string
		//if the debug mode if off, replace the contents
		//        $on_message = "Configure::write('debug',2);";
		//        $off_message = "Configure::write('debug',0);";
		$pos = strpos($contents, $this->on_message);
		if ($pos === false) {
			//there is no on message, let's check if there is an off
			$pos_off = strpos($contents, $this->off_message);
			if ($pos_off === false) {
				//there is a problem,manual intervention is required
				$msg = 'manual intervention required the debug message needs to be exactly: ' . $this->off_message;
				$this->writeToLog($msg);
				die ($msg);

			} else {
				//it's ok, there is an off, so let's repalce it
				$contents_modified = str_replace($this->off_message, $this->on_message, $contents);
				return $contents_modified;
			}
		} else {
			//it's already on
			return false;
		}
	}

	private function turnOffDebug($contents)
	{

		//if the debug mode is on then return same string
		//if the debug mode if off, replace the contents

		$pos = strpos($contents, $this->off_message);
		if ($pos === false) {
			//there is no off message, let's check if there is an on
			$pos_off = strpos($contents, $this->on_message);
			if ($pos_off === false) {
				//there is a problem,manual intervention is required
				$msg = 'manual intervention required the debug message needs to be exactly: ' . $this->on_message;
				$this->writeToLog($msg);
				die ($msg);

			} else {
				//it's ok, there is an off, so let's repalce it
				$contents_modified = str_replace($this->on_message, $this->off_message, $contents);
				return $contents_modified;
			}
		} else {
			//it's already on
			return false;
		}
	}

	function setDate($date)
	{
		//override the date
		$this->date = date('Y-m-d H:i:s', strtotime($date));
		$this->writeToLog('Date set to: ' . $this->date, true);
	}

	var $date = false;

	function getDate()
	{
		if (!$this->date) {
			//allow to override since it is not set yet
			if (isset($_GET['testDate'])) {
				$this->date = date('Y-m-d H:i:s', strtotime($_GET['testDate']));
			} else {
				$this->date = date('Y-m-d H:i:s');
			}
		} else {
			//date already set
		}

		return $this->date;
	}

	var $logFile = "updateCase.log";

	function writeToLog($message, $newLine = false)
	{

		if (is_array($message)) {
			$message = implode("\n", $message);
		}
		if ($newLine) {
			$message = "\n" . date('Ymd-His') . ' > ' . $message;
		} else {
			$message = ' > ' . $message;
		}

		$fp = fopen($this->logFile, "a");
		fwrite($fp, $message);
		fclose($fp);
		//file_put_contents('updateCase.log', $message, FILE_APPEND);

		//echo APP.'tmp/logs/'.$type;
	}

	function eraseLogFile()
	{
		return file_put_contents($this->logFile, '');
	}

	////////////////////////////////////////////////////////////////////// END of initialization ///////////////////////

	private function getElement($locationName, $elementName, $groupName = false)
	{
		if (!$this->isPrepared()) {
			return false;
		} else {

			if ($this->debug) $this->writeToLog('GetElement ' . $locationName . ':' . $elementName . ':' . $groupName, true);
			$locationKey = $this->getLocationKey($locationName);

            $elementKey = $this->getElementKey($locationKey, $elementName, $groupName);
			if (isset($this->page['Location'][$locationKey]['Element'][$elementKey])) {
				return $this->page['Location'][$locationKey]['Element'][$elementKey];
			} else {
				$this->writeToLog('ERROR: Element: "'.$elementName.'" Location: "'.$locationName.'" group: "'.$groupName.'" NOT FOUND', true);
			}
		}
	}

	private function getElementKey($locationKey, $elementToFind, $group) {
		if (!$this->isPrepared()) {
			return false;
		} else {

            $groupMsg = '';
            if (isset($this->page['Location'])) {
                if (isset($this->page['Location'][$locationKey])) {
                    foreach ($this->page['Location'][$locationKey]['Element'] as $elementKey => $element) {
                        //@todo add all the logic about if it's a dated one etc

                       // pr ($element);

                        //if we have a group we are going to skip all elements that have group 0
                        if (!$group) {
                            $groupMsg = 'WITHOUT group: "'.$group.'"';
                            if ($element['groupBy'] == 0) {
                                //this is good as groupBy is ZERO and we are NOT looking for a group
                            } else {
                                continue; //skip this bad
                            } //we do NOT want group zero
                        } else {
                            //we are looking for a group
                            $groupMsg = 'WITH group: "'.$group.'"';
                            if ($element['groupBy'] == $group) {
                                //this is the correct group
                            } else {
                                continue;
                            }
                        }

                        //no group to use
                        //pr ($element);
                        //pr ($group);exit;
                        //pr ($element);
                        if ($element['language'] == 'ALL') {
                            if ($elementToFind == $element['name']) {
                                return $elementKey;
                            }
                        } else if ($this->isCurrentLanguage($element['language'])) {
                            if ($elementToFind == $element['name']) {
                                return $elementKey;
                            }
                        }
                    }
                }
            }
            //nothing
            $this->writeToLog('ERROR: No elements were found matching "'.$elementToFind.'" '.$groupMsg, true);
		}
	}
	private function getLocationKey($locationToFind) {
		if (!$this->isPrepared()) {
			return false;
		} else {
            $date = $this->getDate();
			foreach ($this->page['Location'] as $locationKey => $location) {

                $extendedLocationName = $this->getExtendedName($location['name']);

				if ($locationToFind == $extendedLocationName) {
                    //This will check all names even with :::name at the end
                    //now we need to ensure the date is correct
                    //pr ($location);exit;

                    if ($location['active_status'] == 0){
                        //this is active
                        return $locationKey;

                    } else if ($location['active_status'] == 1) {
                        //by date
                        if ($location['date_active'] === '0000-00-00 00:00:00' && $location['date_expire'] === '0000-00-00 00:00:00') {
                            //set to zeros
                            return true;
                        } else if (
                            (strtotime($date) >= strtotime($location['date_active']))
                            and
                            (strtotime($date) <= strtotime($location['date_expire']))
                        ) {
                            return $locationKey;
                        }
                    } else if ($location['active_status'] == 2) {
                        //NOT active
                    }
				}
			}
            $this->writeToLog('ERROR: Location "'.$locationToFind.'" was NOT found (page: '.$this->page['name'].')', true);
        }
	}
    /*
     * if a date is active the loation name will be appended by :::name this will remove so it can be checked
     */
    function getExtendedName($name){

        //handle the time specific
        $tmp = explode(':::', $name);
        if (isset($tmp[1])) {
            // this is an extended name
            return $tmp[0];
        } else {
            //this is NOT an extneded name, so we send normal name
            return $name;
        }
    }



	//////////////////////////////////////////////// end refactor



	function getTextOnly($text, $limit = false)
	{
		if ($limit) {
			$textShort = substr(strip_tags($text), 0, $limit);
			if (strlen($text) > $limit) {
				return $textShort . '...';
			} else {
				return $textShort;
			}
		} else {
			return strip_tags($text);
		}


	}

	////new stuff
	///
	///
	///
	///
	///

	function removeImages($string)
	{
		return preg_replace("/<img[^>]+\>/i", "", $string);
	}

	function removeHtmlElements($str)
	{
		$str = preg_replace('/\<[\/]{0,1}div[^\>]*\>/i', '', $str);
		return $str;
	}


	function currLang()
	{
		$currLang = $this->getGlobal('currLang');
		$this->language = $currLang;
		return $currLang;
	}

	public function loadPageBySlug($slug)
	{
		if (!$this->isPrepared()) {
			$this->writeToLog('FATAL: Not Prepared');
			die('Not prepared');
		} else {
			//load our page
			foreach ($this->pages as $page) {
				if (strtolower($page['slug']) == 'all') {
					$this->allPages = $page;
				}
				if (trim($page['slug']) == trim($slug)) {
					$this->page = $page;
					//$this->writeToLog('loadPageBySlug: '.$slug.' Loaded');
				}
			}
		}
	}

	public function getContentBy($locationName, $elementName, $groupName = false, $slug = false)
	{

		if ($slug) {
			$this->loadPageBySlug($slug);
		}

		if (!$this->isPrepared()) {
			$this->writeToLog('NOT isPrepared');
			return false;
		} else {
			if ($groupName == 'false') $groupName = false;

			if (empty($this->page)) {
				$this->writeToLog('Page not setup', true);
				return false;
			}

			//pr('Location: "' . $locationName . '" elm: "' . $elementName . '" gr: ' . $groupName);

			$element = $this->getElement($locationName, $elementName, $groupName);
			//@todo add is location active

			//pr ($element);exit;

			if (isset($element['name'])) {
				if ($element['name'] == 'image') {
					return true;
				} else {
					return $element['Revision'][0]['content_text'];
				}
			} else {
				return false;
			}

		}

	}

	public function getImageBy($location, $element, $group = false, $size = 'medium', $slug = false)
	{
		$debug = true;

		if ($slug) {
			$this->loadPageBySlug($slug);
		}

		if ($group == 'false') {
			$group = false;
		}

		//APP.'webroot'.DS.
		//$cache = 'images' . DS . Configure::read("UpdateCase.variant_id") . DS;
		$cache = 'images' . DS . $this->getGlobal('variant_id') . DS;

		//exec('ls', $oupt);
		//pr($oupt);
		//exit;
		//die ($cache);
		$element = $this->getElement($location, $element, $group);

		//pr ($element);
		//exit;

		if (!isset($element['Revision'][0])) {
			$this->writeToLog('No revision for the image');
			return false;
		} else {
			$mime = $element['Revision'][0]['mime'];
			$id = $element['Revision'][0]['id'];

			//pr ($element);exit;
			//pr ($mime);
			//exit;

			if ($this->debug) $this->writeToLog('mime: ' . $mime . ' id: ' . $id);

			if ($mime == 'image/jpeg') {
				$filename = $id . '.jpg';
			} elseif ($mime == 'image/png') {
				$filename = $id . '.png';
			} else {

				//@todo find a way to get the mime when it is not available
				//default
				$filename = $id . '.jpg';

				//pr ($this->revision);
				//$this->writeToLog('cannot load image', true);
				//echo $message;
				//exit;
				//return false;
			}

			if (file_exists($cache . $filename)) {
				//return the local file
				if ($this->debug) $this->writeToLog('have local file: ' . $cache . $filename);
				return $cache . $filename;
			} else {
				//create the file locally
				if ($this->debug) $this->writeToLog('create folder: ' . $cache);

				if (!file_exists($cache)) {

					//$this->writeToLog('Trying to create folder: ' . $cache);

					mkdir($cache);
				}

				if (!file_exists($cache)) {
					if ($this->debug) $this->writeToLog('Image Cache missing: ' . $cache);
				} else {

					//new
					$imageLink = $this->host . 'imagesGet/' . $id . '/' . $size . '/pic.jpg';
					//$this->writeToLog('imageLink: '.$imageLink, true);

					$output = $this->download($imageLink);

					if ($this->debug) $this->writeToLog('Writing image: ' . $imageLink . ' to ' . $cache . $filename);
					$res = file_put_contents($cache . $filename, $output);

					//$this->writeToLog($cache.$filename, true);

					return $cache . $filename;
				}
			}
		}


	}

	public function getFileBy($location, $element, $group = false, $slug = false)
	{
		if ($slug) {
			$this->loadPageBySlug($slug);
		}

		$cache = 'images' . DS . Configure::read("UpdateCase.variant_id") . DS;

		if ($group == '') {
			$group = false;
		}
		//pr ($element);
		$id = $this->getIdBy($location, $element, $group);

		if (!$id) {
			$message = 'File cannot load | Location: ' . $location . ' / Element ' . $element . ' / Group:' . $group;
			$this->writeToLog($message, true);
			return false;
		}

		$element = $this->getElement($location, $element, $group);

		$revision = $element['Revision'][0];

		//pr ($revision);exit;
		//pr ($id);
		if ($revision['mime'] == 'application/pdf') {
			$filename = $id . '.pdf';
		} elseif ($revision['mime'] == 'application/epub') {
			$filename = $id . '.epub';
		} elseif ($revision['mime'] == 'application/epub+zip') {
			$filename = $id . '.epub';
		} elseif ($revision['mime'] == 'application/mobi') {
			$filename = $id . '.mobi';
		} elseif ($revision['mime'] == 'application/octet-stream') {
			$filename = $id . '.mobi';
		} elseif ($revision['mime'] == 'image/jpeg') {
			$filename = $id . '.jpg';
		} else {

			//echo 'cannot load slug';
			//pr ($this->revision);
			//pr ($id);exit;

			//exit;
			//pr ($this->revision);
			//$message = 'File cannot load | SLUG: ' . $this->slug . ' / Location: ' . $location . ' / Element ' . $element . ' / Group:' . $group;
			//$this->writeToLog($message, true);
			//echo $message;
			//exit;
			//return $message;
			return false;
		}


		//pr ($filename);
		//does a cached version exist
		$file = new File($cache . $filename);

		// pr ($filename);exit;

		if ($file->exists()) {
			//return the local file
			return $cache . $filename;
		} else {
			//create the file locally

			$dir = new Folder($cache, true, 0775);

			if (file_exists($cache)) {

				//$imageLink = 'https://site.updatecase.com/display/' . $id . '/file.png';
				$imageLink = 'https://site.updatecase.com/display/' . $id . '/' . $filename;

				$arrContextOptions = array(
					"ssl" => array(
						"verify_peer" => false,
						"verify_peer_name" => false,
					),
				);
				$output = file_get_contents($imageLink,
					false,
					stream_context_create($arrContextOptions)
				);

				$file->write($output);
				return $cache . $filename;
			} else {
				//something went wrong with creating the folder, so let's just return the link from our server
				//$imageLink = 'http://files.setupcase.com/display/' . $id . '/file.png';
				$imageLink = 'http://site.updatecase.com/display/' . $id . '/file.png';
				return $imageLink;
			}
		}
	}

	public function getLinkBy($locationName, $elementName, $groupName = false, $slug = false, $prefix = 'http://')
	{
		return $this->ensureHttpOrHttps(
			$this->getContentBy($locationName, $elementName, $groupName, $slug), $prefix
		);
	}

	public function ensureHttpOrHttps($url, $prefix = 'http://')
	{
		if (substr($url, 0, 7) == 'http://') {
			return $url;
		} else if (substr($url, 0, 8) == 'https://') {
			return $url;
		} else {
			//add it
			return $prefix . $url;
		}
	}

	function isLocationActive($currLocationName)
	{

		//pr ($this->page);exit;
		foreach ($this->page['Location'] as $location) {
			if ($currLocationName == $location['name']) {

				if ($location['date_active'] === '0000-00-00 00:00:00' && $location['date_expire'] === '0000-00-00 00:00:00') {
					//set to zeros
					return true;
				} else if (
					(strtotime('now') > strtotime($location['date_active']))
					and
					(strtotime('now') < strtotime($location['date_expire']))
				) {
					return true;
				}

			}
		}
		//die('false');
		return false;
	}

	public function doesSlugExist($slug)
	{

		foreach ($this->pages as $page) {
			if ($page['slug'] == $slug) {
				return true;
			}
		}
		return false;
	}

	private function getByWithoutLoading($slug, $location_to_check, $element_to_check, $lang = false)
	{

		if (!$this->isPrepared()) {
			return false;
		} else {

			if (!$lang) {
				$lang = $this->currLang();
			}

			//get the page

			//pr ($this->pages);exit;
			foreach ($this->pages as $page) {

				if ($page['slug'] == $slug) {

					foreach ($page['Location'] as $location) {
						if ($location['name'] == $location_to_check) {
							foreach ($location['Element'] as $element) {
								if ($element['name'] == $element_to_check) {

									if ($this->isCurrentLanguage($element['language'])) {
										if (isset($element['Revision'][0])) {
											return trim($element['Revision'][0]['content_text']);
										}
									}

								}
							}
						}
					}
				}

			}
		}
	}

	public function getPageSlugsByTag($tagName, $sortBy = 'DATE-ASC', $ensureAllTags = false, $limitToLang = false)
	{

		$pageNames = array();

		$sort = array();
		$available = '';
		//get the page

		//pr ($this->pages);exit;


		//pr ($tagName);
		//exit;

		$pagesWithTags = array();

		foreach ($this->pages as $keyPage => $page) {

			if (!empty($page['Tag'])) {
				//loop through our tags
				//if any are missing not match
				if (is_array($tagName)) {
					foreach ($tagName as $eachTagName) {
						foreach ($page['Tag'] as $pageTag) {
							if ($pageTag['name'] == $eachTagName) {
								$pagesWithTags[$page['slug']]['tag'][$eachTagName] = $eachTagName;
								$pagesWithTags[$page['slug']]['date'] = $page['date'];
							}
						}
					}
				} else {
					foreach ($page['Tag'] as $pageTag) {
						if ($pageTag['name'] == $tagName) {
							$pagesWithTags[$page['slug']]['tag'][$tagName] = $tagName;
							$pagesWithTags[$page['slug']]['date'] = $page['date'];

						}
					}
				}


			}
		}

		if ($ensureAllTags) {
			foreach ($pagesWithTags as $slug => $eachPageWithTags) {
				//we need all our tags, so unset the pages that do not have both
				if (is_array($tagName)) {
					foreach ($tagName as $eachTagName) {
						if (!isset($eachPageWithTags['tag'][$eachTagName])) {
							unset($pagesWithTags['tag'][$slug]);
						}
					}
				} else {
					if (!isset($eachPageWithTags['tag'][$tagName])) {
						unset($pagesWithTags['tag'][$slug]);
					}
				}
			}
		}


		//pr ($sortBy);
		//exit;
		//pr ($pagesWithTags);
		//exit;
		if ($sortBy == 'ASC') {
			//sort by the date which is the key
			ksort($pagesWithTags);
		} else if ($sortBy == 'DESC') {
			krsort($pagesWithTags);
		} else if ($sortBy == 'DATE-ASC') {
			uasort($pagesWithTags, function ($item1, $item2) {
				if ($item1['date'] == $item2['date']) return 0;
				return $item1['date'] > $item2['date'] ? -1 : 1;
			});
		} else if ($sortBy == 'DATE-DESC') {
			//pr ('here');
			uasort($pagesWithTags, function ($item1, $item2) {
				if ($item1['date'] == $item2['date']) return 0;
				return $item1['date'] > $item2['date'] ? -1 : 1;
			});
		}

		//pr ($pagesWithTags);
		//exit;
		$return = array();
		foreach ($pagesWithTags as $slug => $tags) {
			$return[$slug] = $slug;
		}
		return $return;
	}

	private function cleanUpStringForQuotedSections($str)
	{
		return str_replace('"', "'", $str);
	}

	public function getImage($location, $element, $group = false, $size = 'medium')
	{
		return $this->getImageBy($location, $element, $group, $size);
	}

	public function getPageLang()
	{
		$page = $this->page;

		$langs = array();

		foreach ($page['Location'] as $location) {
			foreach ($location['Element'] as $element) {
				$langs[$element['language']] = $element['language'];
			}
		}

		return $langs;
	}

	public function getPageDate($format = 'Y-m-d H:i:s')
	{

		$date = strtotime($this->page['date']);
		$lang = $this->currLang();
		if ($lang == 'fre') {

			if ($format == 'Y') {
				return date($format, $date);
			} else {
				//french
				setlocale(LC_ALL, 'fr_FR.UTF-8');
				//echo date('D d M, Y');
				//return strftime("%a %d %b %Y", $date);
				return strftime("%e %B %Y", $date);
				//$shortDate = strftime("%d %b %Y", $date);
			}
		} else {
			return date($format, $date);
		}

	}

	public function getPage()
	{
		return $this->page;
	}

	//////////////////////////////////////////////////// Depreciated ///////////////////////////

//	function reset($variant_id = false, $uuid = false)
//	{
//
//		if ($uuid) {
//			$filename = APP . 'Config' . DS . 'Schema' . DS . $variant_id . DS . $uuid . '.json';
//			if (file_exists($filename)) {
//				unlink($filename);
//			}
//		}
//
//		$this->site = array();
//		$this->variant = array();
//		$this->pages = array();
//		$this->page = array();
//		$this->json = array();
//
//		$this->writeToLog('RESET', true);
//	}


	//do we need this ? it is really that must faster ?????
	private function doesNewerExist($variant_id, $newestUuid)
	{
		$HttpSocket = new HttpSocket();

		$pathToUse = $this->hostPath . 'public/variants/uuid/' . $variant_id . '/' . $newestUuid;

		//pr ($pathToUse);exit;
		$this->writeToLog('get file from updateCase: ' . $pathToUse, true);

		$response = $HttpSocket->post($pathToUse, array(
			'token' => Configure::read('updateCase.token'),
		));

		//pr ($response->body);
		//exit;
		if (empty($response->body)) {
			$this->writeToLog('we have current file', false);
			return false;
		} else {
			$tmp = explode(":", $response->body);
			switch ($tmp[0]) {
				case '200':
					return false;
					break;
				default:
					return true;
			}
		}
	}

	public function getTagsFromAllPages($ignore = array())
	{
		//pr ($this->pages);

		$allTags = array();
		foreach ($this->pages as $this->page) {
			$allTags = $allTags + $this->getTags($ignore);
		}
		return $allTags;

	}

	public function isTagPresent($tag)
	{
		$tags = $this->getTags();

		if (isset($tags[$tag])) {
			return true;
		} else {
			return false;
		}
	}

	public function getTags($ignore = array())
	{
		//pr ($this->page);

		if (!$this->isPrepared()) {
			return false;
		} else {

			$tags = array();
			if (isset($this->page['Tag'])) {
				foreach ($this->page['Tag'] as $tag) {


					if (in_array($tag['name'], $ignore)) {
						//ignore
					} else {
						$tags[$tag['name']] = $tag['name'];
					}
				}
			}

		}

		//pr ($tags);
		return $tags;
		//exit;
	}

	public function getIdBy($locationName, $elementName, $groupName = false)
	{

		if ($groupName == 'false') $groupName = false;

		if (empty($this->page)) {
			$this->writeToLog('Page not setup', true);
			return false;
		}

		$element = $this->getElement($locationName, $elementName, $groupName);
		//@todo add is location active

		if (isset($element['Revision'])) {
			return $element['Revision'][0]['id'];
		} else {
			return false;
		}
	}

	public function getMetaTitle()
	{
		//do we have a set slug


		$title = '';
		$slug = Configure::read("UpdateCase.slug");


		if (!empty($slug)) { //we have a page specific
			if ($this->doesSlugExist($slug)) {
				$title = $this->cleanUpStringForQuotedSections($this->getByWithoutLoading($slug, $this->seoLocationName, 'title'));
			}
		}
		if (empty($title)) {

			if ($this->doesSlugExist('All')) {
				$title = $this->cleanUpStringForQuotedSections($this->getByWithoutLoading('All', $this->seoLocationName, 'title'));
			}
		}

		return $title;

		//do we have a all page with meta
		//return false;
	}

	public function getMetaDescription()
	{

		$field = '';
		$slug = Configure::read("UpdateCase.slug");

		if (!empty($slug)) { //we have a page specific
			if ($this->doesSlugExist($slug)) {
				$field = $this->cleanUpStringForQuotedSections($this->getByWithoutLoading($slug, $this->seoLocationName, 'description'));
			}
		}
		if (empty($title)) {

			if ($this->doesSlugExist('All')) {
				$field = $this->cleanUpStringForQuotedSections($this->getByWithoutLoading('All', $this->seoLocationName, 'description'));
			}
		}
		return $field;
	}

	public function getMetaKeywords()
	{
		$field = '';
		$slug = Configure::read("UpdateCase.slug");

		if (!empty($slug)) { //we have a page specific
			if ($this->doesSlugExist($slug)) {
				$field = $this->cleanUpStringForQuotedSections($this->getByWithoutLoading($slug, $this->seoLocationName, 'keywords'));
			}
		}
		if (empty($title)) {

			if ($this->doesSlugExist('All')) {
				$field = $this->cleanUpStringForQuotedSections($this->getByWithoutLoading('All', $this->seoLocationName, 'keywords'));
			}
		}
		return $field;
	}

	public function getMetaProperty($name)
	{
		$desc = '';

		//do we have a set slug
		$slug = Configure::read("UpdateCase.slug");
		if (!empty($slug)) { //we have a page specific
			if ($this->doesSlugExist($slug)) {
				$desc = $this->cleanUpStringForQuotedSections($this->getByWithoutLoading($slug, $this->seoLocationName, $name));
			}
		}

		if (empty($desc)) {
			if ($this->doesSlugExist('All')) {
				$desc = $this->cleanUpStringForQuotedSections($this->getByWithoutLoading('All', $this->seoLocationName, $name));
			}
		}

		return $desc;

		//do we have a all page with meta
		//return false;
	}

	//OG
	public function getMetaOgLocale($lang)
	{


		$send = array(
			'en' => 'en_CA',
			'fr' => 'fr_CA',
			'eng' => 'en_CA',
			'fre' => 'fr_CA'
		);
		if (isset($send[$lang])) {
			return $send[$lang];
		}
		return false;
	}

	public function getMetaOgLocaleAlternate($lang)
	{
		$send = array(
			'eng' => 'fr_CA',
			'en' => 'fr_CA',
			'fre' => 'en_CA',
			'fr' => 'en_CA'
		);
		if (isset($send[$lang])) {
			return $send[$lang];
		}
		return false;
	}

	public function getMetaOgUrl($webroot, $params)
	{

		return $webroot . $params->url;

		//pr ($webroot);
		//pr ($params);
		//pr ($webroot. ltrim($params->here, '/'));exit;
	}

	public function getMetaOgSiteName()
	{
		//do we have a set slug

		$title = '';
		$slug = Configure::read("UpdateCase.slug");


		if (!empty($slug)) { //we have a page specific
			if ($this->doesSlugExist($slug)) {
				$title = $this->cleanUpStringForQuotedSections($this->getByWithoutLoading($slug, $this->seoLocationName, 'og-site_name'));
			}
		}
		if (empty($title)) {

			if ($this->doesSlugExist('All')) {
				$title = $this->cleanUpStringForQuotedSections($this->getByWithoutLoading('All', $this->seoLocationName, 'og-site_name'));
			}
		}

		return $title;

		//do we have a all page with meta
		//return false;
	}

	public function getMetaOgImage($webroot = false)
	{
		//do we have a set slug

		$imageUrl = '';
		$slug = Configure::read("UpdateCase.slug");


		if (!empty($slug)) { //we have a page specific
			if ($this->doesSlugExist($slug)) {
				$this->loadPageBySlug($slug);
				$image = $this->getImage('SEO', 'og-image');
			}
		}
		if (empty($title)) {
			$this->loadPageBySlug('All');

			if ($this->doesSlugExist('All')) {
				$image = $this->getImage('SEO', 'og-image');
			}
		}

		if ($webroot) {
			$imageUrl = $webroot . $image;
		} else {
			$imageUrl = $image;
		}
		//$title = str_replace("<img src='", '', $title);
		// $title = str_replace("' />", '', $title);
		return $imageUrl;

		//do we have a all page with meta
		//return false;
	}

	var $seoLocationName = 'SEO';

	var $convertToLongLang = array(
		'eng' => 'en-ca',
		'fre' => 'fr-ca'
	);

	public function getPageSlugsByTagWithLocationElement($tagName, $sortBy = 'ASC', $location, $element, $group = false, $limit = false, $offset = false, $options = false)
	{


		if ($this->isPrepared()) {

			$pageNames = array();
			//$this->page = false;

			$sort = array();

			//get the page

			//pr ($this->pages);exit;

			foreach ($this->pages as $keyPage => $page) {


				// pr ($page);

				if (!$this->existsInPage($page['slug'], $location, $element, $group)) {
					//die ('does not exist');
					continue;
				}


				//pr ($this->language);exit;


				$pagesHasStuffForThisLanguage = false;
				//let's ensure we have the following location / element
				foreach ($page['Location'] as $tierLocation) {
					foreach ($tierLocation['Element'] as $tierElement) {

						//pr ($tierElement);exit;

						if ($this->language == $this->possibleLanguages[$tierElement['language']]) {
							$pagesHasStuffForThisLanguage = true;
						}
					}
				}

				//skip this page it has not element of this language
				if (!$pagesHasStuffForThisLanguage) continue;

				if (!empty($page['Tag'])) {
					foreach ($page['Tag'] as $tag) {

						if (is_array($tagName)) {
							if (in_array($tag['name'], $tagName)) {
								//this tag is present
								$sort[$page['slug']] = strtotime($page['date']);
							}
						} else {
							if ($tag['name'] == $tagName) {
								//this tag is present
								$sort[$page['slug']] = strtotime($page['date']);
							}
						}
					}
				}
			}

			//die('after');


			if ($sortBy == 'ASC') {
				//sort by the date which is the key
				asort($sort);
			} else {
				arsort($sort);
			}

			foreach ($sort as $slug => $num) {
				$pageNames[$slug] = $slug;
			}

			if ($options) {
				if ($options == 'SHUFFLE') {

					$keys = array_keys($pageNames);
					shuffle($keys);
					foreach ($keys as $key) {
						$new[$key] = $pageNames[$key];
					}
					$pageNames = $new;
				}

			}
			//pr ($pageNames);exit;

			$this->total = count($pageNames);

			if (empty($pageNames)) {
				return array();
//            $message = 'Tag not found: ' . $tagName;
//            return $this->missingMessage($message);
				exit;
			}

			if (!$limit) {
				return $pageNames;
			} else {
				$pageNames = array_slice($pageNames, (($offset - 1) * $limit), $limit);
				return $pageNames;
			}

			//pr ($pageNames);
			//exit;

		} else {


		}


	}

	public function getImageAltTag($location, $element, $group = false, $size = 'medium')
	{
		if ($size != 'medium') {
			$alt = 'alt="' . $location . '-' . $element . '-' . $group . '-' . $size;
		} else {
			$alt = 'alt="' . $location . '-' . $element . '-' . $group;
		}
		$alt = rtrim($alt, '-');
		$alt .= '"'; //close the hyphen

		return $alt;
	}

	private function prepareTranslation($element_to_check, $term)
	{

		//$translations = $this->getByWithoutLoading('All', 'Translations', $element, 'en-ca');

		if (!$this->isPrepared()) {
			return false;
		} else {

			//get the page

			$translations = '';
			//pr ($this->pages);exit;
			foreach ($this->pages as $page) {

				if ($page['slug'] == 'All') {

					foreach ($page['Location'] as $location) {
						if ($location['name'] == 'Translations') {
							foreach ($location['Element'] as $element) {
								if ($element['name'] == $element_to_check) {


									if (isset($element['Revision'][0])) {
										$translations = trim($element['Revision'][0]['content_text']);
									}


								}
							}
						}
					}
				}

			}
		}

		//pr ($translationsText);

		//pr ($translations);

		//echo 'trans'.$translations.'222';
		//exit;

		if (!empty($translations)) {
			//pr ($this->getByWithoutLoading('All', 'Translations', $element));
			$title = $this->cleanUpStringForQuotedSections($translations);
			//pr ($title);exit;
		} else {
			//die ('no transl');
			//no translation
			return $term;
		}
		$title = str_replace("\n", "<-->", $title);
		$title = str_replace("<br><br/>", "<-->", $title);
		$title = str_replace("<br />", "<-->", $title);
		$title = str_replace("<br/>", "<-->", $title);
		$title = trim($title);
		//echo $title;
		//exit;
		$tmp = explode("<-->", $title);
		//print_r ($tmp);exit;
		//pr ($tmp);
		//exit;

		foreach ($tmp as $eRow) {
			//print_r ($eRow);
			$tmp_term = explode(">", trim($eRow));
			//pr ($tmp_term);exit;
			if (strtolower(trim($tmp_term[0])) == strtolower(trim($term))) {
				if (empty($tmp_term[1])) {
					return $term;
				} else {
					return $tmp_term[1];
				}

			}
		}

		//IF WE ARE TESTING THEN ADD FOR FUTURE
		$debugSTATUS = $this->decideDebug();

		if ($debugSTATUS == 'ON') {
			//keep track if we do NOT have a translation and add to the file
			$this->keepTrackOfNewTranslations($term);
		}

		return $term;
	}

	public function keepTrackOfNewTranslations($newWord)
	{


		if (!file_exists('updateCaseTranslations.txt')) {
			file_put_contents('updateCaseTranslations.txt', '');
		}
		//check if we already have this word
		$current = file_get_contents('updateCaseTranslations.txt');
		//pr ($current);
		$lines = explode("\n", $current);
		foreach ($lines as $line) {
			$check = str_replace(">", "", $line);

			//$this->writeToLog('check: '.$check.' newWord: '.$newWord, true);
			if (strtoupper($newWord) == strtoupper($check)) {
				//already have it
				return false;
			} else {
				//save it
			}
		}

		if (empty($newWord)) {
			return false;
		}

		$current = $current . "\n" . $newWord . '>';
		file_put_contents('updateCaseTranslations.txt', $current);
	}

	public function Translate($term, $element = 'en->fr')
	{

		if (empty($term)) {
			return $term;
		}

		if ($this->currLang() == 'en') {
			//do we have a en->en translations or modifications to the same word
			$translated = $this->prepareTranslation('en->en', $term);
		} else {
			$translated = $this->prepareTranslation($element, $term);
		}

		return $translated;
	}

	public function exists($locationName, $elementName = false, $groupName = false)
	{

		$debug = false;

		$this->writeToLog('Does location exist: ' . $locationName . ' element: ' . $elementName . ' gr:' . $groupName);

		//pr ($this->page['Location']);exit;
		foreach ($this->page['Location'] as $location) {
			//echo $locationName.' -> '.$location->name."<br/>";
			if ($locationName !== $location['name']) {
				continue;
			} else {

				if ($this->debug) pr('Location: ' . $location['name']);

				//pr ($location);exit;
				//the location matches

				if (!$elementName) {
					//no element so let's return true
					return true;
				} else {


					//we are looking for an element
					foreach ($location['Element'] as $element) {

						if (!$this->isCurrentLanguage($element['language'])) continue;

						if ($elementName !== $element['name']) {

							if ($this->debug) pr('element do not match: ' . $elementName . ' ' . $element['name']);

							//echo 'does not '.$elementName;
							//exit;
							continue;
						} else {

							if ($this->debug) pr('element MATCH: ' . $elementName . ' ' . $element['name']);


							//pr ($element);exit;

							if (!$groupName) {
								return true;
							} else {

								if ($element['groupBy'] === $groupName) {
									return true;
								}
							}

						}

					}

				}

			}

			return false;

		}


//            $quit = $this->setup($locationName, $elementName, $groupName);
//            if ($quit) {
//                return false;
//            }
//            if (isset($this->element->Revision[0])) {
//                return true;
//            } else {
//                return false;
//            }
	}

	public function isEvery($nth, $count)
	{
		//2
		if ($count == $nth) {
			return true;
		}
		return false;
	}

	private function prepareElementsInLocation($locationName)
	{
		foreach ($this->page['Location'] as $location) {
			if ($location['name'] == $locationName) {
				foreach ($location['Element'] as $element) {
					if (empty($element['groupBy'])) {

						//pr ($element);exit;
						$this->singleNames[$element['name']] = $element['name'];
					} else {
						$this->groupNames[$element['groupBy']] = $element['groupBy'];
					}
				}
			}
		}
	}

	public function getSingleNamesByLocation($locationName, $sort = 'ASC', $slug = false)
	{
		if ($slug) {
			$this->loadPageBySlug($slug);
		}

		$this->groupNames = array();
		$this->singleNames = array();

		$this->prepareElementsInLocation($locationName);

		//pr ($this->singleNames);exit;
		if ($sort == 'ASC') {
			natsort($this->singleNames);
		} else {
			krsort($this->singleNames);
		}
		return $this->singleNames;
	}

	public function getGroupNamesByLocation($locationName, $sort = 'ASC', $slug = false)
	{
		if ($slug) {
			$this->loadPageBySlug($slug);
		}

		$this->groupNames = array();
		$this->singleNames = array();

		$this->prepareElementsInLocation($locationName);

		if ($sort == 'ASC') {
			natsort($this->groupNames);
		} else {
			krsort($this->groupNames);
		}
		return $this->groupNames;
	}

	public function isNotEmpty($locationName, $elementName = false, $groupName = false)
	{

		//pr ($this->page);exit;
		$test = $this->getContentBy($locationName, $elementName, $groupName);

		//pr ($test);exit;
		if (!empty($test)) {
			return true;
		} else {
			return false;
		}
	}

	public function doesContain($search, $locationName, $elementName = false, $groupName = false)
	{

		//pr ($this->page);exit;
		$test = $this->getContentBy($locationName, $elementName, $groupName);

		if (!empty($test)) {
			if (strpos($test, $search) !== false) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}

	}

	public function isEmpty($locationName, $elementName = false, $groupName = false)
	{

		//pr ($this->page);exit;

		$test = $this->getContentBy($locationName, $elementName, $groupName);

		if (empty($test)) {
			return true;
		} else {
			return false;
		}

	}

	var $total = 0;

	public function getTotalRecords()
	{
		return $this->total;
	}

	public function existsInPage($slug, $locationName, $elementName = false, $groupName = false)
	{

		//echo 'hi';
		//pr ($locationName);

		//pr ($elementName);

		// pr ($this->page);exit;

		$this->writeToLog('Does location exist: ' . $locationName . ' element: ' . $elementName . ' gr:' . $groupName);

		foreach ($this->pages as $page) {

			if ($slug != $page['slug']) {
				continue;
			}

			//pr ($this->page['Location']);exit;
			foreach ($page['Location'] as $location) {

				//echo $locationName.' -> '.$location->name."<br/>";
				if ($locationName != $location['name']) {

					$this->writeToLog('Location does not match: ' . $locationName . ' / ' . $location['name']);
					continue;
				} else {
					$this->writeToLog('Matches: ' . $locationName . ' / ' . $location['name']);

					//pr ($location);exit;
					//the location matches

					if (!$elementName) {
						//no element so let's return true
						return true;
					} else {

						//we are looking for an element
						foreach ($location['Element'] as $element) {

							//pr ($location->Element);

							if ($elementName != $element['name']) {
								//echo 'does not '.$elementName;
								//exit;
								continue;
							} else {

								//pr ($element);exit;

								if (!$groupName) {
									return true;
								} else {

									if ($element['groupBy'] == $groupName) {
										return true;
									}
								}

							}

						}

					}


				}

				return false;
			}
		}


//            $quit = $this->setup($locationName, $elementName, $groupName);
//            if ($quit) {
//                return false;
//            }
//            if (isset($this->element->Revision[0])) {
//                return true;
//            } else {
//                return false;
//            }
	}

	public function getPagesBySearch($searches, $limitToTag = false)
	{
		if ($this->isPrepared()) {
			$results = array();

			if (is_array($searches)) {
				//already an array
			} else {

				$searches = array(0 => $searches);
			}

			$available = '';
			//get the page
			foreach ($this->pages as $page) {

				$pageTags = array();
				//pr ($page);exit;

				$tags = array();
				foreach ($page['Tag'] as $tag) {
					$tags[$tag['name']] = $tag['name'];
					$pageTags[$tag['name']] = $tag['name'];
				}

				if (!$limitToTag) {
					//not limit
				} else {
					if (!in_array($limitToTag, $pageTags)) {
						continue;//skip this page
					}
				}

				foreach ($page['Location'] as $location) {


					foreach ($location['Element'] as $element) {

						foreach ($element['Revision'] as $revision) {

							foreach ($searches as $search) {
								if (stripos($revision['content_text'], strtolower($search)) !== false) {
									//echo 'true';
									$found = array(
										'slug' => $page['slug'],
										'tags' => implode(',', $tags),
										'location' => $location['name'],
										'element' => $element['name'],
										'language' => $element['language'],
										'text' => strip_tags($revision['content_text'])
									);
									$results[$page['slug']] = $found;
								}
							}


							//pr ($revision);exit;
						}
					}
				}

			}

			//pr ($results);
			if (!empty($results)) {
				return $results;
			} else {
				return false;
			}
		} else {

		}


	}


	public function getPageSlugsByYear($year)
	{


		$results = array();

		$available = '';
		//get the page
		foreach ($this->pages as $page) {

//			pr ($page['date']);
//			pr (
//				date('Y', strtotime($page['date']))
//			);
//			exit;
			if (date('Y', strtotime($page['date'])) == $year) {

			} else {
				continue;
			}

			$results[$page['slug']] = $page['slug'];

//
//			pr ( date('Y', strtotime($page['date'])) );
//			pr ($year);
//			pr ($page);
//			exit;


		}

		//pr ($results);
		if (!empty($results)) {
			return $results;
		} else {
			return false;
		}

	}

	public function getPageSlugsBySearch($searches)
	{

		$results = array();

		if (is_array($searches)) {
			//already an array
		} else {

			$searches = array(0 => $searches);
		}

		$available = '';
		//get the page
		foreach ($this->pages as $page) {


			foreach ($page['Location'] as $location) {


				foreach ($location['Element'] as $element) {

					foreach ($element['Revision'] as $revision) {


						foreach ($searches as $search) {

							if (stripos($revision['content_text'], strtolower($search)) !== false) {
								//echo 'true';
								$found = array(
									'slug' => $page['slug'],
									'location' => $location['name'],
									'element' => $element['name'],
									'language' => $element['language'],
									'text' => strip_tags($revision['content_text'])
								);
								$results[$page['slug']] = $page['slug'];
							}

						}


						//pr ($revision);exit;
					}
				}
			}

		}


		//pr ($results);
		if (!empty($results)) {
			return $results;
		} else {
			return false;
		}

	}

	public function convertString($from, $to, $string)
	{
		foreach ($from as $kFrom => $vFrom) {
			$string = str_replace($vFrom, $to[$kFrom], $string);
		}
		//return "";
		return $string;
	}

	public function getFile($location, $element, $group = false)
	{
		return $this->getFileBy($location, $element, $group);
	}

	public function removeTextFrom($remove, $string)
	{
		return str_replace($remove, '', $string);
	}

	public function getLocationNames($ignore = false)
	{


		$this->count = 0;

		if (!$this->page) {
			$msg = 'Page not loaded';
			$this->writeToLog($msg);
			die ($msg);

		}

		foreach ($this->page['Location'] as $location) {
			if ($ignore == $location['name']) {
				//we want to ignore this location
			} else {
				$this->locationNames[$location['name']] = $location['name'];
			}
		}

		return $this->locationNames;
	}

	public function getUniqueNameForFieldByLocation($locationName, $field)
	{

		$categories = array();

		//pr ($this->page);exit;
		foreach ($this->page['Location'] as $location) {
			if ($location['name'] == $locationName) {
				foreach ($location['Element'] as $element) {

					//pr ($element);exit;

					if ($element['name'] == $field) {
						//this is our field
						//pr ($element);exit;
						$categories[str_replace(' ', '', $element['Revision'][0]['content_text'])] = $element['Revision'][0]['content_text'];
					}

				}
			}
		}

		return $categories;

	}

	public function ensureHttp($url)
	{
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return $url;
	}

	function truncateFile()
	{
		$fp = fopen("updateCase.log", "w");
		fwrite($fp, '');
		fclose($fp);
	}

}
