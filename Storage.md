# Storage

## Overview
Dynamic images for your software stored in a database. You can add dynamic images to a website. This allows to keep images stored in a database BUT not connected
to the main database. This will ensure your project stays nimble.
- configure database with (webroot/modules/storage/config.json)
- Use the Vendor to connect (GET, ADD, DELETE)

### Step 1: Add files
First you need to add all source files. Copy /app/webroot/modules/storage and /app/Vendor/storage.php into your project

### Step 2: View: Add the FORM element to your view
This allows to browse your computer and upload a file into your controller

```php
<?= $this->Form->create('Page', array('type' => 'file')); ?>
<?= $this->Form->input('file',array(
	'type' => 'file',
	'class' => 'checkbox-class',
)); ?>
<?= $this->Form->end('Submit'); ?>
```

### Step 3: Controller: Add to the controller
This will process the image when it is uploaded. It will save into the storage::vendor

```php

function staff_edit($id){
	$model = $this->modelUsed;
	if (!empty($this->request->data)) {
        $file = $this->request->data['Page']['file']['tmp_name'];
        $filename = $this->request->data['Page']['file']['name'];

        $page_id = $this->Page->save($this->request->data);
        if ($page_id) {
            $this->Session->setFlash('Saved');
            
            if (!empty($file)) {
            
                App::import("Vendor","Storage");
                $storage = new Storage;
                $key_name = 'image'.'_'.$page_id;
                $encoded = $storage->put($key_name,
                    file_get_contents($file),
                    mime_content_type($file),
                    $filename
                );
            }
        }
	} elseif ($id == 'new') {
		$this->set('add', true);
	} else {
		$this->request->data = $this->$model->read(NULL, $id);
	}

}// end of function edit
```

### Step 4: Vendor: Use the vendor to process the file
The vendor will process the file and save into the storage database. Copy the /App/vendor/storage.php into your project\
It will use the /webroot/modules/storage/config.sql

Match the sql 

### Step 5: Add image display
This function will display the image

```php

	function imageDisplay($key_name) {

		//get the storage
		App::import("Vendor","Storage");
		$storage = new Storage;

		$file = $storage->get($key_name);

		$this->set('file', $file);
		$this->set('keyName', $key_name);
		
		header('Content-type: ' . $file['mime']);
		echo base64_decode($file['data']);
		exit;
		
	}

```
#### To use:
```php

<img src="<?= $this->webroot;?>Pages/imageDisplay/<?= $key_name; ?>"/>

```
