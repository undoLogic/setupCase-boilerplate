<?php
/*
 *
 * //CREATE View/Users/print_download.ctp (see below)
 * You need to create a NEW view which has a PREFIX 'print'
 * -> The print prefix should be secured to not allow access without coming through the download function
 * -> This allows to view sensitive content without requiring a login session
 *
 * //CREATE View/Users/client_download.ctp (see below)
 * $Pdf = new PdfVen;
 * $Pdf->createPdf('registration', $this->groupId(), APP, Router::url('/', true), $idToLookup, 'Registration.pdf', TRUE);
 *
 */

class PdfVen {
    //
    //EXAMPLE - copy and paste into your cakePHP project
    function client_download($id) {

        //do all your lookups here
        $idToLookup = 1;

        //download the file - this REQUIRES to create print_download.ctp above
        $Pdf = new PdfVen;
        $Pdf->createPdf('registration', $this->groupId(), APP, Router::url('/', true), $idToLookup, 'Registration.pdf', TRUE);
    }
    //this is secured in the app-controller with prefix 'print'
    //You should be able to view this manually in your browser to test the placement, etc.
    //Ensure BOTH names match except the prefix
    function print_download($group_id, $id_encrypted) {

        $Pdf = new PdfVen;
        $id = $Pdf->decrypt($id_encrypted);
        $this->request->data = $this->User->getUserById($id);

        if ($this->request->data['User']['group_id'] == $group_id) {
            //it is the correct group - so let's display the content
            //modify the 'views/Users/print_download.ctp file with the layout you wish
            $this->layout = 'print';
        } else {
            //the group does not match so let's not allow
            die('400: Not allowed to view this content');
        }
    }
    //END OF EXAMPLE
    //
    ///////////////////////////////////// CODE /////////////////////////////////////////////////////////////////////


    //This will create a PDF in a temp directory then
    function createPdf($nameAction, $group_id, $app, $webroot, $id, $downloadName, $download = false) {

        $id_encrypted = $this->encrypt($id);

        $file = $app.'files'.DS.$nameAction.'-'.$id.'.pdf';
        $url = $webroot.'print/Users/'.$nameAction.'/'.$group_id.'/'.$id_encrypted.'/';
        //pr ($url); exit;

        // OPTIONS - https://wkhtmltopdf.org/usage/wkhtmltopdf.txt
        $cmd = "wkhtmltopdf ".$url." ".$file;
        exec($cmd, $out);

        if ($download) {
            if (!$downloadName) {
                $downloadName = 'Download.pdf';
            }
            header("Content-Type: application/octet-stream");
            header('Content-Length: ' . filesize($file));
            header("Content-Disposition: attachment; filename=\"".$downloadName."\"");
            readfile($file);
        } else {
            //send status if it was created or not
        }

    }

    var $privateKey = 'oiuyiojknh7868kjhjkgigh';
    function encrypt($decrypted) {
        $exec = "echo '".$decrypted."' | openssl aes-256-cbc -a -salt -pass pass:".$this->privateKey;
        $encrypted = exec($exec, $out);
        return base64_encode($encrypted);
    }

    function decrypt($encrypted) {
        $exec = "echo '".base64_decode($encrypted)."' | openssl aes-256-cbc -a -d -salt -pass pass:".$this->privateKey;
        return exec($exec, $out);
    }

    function testProof($testString) {
        //pr ('TestString: '.$testString);
        $encrypted = $this->encrypt($testString);
        //pr ('E: '.$encrypted);
        $decrypted = $this->decrypt($encrypted);
        //pr ('D: '.$decrypted);exit;
        if ($decrypted == $testString) {
            return 'SUCCESS encryption / decryption is working';
        } else {
            return 'FAIL encryption does NOT match decryption';
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //DEPRECIATED - to be deleted
    function writeToPdf($url, $path) {
        $cmd = "wkhtmltopdf ".$url." ".$path;
        exec($cmd, $out);
    }
    function downloadPdf($file, $downloadName = false) {
        if (!$downloadName) {
            $downloadName = 'Download.pdf';
        }
        header("Content-Type: application/octet-stream");
        header('Content-Length: ' . filesize($file));
        header("Content-Disposition: attachment; filename=\"".$downloadName."\"");
        readfile($file);
        exit;
    }

}
