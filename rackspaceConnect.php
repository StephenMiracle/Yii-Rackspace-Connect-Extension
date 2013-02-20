<?php

/*
 * This component allows the connection, viewing and uploading to Rackspace Cloud files
 */

class RackspaceConnect extends CApplicationComponent{
 public $login;
 public $key;

    /**
     * authenticate
     * 
     * Authenticates into  Rackspace cloudfiles
     * 
     * @param string $login the rackspace login
     * @param string $key the rackspace api key
     */
    public function authenticate($login, $key){ 
        require_once __DIR__.'/php-cloudfiles-master/cloudfiles.php';
        $login = $this->login;
        $key = $this->key;
        $auth = new CF_Authentication($login,$key);
        $auth->ssl_use_cabundle(__DIR__.'/cacert.pem');
        $auth->authenticate();
        $conn = new CF_Connection($auth);
       return $conn;
    }
    /**
     * run
     * 
     * Grabs files from Rackspace Cloud Files
     * 
     * @param string $container this is the container you want to grab
     */
    public function run($container){
       $cloudContainer = $this->authenticate($this->login, $this->key)->get_container($container);    
       $cloudFiles = $cloudContainer->get_objects();
       return $cloudFiles;
    }

    /**
     * upload
     * 
     * Upload a file into a rackspace container
     * 
     * @param string $container the container you want to insert
     * @param string $filename the name of file to be uploaded
     */
    public function upload($container, $filename){

                        // upload file to Rackspace
                        $cloudContainer = $this->authenticate($this->login, $this->key)->get_container($container);
                        $object = $cloudContainer->create_object($filename);
                        $object->load_from_filename($filename);
    }

}
?>
