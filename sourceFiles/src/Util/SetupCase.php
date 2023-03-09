<?php

namespace App\Util;
use Cake\ORM\Table;
use Cake\Datasource\FactoryLocator;

class SetupCase {

    //File Storage








    public static function isLanguageAllowed($currentLang, $currentWebsite, $websiteLanguages) {
        foreach ($websiteLanguages as $eachWebsite => $langs) {
            if ($currentWebsite == $eachWebsite) {
                if (in_array($currentLang, $langs)) {
                    //this language is allowed
                } else {
                    return false;
                }
            }
        }
        return true;
    }

    public static function getEnglishLink($oldPath) {
        //$oldPath = $this->request->getUri()->getPath();
        return str_replace('es', 'en', $oldPath);
    }


    //is LIVE
    public static function isLIVE($currentDomain, $liveDomains) {
        if (in_array($currentDomain, $liveDomains)) {
            return true;
        }
        return false;
    }



    //SECURE COMPONENT
    var $ths; //$this

    /*
     * When testing is detected in the path, require a basic password to access
     * add to app_controller in beforeFilter
     * $this->Secure->requirePasswordExcept(array('www.website.com', 'website.com'), $_SERVER, $this->Session [,1234]);
     */
    function requirePasswordExcept($exceptions, $server, $session, $password = false) {

        //pr ($exceptions);
        //exit;
        if ($password) {
            //we are using a custom password
            die ('not implented yet');
        } else {

            $passwords = array(
                date('m').date('m'),
                date('m')
            );

            //pr ($server['HTTP_HOST']);

            if (isset($server['HTTP_HOST'])) {

                if (in_array($server['HTTP_HOST'], $exceptions)) {

                    //this is an exception, so let's not enforce a password
                } else {
                    //let's ensure a password

                    if (isset($_GET['login'])) {
                        if ($_GET['login'] == 'logout') {
                            $session->write('TempAccessGiven', 'FALSE');
                            $this->showForm();
                        }
                    }

                    //this is a testing site
                    $isAllowed = $session->read('TempAccessGiven');

                    if ($isAllowed == 'TRUE') {
                        //they are allowed
                    } else {
                        //we need to see if we are allowed.
                        if (isset($_GET['login'])) {
                            if (in_array($_GET['login'], $passwords)) {
                                //they have the right password
                                $session->write('TempAccessGiven', 'TRUE');
                                return 2;

                            } elseif ($_GET['login'] == 'logout') {
                                die ('Logged OUT');
                            } else {
                                die ('NO ACCESS: CODE not correct');
                            }
                        } else {

                            $this->showForm();

                            die ('NO ACCESS: Code Require to access this site');

                        }

                    }


                }
            } else {
                //no http host
            }
        }

    }

    ////public
    public function forceSSL($ths) {
        $this->ths = $ths;
        if ($this->__isLocal()) {
            return FALSE; //we are local, no ssl
        } elseif (!$this->__isSSL()) {
            $this->__redirectSSL();
        }
    }

    public function forceNoSSL($ths, $path = false) {
        $this->ths = $ths;
        if ($this->__isLocal()) {
            return FALSE; //we are local, no ssl
        } elseif ($this->__isSSL()) {
            $this->__redirectNoSSL($path);
        }
    }

    function __isSSL() {
        if (env('SERVER_PORT') == 443) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function __redirectSSL() {
        $this->ths->redirect('https://' . $this->__url());
    }

    function __redirectNoSSL($path) {
        $this->ths->redirect('http://' . $this->__url($path));
    }

    function __url($path = '') {
        $path = $path ? $path : env('REQUEST_URI');
        return env('SERVER_NAME') . $path;
    }

    function __isLocal() {
        if ($_SERVER[ 'SERVER_NAME' ] == 'localhost') {
            return TRUE;
        }
        return FALSE;
    }

    function assureCorrectSubDomain($ignore, $shouldBe, $ths) {
        if ($this->__isLocal()) {
            return true;//we are local it is ok
        } else {
            if (in_array($_SERVER['HTTP_HOST'], $ignore)) {
                //this domain is ignored
                return true;
            } else {
                if (in_array($_SERVER['HTTP_HOST'], $shouldBe)) {
                    return true;
                } else {
                    //let's redirect
                    $first = reset($shouldBe);
                    $ths->redirect('http://'.$first.'/'.$ths->params->url, 301);
                }
            }
        }
    }

    function showForm() {
        $c = '';
        $c .= '<div style="width: 300px;">';
        $c .= '<form action="" method="GET">';
        $c .= '<input name="login"/>';
        $c .= '</form>';
        $c .= '</div>';
        echo $c;
    }




    static function parseCsv($filename) {
        $csvRows = [];
        $headers = [];
        $handle = fopen($filename, "r");
        for ($i = 0; $row = fgetcsv($handle ); ++$i) {
            // Do something will $row array
            if ($i == 0) {
                //our headers
                $headers = $row;
            } else {
                //add the header into the key


                //only add the second row into our csv data
                $csvRows[ $i ] = array_combine(
                    $headers,
                    array_slice($row, 0, count($headers))
                );

                //dd($csvRows);
            }
        }
        fclose($handle);

        //dd($csvRows);
        //clean data
        foreach ($csvRows as $k => $v) {
            foreach ($v as $kk => $vv) {
                //remove the hidden characters left by the csv parsing system
                $kk_new = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $kk);

                $kk_new = str_replace('"', '', $kk_new);
//                pr ($kk);
//                pr ($kk_new);
//                pr ($csvRows);
//
//                exit;
                //if both are the same ignore
                unset($csvRows[ trim($k) ][ $kk ]);
                $csvRows[ trim($k) ][ $kk_new ] = trim($vv);
            }
        }

        //dd($csvRows);
        return $csvRows;
    }









    static function downloadCsv($rows, $filename, $columnsSort = false) {

        // /download start
        $f = fopen('php://memory', 'w');

        $columnNames = array();
        if (!empty($rows)) {
            //We only need to loop through the first row of our result
            //in order to collate the column names.
            $firstRow = $rows[0];
            //pr($firstRow); exit;
            if ($columnsSort) {
                //we have a custom sort
                foreach ($columnsSort as $eachColumnSort) {

                    //dd($eachColumnSort);
                    $columnNames[] = $eachColumnSort['label'];
                }
            } else {
                //export the rows as they are
                foreach ($firstRow as $colName => $val) {
                    $columnNames[] = $colName;
                }
            }
        }

        fputcsv($f, $columnNames);

        //pr ($rows);exit;
        foreach ($rows as $rowName => $row) {

            //dd($row);
            if ($columnsSort) {
                $sortRow = [];
                foreach ($columnsSort as $eachColumnSort) {
                    if (isset($row[ $eachColumnSort['field'] ])) {
                        $sortRow[$eachColumnSort['field'] ] = $row[ $eachColumnSort['field'] ];
                    } else {
                        $sortRow[$eachColumnSort['field'] ] = 'UNKNOWN';
                    }

                }
                fputcsv($f, $sortRow);
            } else {
                fputcsv($f, $row);
            }
        }

        fseek($f, 0);

        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        fpassthru($f);
        fclose($f);

        exit;
    }





}


