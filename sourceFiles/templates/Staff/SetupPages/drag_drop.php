<style>
    #drop_file_zone {
        background-color: #EEE;
        border: #999 5px dashed;
        width: 100%;
        height: 200px;
        padding: 8px;
        font-size: 18px;
    }

    #drag_upload_file {
        width: 50%;
        margin: 0 auto;
    }

    #drag_upload_file p {
        text-align: center;
    }

    #drag_upload_file #selectfile {
        display: none;
    }

    .badge {
        padding: 10px;
        position: relative;
        width: 100%;
        display: block;
        color: white;
    }
    .badge-success {
        background-color: darkseagreen;
    }
    .badge-danger {
        background-color: indianred;
    }
</style>


<div class="row">
    <div class="col-lg-6">

        <h3>
            Batch Import Images
        </h3>

        <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
            <div id="drag_upload_file">
                <br/>
                <p>Drop MULTIPLE image files here</p>
                <p>or</p>
                <p>
                    <input type="button" value="Select Multiple Files Here" onclick="file_explorer();"/>
                </p>
                <input type="file" id="selectfile" multiple/>
            </div>
        </div>

        <address>
            You can upload the following image types: <?= implode(',', $allowedFileTypes); ?>
        </address>

    </div>


    <div class="col-lg-6">

        <h3>Upload Log</h3>

        <div class="uploaded">

        </div>

    </div>


</div>


<script>
    var fileobj;

    function process() {
        for (let i = 0; i < fileobj.length; i++) {
            console.log(fileobj[i]);
            //add to uploader

            ajax_file_upload(fileobj[i]);


        }
    }

    function upload_file(e) {
        e.preventDefault();
        fileobj = e.dataTransfer.files;
        console.log(fileobj);
        //ajax_file_upload(fileobj);

        process();
    }

    function file_explorer() {
        document.getElementById('selectfile').click();
        document.getElementById('selectfile').onchange = function () {

            fileobj = document.getElementById('selectfile').files;
            console.log(fileobj);

            process();
        };
    }

    function ajax_file_upload(file_obj) {
        if (file_obj != undefined) {
            var form_data = new FormData();
            form_data.append('file', file_obj);
            var xhttp = new XMLHttpRequest();

            let =
            URL = "<?= $webroot; ?>staff/SetupPages/ajaxDragDrop";
            console.log(URL);

            xhttp.open("POST", URL, true);
            xhttp.setRequestHeader('x-csrf-token', '<?= $csrf; ?>');
            xhttp.onload = function (event) {
                //oOutput = document.querySelector('.img-content');

                let RES = JSON.parse(xhttp.response);
                console.log(RES);
                if (RES.STATUS == 200) {

                    $(".uploaded").prepend("<span class=\"badge badge-success\">" + RES.MSG + "</span>");

                    //oOutput.innerHTML = "<img src='"+ this.responseText +"' alt='The Image' />";
                } else {

                    $(".uploaded").prepend("<span class=\"badge badge-danger\">" + RES.MSG + "</span>");

                    //oOutput.innerHTML = "Error " + xhttp.status + " occurred when trying to upload your file.";
                }
            }

            xhttp.send(form_data);
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>

