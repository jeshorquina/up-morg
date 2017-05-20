<?php
namespace Jesh\Helpers;

use \CI_Upload;

class Upload extends \CI_Upload
{
    const UPLOAD_DIRECTORY_PUBLIC = 'public/images/';
    const UPLOAD_DIRECTORY_INTERNAL = 'application/uploads/';

    const UPLOAD_TYPE_IMAGES_ONLY = 'gif|jpg|png';
    const UPLOAD_TYPE_SUMBISSIONS = 'gif|jpg|png|pdf';

    protected $uploaded_data;

    public function __construct($upload_path, $allowed_type)
    {
        parent::__construct();

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = $allowed_type;

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
                    "Cannot open upload stream. See errors: %s",
                    $this->display_errors()
                )
            );
        }
        else
        {
            $this->uploaded_data[$index] = $this->data();
            return true;
        }
    }

    public function GetUploadPath($index)
    {
        return $this->uploaded_data[$index]['full_path'];
    }

    public function GetUploadFileName($index)
    {
        return $this->uploaded_data[$index]['client_name'];
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
