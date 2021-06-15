<?php
    /**
	App::import("Vendor","Mailchimp");
	$storage = new Storage;
	$encoded = $storage->mailChimpAddUser();
	 *
	 *
	 * merge fields
	 * https://mailchimp.com/help/all-the-merge-tags-cheat-sheet/
	 * change them in settings > audience fields and merge fields
	 * available with merge1 / merge2 OR better is FNAME
	 *
	 *
	 * https://mailchimp.com/developer/api/marketing/list-members/
	 *
	 * api
	 * Account > Extras > api keys
	 *
     */

    class Mailchimp {

		var $mc_auth_token = '';
		var $mc_server_host = '';
		var $mc_list = false;

		function mailChimpInit()
		{
			$this->mc_auth_token = Configure::read('mailchimp.auth_token');
			$this->mc_server_host = Configure::read('mailchimp.server_host');

			if (empty($this->mc_auth_token)) {
				die('mail chimp not initialized');
			} else if (empty($this->mc_server_host)) {
				die('mail chimp not initialized');
			}

			return $this->mc_list = $this->mailChimpGetMainList();
		}



		function mailChimpAddUser($status = 'subscribed', $email, $merge_fields, $tags = array(), $language = 'en')
		{
			//spanish is es
			$this->mailChimpInit();

			$mailchimpLangs = array(
				'fre' => 'fr',
				'spa' => 'es',
				'eng' => 'en'
			);

			//pr ($language);
			//pr ($mailchimpLangs);
			//exit;

			$this->writeToLog('debug.log', 'Mailchimp add user: '.$email.' > '.json_encode($merge_fields).' tags: '.json_encode($tags), true);

			if (!$this->mc_list) {
				die('not init');
			}

			// The data to send to the API
			$postData = array(
				"email_address" => $email,
				"status" => $status,
				"merge_fields" => $merge_fields,
				"tags" => $tags,
				"language" => $mailchimpLangs[ $language ]
			);

			$hash = md5(strtolower($email));


			//pr (json_encode($postData));
			//exit;

			// Setup cURL
			$ch = curl_init($this->mc_server_host . '/lists/' . $this->mc_list . '/members/');
			curl_setopt_array($ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_HTTPHEADER => array(
					'Authorization: apikey ' . $this->mc_auth_token,
					'Content-Type: application/json'
				),
				CURLOPT_POSTFIELDS => json_encode($postData)
			));

			// Send the request
			$response = curl_exec($ch);

			//pr ($response);exit;
			//$this->writeToLog('debug.log', $response, true);

			$response = json_decode($response, true);

			if (isset($response['status'])) {
				if ($response['status'] == 400) {
					//already subscribed
					$this->writeToLog('debug.log', 'status 400: Already subscribed - Trying to EDIT', false);

					//edit the normal info
					$res = $this->mailChimpEditUser($status, $email, $merge_fields);

					//edit the tags
					$res = $this->mailChimpUpdateTags($status, $email, $merge_fields, $tags);

					return $res;

				} else if ($response['status'] == 'subscribed') {
					$this->writeToLog('debug.log', 'status subscribed: Added NEW return TRUE', false);
					return true; //added
				}
			} else {
				$this->writeToLog('mailchimp', 'Problem', false);
				//problem
				return -1; //problem
			}
		}

		function mailChimpEditUser($status = 'subscribed', $email, $merge_fields)
		{
			$this->mailChimpInit();

			$this->writeToLog('debug.log', 'Mailchimp EDIT user: '.$email.' > '.json_encode($merge_fields), true);

			if (!$this->mc_list) {
				die('not init');
			}

			// The data to send to the API
			$postData = array(
				"email_address" => $email,
				"status" => $status,
				"merge_fields" => $merge_fields,
			);

			$hash = md5(strtolower($email));

			//pr (json_encode($postData));
			//exit;

			// Setup cURL
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => $this->mc_server_host . '/lists/' . $this->mc_list . '/members/'.$hash.'/',
				CURLOPT_ENCODING => '',
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'PUT',
				CURLOPT_HTTPHEADER => array(
					'Authorization: apikey ' . $this->mc_auth_token,
					'Content-Type: application/json'
				),
				CURLOPT_POSTFIELDS => json_encode($postData)
			));

			// Send the request
			$response = curl_exec($ch);

			//pr ($response);exit;
			//$this->writeToLog('debug.log', $response, true);

			$response = json_decode($response, true);

			$this->writeToLog('debug.log', substr(json_encode($response), 0, 200), false);

			if (isset($response['status'])) {
				if ($response['status'] == 400) {
					//already subscribed
					$this->writeToLog('debug.log', 'EDIT status 400: Already subscribed', false);

				} else if ($response['status'] == 'subscribed') {
					$this->writeToLog('debug.log', 'EDIT status subscribed: Added NEW return TRUE', false);
					return true; //added
				}
			} else {
				$this->writeToLog('mailchimp', 'Problem', false);
				//problem
				return -1; //problem
			}
		}


		function mailChimpUpdateTags($status = 'subscribed', $email, $merge_fields, $tags = array())
		{
			$this->mailChimpInit();

			$this->writeToLog('debug.log', 'Mailchimp UPDATE TAGS user: '.$email.' > '.json_encode($merge_fields).' tags: '.json_encode($tags), true);

			if (!$this->mc_list) {
				die('not init');
			}

			$updateTags = array();
			foreach ($tags as $tag) {
				$updateTags[] = array('name' => $tag, 'status' => 'active');
			}

			// The data to send to the API
			$postData = array(
				"email_address" => $email,
				"status" => $status,
				"merge_fields" => $merge_fields,
				"tags" => $updateTags
			);

			$hash = md5(strtolower($email));


			//pr (json_encode($postData));
			//exit;

			// Setup cURL
			$ch = curl_init($this->mc_server_host . '/lists/' . $this->mc_list . '/members/'.$hash.'/tags');
			curl_setopt_array($ch, array(

				CURLOPT_SSL_VERIFYPEER => FALSE,
				//CURLOPT_CUSTOMREQUEST => 'PUT',
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_HTTPHEADER => array(
					'Authorization: apikey ' . $this->mc_auth_token,
					'Content-Type: application/json'
				),
				CURLOPT_POSTFIELDS => json_encode($postData)
			));

			// Send the request
			$response = curl_exec($ch);

			//pr ($response);exit;
			//$this->writeToLog('debug.log', $response, true);

			$response = json_decode($response, true);

			if (isset($response['status'])) {
				if ($response['status'] == 400) {
					//already subscribed
					$this->writeToLog('debug.log', 'status 400: Already subscribed return FALSE (no change)', false);
					return false; //no change
				} else if ($response['status'] == 'subscribed') {
					$this->writeToLog('debug.log', 'status subscribed: Added NEW return TRUE', false);
					return true; //added
				} else {
					$this->writeToLog('debug.log', '- Else tags updated ?'.$response['status'], false);

				}
			} else {
				$this->writeToLog('mailchimp', 'Problem', false);
				//problem
				return -1; //problem
			}
		}

		function mailChimpGetUser($email)
		{

			$hash = md5(strtolower($email));

			if (!$this->mc_list) {
				$this->writeToLog('debug.log', 'MailChimp NOT init', true);
				die('not init');
			}

			$this->writeToLog('debug.log', 'MailChimp get user: '.$this->mc_server_host . '/lists/' . $this->mc_list . '/members/' . $hash , true);

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->mc_server_host . '/lists/' . $this->mc_list . '/members/' . $hash,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"Authorization: apikey " . $this->mc_auth_token,
					"Cookie: ak_bmsc=FD323F6BB4D8030834CF172C59569FA0B81A2C36C34A000084DA585FF2F70851~plaxHTSH4c7WtD3io/CPJRSqQ5ukCSX2b1i13WNDIMPUarMlVoyUbvHSa70hvdvToqzxbGcOsfbhudyRBOWHRxBwTJ1bdS5qll0Kc5pY9cKsyXgh+RHsxkav2UD4tTwoKiIhRad4mjZ6OB/AeStNpCCjcHC9+DzSQ4UPqWqRnlqABeDq/54AQ2t8INnhA7xmhh9NmcPPbfEs4KYLbWvwRmAQXzRivogCcPRl7ZM23t+KpWU6yQwvTXbzjn8lie6mEi"
				),
			));

			$response = curl_exec($curl);

			pr($response);
			exit;

			$this->writeToLog('mailchimp', $response, true);

			$response = json_decode($response, true);

			//pr ($response);
			//exit;

			if (isset($response['status'])) {
				if ($response['status'] == 400) {
					//already subscribed
					$this->writeToLog('mailchimp', 'status 400: Already subscribed', true);
					return false; //no change
				} else if ($response['status'] == 'subscribed') {
					$this->writeToLog('mailchimp', 'status subscribed: Added NEW', true);

					return true; //added
				}
			} else {
				$this->writeToLog('mailchimp', 'Problem', true);

				//problem
				return -1; //problem
			}
		}

		function mailChimpDeleteUser($email)
		{
			$email = strtolower($email);

			$this->mailChimpInit();

			$this->writeToLog('debug.log', 'MailChimp delete user: '.$email, true);

			$hash = md5(strtolower($email));

			//pr ($this->mc_server_host . "/lists/" . $this->mc_list . "/members/" . $hash);
			//exit;

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->mc_server_host . "/lists/" . $this->mc_list . "/members/" . $hash,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "DELETE",
				CURLOPT_HTTPHEADER => array(
					"Authorization: apikey " . $this->mc_auth_token,
					"Cookie: ak_bmsc=FD323F6BB4D8030834CF172C59569FA0B81A2C36C34A000084DA585FF2F70851~plaxHTSH4c7WtD3io/CPJRSqQ5ukCSX2b1i13WNDIMPUarMlVoyUbvHSa70hvdvToqzxbGcOsfbhudyRBOWHRxBwTJ1bdS5qll0Kc5pY9cKsyXgh+RHsxkav2UD4tTwoKiIhRad4mjZ6OB/AeStNpCCjcHC9+DzSQ4UPqWqRnlqABeDq/54AQ2t8INnhA7xmhh9NmcPPbfEs4KYLbWvwRmAQXzRivogCcPRl7ZM23t+KpWU6yQwvTXbzjn8lie6mEi; bm_sv=4250615B5FBCBC39750C3B79048428A5~XKIjeqqlIA3+kqwqsJ5lqsgPQ1B0eLWFAUfNkYSheQUVg0yd4vlY82j6bcgKpc3f0feCoA+D2l8hdnGarCxRBBH+eSXad4RwGzZIxxBMLcLfRqz69WpUwxcnuVdVgSEtjAk2fpvP0nf9ouZz0XfLzoRzDNO0RNccfO6mAfU+8hk="
				),
			));

			$response = curl_exec($curl);
			$this->writeToLog('debug.log', $response, false);

			curl_close($curl);

			$response = json_decode($response, true);

			if (empty($response)) {
				$this->writeToLog('debug.log', 'Good delete', false);

				return true;
			} else {
				$this->writeToLog('debug.log', 'STATUS:'. $response['status'], false);
			}
		}

		function mailChimpGetMainList()
		{

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->mc_server_host . "/lists",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"Authorization: apikey " . $this->mc_auth_token,
					"Cookie: ak_bmsc=FD323F6BB4D8030834CF172C59569FA0B81A2C36C34A000084DA585FF2F70851~plaxHTSH4c7WtD3io/CPJRSqQ5ukCSX2b1i13WNDIMPUarMlVoyUbvHSa70hvdvToqzxbGcOsfbhudyRBOWHRxBwTJ1bdS5qll0Kc5pY9cKsyXgh+RHsxkav2UD4tTwoKiIhRad4mjZ6OB/AeStNpCCjcHC9+DzSQ4UPqWqRnlqABeDq/54AQ2t8INnhA7xmhh9NmcPPbfEs4KYLbWvwRmAQXzRivogCcPRl7ZM23t+KpWU6yQwvTXbzjn8lie6mEi"
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			//echo $response;
			//pr ($response); exit;
			$data = json_decode($response, true);

			$mainList = false;

			//pr ($data);exit;
			if (!isset($data['lists'][0])) {
				$this->writeToLog('debug.log', 'Cannot find MC list', true);
			} else {
				$mainList = $data['lists'][0]['id'];
				$this->writeToLog('debug.log', 'Found MC list: '.$mainList, false);
			}
			return $mainList;
		}



		public function writeToLog($filename, $message, $newLine = true) {
			if ($newLine) {
				$message = "\n".date('Ymd-His').' > '.$message;
			} else {
				$message = ' > '.$message;
			}
			file_put_contents(APP.'tmp/logs/'.$filename, $message, FILE_APPEND);
		}



		function beforeRenderFile() {}
		function afterRenderFile() {}
		function afterRender() {}
		function beforeLayout() {}
		function afterLayout() {}



    }
