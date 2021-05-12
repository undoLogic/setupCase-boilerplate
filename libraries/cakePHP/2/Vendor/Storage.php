<?php
/**
App::import("Vendor","Storage");
$storage = new Storage;
$encoded = $storage->put();
$decoded = $encryption->decode($encoded);
echo $decoded; //this will show hello
 */

class Storage {

    var $cacheLocation = 'images/cache/';
    var $host = '';
    var $domain = 'NOT-SET';
    var $security = "CHANGEME";

    function setup() {
        $this->domain = Configure::read('storage.domain');
        $this->host = Router::url('/', true).'modules'.DS.'storage';
    }

    /***** methods for runtime ******/

    //will download if not available in the cache or offer the cached version instead
    function getFromCache($key_name) {

        $this->setup();

        //pr ($this->domain);exit;
        $files = glob($this->cacheLocation.$key_name.".*");

        if (!empty($files)) {
            $path_parts = pathinfo($files[0]);
            if ($path_parts['extension'] == 'empty') {
                //no image set the placeholder
                return false;
            } else {
                return $files[0];
            }
        } else {
            //let's see if our image exists on the server
            //pr ($files);exit;
            //let's get our image from our storage
            $found = $this->get($key_name);

            if ($found['status'] == 200) {

                //only process valid images
                $valid_images = array('image/png', 'image/jpeg');

                if (in_array($found['mime'], $valid_images)) {
                    //good image

                    $newImage = $this->cacheLocation.$key_name.'.'.str_replace("image/", '', $found['mime']);
                    file_put_contents(
                        $newImage,
                        base64_decode($found['data'])
                    );
                    return $newImage;
                }  else {
                    //not good image
                    file_put_contents(
                        $this->cacheLocation.$key_name.'.empty',
                        ''
                    );
                    return false;
                }

            } else {
                //write an empty file as we do NOT have an image
                file_put_contents(
                    $this->cacheLocation.$key_name.'.empty',
                    ''
                );
                return false;
            }
        }
    }

    function removeSingleImageCache($key_name) {
        $files = glob($this->cacheLocation.$key_name.".*");

        foreach ($files as $file) {
            unlink($file);
        }

    }

    ////// end /////






    function put($key_name, $myData, $mime, $reference = false) {

        $this->setup();

//			pr ($this->host);
//			echo Router::url('/', true);
//			die('put');

        $data = array(
            'security' => $this->security,
            'domain' => $this->domain,
            'data' => base64_encode($myData),
            'mime' => $mime,
            'key_name' => $key_name,
            'md5' => md5($myData),
            'reference' => $reference
        );
        //pr ($data);exit;
        $url = $this->host."/put.php";
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
            )
        );

        //pr ($url);exit;
        $context  = stream_context_create( $options );
        //Testing the response
        $result = file_get_contents( $url, false, $context );
        return json_encode($result, true);
    }

    function objectStorageGetByArray($files) {
        foreach ($files as $key => $file) {
            $files[$key]['objectStorage'] = $this->objectStorageGet($file['object_id']);
        }
        return $files;
    }
//	function objectStorageGets($ids) {
//		$array = array();
//
//		foreach ($ids as $id) {
//			$array[] = $this->objectStorageGet($id);
//		}
//		return $array;
//	}


    function get($key_name) {

        $this->setup();

        $url = $this->host."/get.php";
        $data = array(
            'security' => $this->security,
            'key_name' => $key_name
        );
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
            )
        );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        $response = json_decode( $result,TRUE);

        //pr ($result);exit;

        if (empty($response)) {
            return false;
        } else {
            if (empty($response['data'])) {
                return false;
            } else {
                $image = base64_decode($response['data']);
                $mime = $response['mime'];
                $md5proof = md5($image);
                //echo "<img src='data:".$mime.";base64," . base64_encode($image) . "'/>";
                //pr ($response);
                return $response;
            }
        }
    }

    function delete($key_name) {

        $this->setup();

        $url = $this->host."/delete.php";

        $data = array(
            'security' => $this->security,
            'key_name' => $key_name
        );
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
            )
        );
        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );
        $response = json_decode( $result,TRUE);

        //pr ($response);exit;
        //$image = base64_decode($response['data']);
        //$md5proof = md5($image);
        //echo "<img src='data:image/png;base64," . base64_encode($image) . "'/>";
        //pr ($response);

        if ($response == '1') {
            return true;
        } else {
            return false;
        }
    }


//	function upload($file_id) {
//
//		$debug = '';
//		//get the file
//		//setup the online connection
//		//upload
//		//verify the md5 matches to what was uploaded
//		$found = $this->find('first', array(
//			'conditions' => array(
//				'File.id' => $file_id
//			),
//			'contain' => array()
//		));
//
//		//pr ($found);exit;
//
//		if (empty($found)) {
//			return false;
//		} else {
//
//			$myData = $found['File']['data'];
//			//echo "<img src='data:image/png;base64," . base64_encode($myData) . "'/>"; exit;
//
//			$result = $this->put($myData, $found['File']['mime'], $found['File']['name']);
//
//			$response = json_decode( $result,TRUE);
//			if ($response['status'] == 200 && $response['verify']) {
//				$this->data['File'] = $found['File'];
//				$this->data['File']['objectStorageLocation'] = 'FILES';
//				$this->data['File']['object_id'] = $response['id'];
//				$this->data['File']['data'] = ''; //remove local data
//
//				//ensure the md5 matches
//				if ($this->save($this->data)) {
//					//saved
//					return array(
//						'id' => $response['id'],
//						'verify' => $response['verify']
//					);
//				} else {
//
//					//return false;
//					die ('cannot save');
//				}
//			} else {
//
//				//return false;
//				die('PROBLEM did not get status 200 || or the md5 does not match');
//			}
//		}
//	}




    function beforeRenderFile() {}
    function afterRenderFile() {}
    function afterRender() {}
    function beforeLayout() {}
    function afterLayout() {}



}
