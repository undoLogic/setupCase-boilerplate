<?php
/*
 * SetupCase Backup module
 * Exports db from main database connection (if live will get live credentials)
 * File is written to Files/backup for temprary access so it can then be moved to another long term storage / backup location
 */
App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('Controller', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class BackupShell extends AppShell {

    var $uses = array();
    var $debug = true;
    var $process = 'Backup';
    var $pathOfProcess = 'ps aux | grep "app Backup" | grep -v grep';
    var $port = false;
    var $max_clients = 40;
    var $sizeOfReadSocket = 4000;
    var $restartServerWhenHighLoad = false; //only works on live server
    var $singleTest = false; //for our unit tests
    var $singleTestResponse = 'NOTHING';

    private function startUpComponent() {
        $collection = new ComponentCollection();
        $controller = new Controller();
    }

    public function main() {

        $this->startUpComponent();
        if ($this->isAnotherRunning()) {
            $this->writeToLog('debug','Backup - another process is already RUNNING', TRUE);
            die('ANOTHER PROCESS IS RUNNING');
        } else {
            $this->writeToLog('debug',' Backup started', true);

            App::uses('ConnectionManager', 'Model');
            $dataSource = ConnectionManager::getDataSource('default');
            //pr ($dataSource);exit;
            $username = $dataSource->config['login'];
            $password = $dataSource->config['password'];
            $database = $dataSource->config['database'];

            //Configure::write('debug',2);

            //temporary location before the file is streamed back to updateCase
            $exportLocation = APP.'Files'.DS.'backup'.DS;
            //$exportLocation = '/home/undologic/www/backup/sites/';
            $exportName = date('Y-m-d').'.sql';

            //ensure the directory exists
            if (!file_exists($exportLocation)) {
                mkdir ($exportLocation);
                if (!file_exists($exportLocation)) {
                    die('ERROR: cannot create export directory');
                }
            }

            $command = 'mysqldump -u '.$username.' --password="'.$password.'" --no-tablespaces '.$database.' > '.$exportLocation.$exportName;
            //pr ($command);

            $exec = exec($command, $output);
            //pr ($output);
            echo $exec;
            $response = array('STATUS' => 0, 'MSG' => '', 'DATA' => '', 'command' => $command, 'output' => json_encode($output), 'exec' => json_encode($exec));
            if (file_exists($exportLocation.$exportName)) {
                //successful
                $response['STATUS'] = 200;
                $response['DATA'] = base64_encode(file_get_contents($exportLocation.$exportName));
                $response['MSG'] = 'backup file created successfully';
            } else {
                //error
                $response['STATUS'] = 400;
                $response['MSG'] = 'ERROR cannot create backup file';
            }
            echo json_encode($response);
            exit;
        }
    }

    function isAnotherRunning() {
        exec($this->pathOfProcess, $output);
        if (count($output) > 1) { //it's still running, let's skip
            return true;
        } else { //it's not running (except itself) so we can process
            return false;
        }
    }

    public function killProcess() {
        $path = "ps aux | grep 'app Backup' | grep -v grep | awk '{ print $2 }' | head -1";
        exec($path, $out);
        //pr ($out);
        if (isset($out[0])) {
            exec('kill '.$out[0], $res);
            $this->out($res);
            return true;
        }
        return false;
    }

    public function writeToLog($filename, $message, $newLine = false) {
        if ($newLine) {
            $message = "\n".date('Ymd-His').' <===> '.$message;
        } else {
            $message = ' > '.$message;
        }
        file_put_contents(APP.'tmp/logs/'.$filename.'.log', $message, FILE_APPEND);
    }
}
