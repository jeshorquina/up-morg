<?php
namespace Jesh\Helpers;

use \CI_Upload;

class Upload extends \CI_Upload
{
    protected $uploaded_data;

    public function __construct()
    {
        parent::__construct();

        $config['upload_path']   = 'application/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|pdf';

        $this->initialize($config);

        $this->uploaded_data = array();
    }

    public function UploadFile($index)
    {
        if(!$this->CanUpload($index))
        {
            return false;
        }
        else if(!$this->do_upload($index))
        {
            throw new \Exception(
                sprintf(
                    "Cound not open upload stream. See errors: %s",
                    $this->display_errors()
                )
            );
        }
        else
        {
            $this->uploaded_data[$index] = $this->data();
        }
    }

    public function GetUploadDetails($index)
    {
        return $this->uploaded_data[$index];
    }

    private function CanUpload($index)
    {
        if(empty($_FILES))
        {
            return false;
        }

        return (
            file_exists($_FILES[$index]['tmp_name']) && 
            is_uploaded_file($_FILES[$index]['tmp_name'])
        );
    }
}
