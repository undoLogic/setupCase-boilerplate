<?php
App::uses('AppModel', 'Model');

/**
 * Province Model
 *
 * @property Storage $Storage
 */
class Storage extends AppModel
{

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	public $useDbConfig = 'storage'; //not working by default
	public $useTable = 'files';

	function get($key_name) {

		$this->setDataSource('storage');

		$conditions = array(
			'AND' => array(
				array('Storage.current' => true),
				array('Storage.key_name' => $key_name),
			)
		);

		$found = $this->find('first', array(
			'conditions'=> $conditions
		));

		if (!empty($found)) {

			$return['status'] = 200;
			$return['status_msg'] = "Found #".$found['Storage']['key_name'];

			$return['data_verify'] =  md5($found['Storage']['data']);
			$return['data'] = base64_encode($found['Storage']['data']);
			$return['mime'] = $found['Storage']['mime'];
			$return['reference'] = $found['Storage']['reference'];

		} else {
			$return['status'] = 404;
			$return['status_msg'] = "Nothing found in the database for the ".$key_name;
		}

		return $return;

	}

	function markOld($key_name) {
		$this->updateAll(array(
			'current' => 0
		),
		array(
			'key_name' => $key_name
		)
		);

	}
	function put($key_name, $data, $mime, $filename, $reference = false) {

		$this->setDataSource('storage');

		$this->markOld($key_name);

		$insertData = $data;
		$data_md5 = md5($data);

		$domain = $_SERVER['HTTP_HOST'];

		$verify_here = md5($insertData);
		$insertJson = "md5: ".$data_md5." calculated here:".md5($insertData);

		//write to the db
		$this->data['Storage']['id'] = NULL;
		$this->data['Storage']['current'] = true;
		$this->data['Storage']['domain'] = $domain;
		$this->data['Storage']['key_name'] = $key_name;
		$this->data['Storage']['mime'] = $mime;
		$this->data['Storage']['data'] = $insertData;
		$this->data['Storage']['verify'] = $verify_here;
		$this->data['Storage']['reference'] = $reference;
		$this->data['Storage']['created'] = NULL;
		$this->data['Storage']['modified'] = NULL;

		//pr ($this->data);exit;

		$this->writeToLog('debug', json_encode($this->data), true);

		$return = array();
		$return['insert_msg'] = $insertJson;

		if ($this->save($this->data)) {
			$return['id'] = $this->getInsertID();
			$return['status'] = 200;
			$return['status_msg'] = 'Saved';

		} else {
			$return['status'] = 500;
			$return['status_msg'] = 'ERROR: '.json_encode($this->validationErrors);
		}

		return $return;

	}

}
