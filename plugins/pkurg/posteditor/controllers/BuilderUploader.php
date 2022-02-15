<?php namespace Pkurg\PostEditor\Controllers;

use Backend\Classes\Controller;
use Config;
use Input;
use Pkurg\PostEditor\Models\Settings;
use Response;
use Storage;

class BuilderUploader extends Controller
{
    public $implement = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function uploadFiles()
    {

        $input = Input::all();

        $file = Input::file('file');

        if (Settings::get('savelocal')) {

            if ($_FILES) {
                $resultArray = array();
                foreach ($_FILES as $file) {
                    $fileName = $file['name'];
                    $tmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileType = $file['type'];
                    if ($file['error'] != UPLOAD_ERR_OK) {
                        error_log($file['error']);
                        echo JSON_encode(null);
                    }
                    $fp = fopen($tmpName, 'r');
                    $content = fread($fp, filesize($tmpName));

                    $q = uniqid();

                    $fileName = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $fileName);

                    $filePath = '/media/PostEditor/' . $q . $fileName;
                    Storage::put($filePath, $content);

                    $Url = url(Config::get('cms.storage.media.path')) . '/PostEditor/' . $q . $fileName;

                    fclose($fp);
                    $result = array(
                        'name' => $file['name'],
                        'type' => 'image',
                        'src' => $Url,
                        'height' => 350,
                        'width' => 250,
                    );
                    // we can also add code to save images in database here.
                    array_push($resultArray, $result);
                }
                $response = array('data' => $resultArray);
                //echo json_encode($response);
                return Response::json($response);
            }

        } else {

            if ($_FILES) {
                $resultArray = array();
                foreach ($_FILES as $file) {
                    $fileName = $file['name'];
                    $tmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileType = $file['type'];
                    if ($file['error'] != UPLOAD_ERR_OK) {
                        error_log($file['error']);
                        echo JSON_encode(null);
                    }
                    $fp = fopen($tmpName, 'r');
                    $content = fread($fp, filesize($tmpName));
                    fclose($fp);
                    $result = array(
                        'name' => $file['name'],
                        'type' => 'image',
                        'src' => "data:" . $fileType . ";base64," . base64_encode($content),
                        'height' => 350,
                        'width' => 250,
                    );
                    // we can also add code to save images in database here.
                    array_push($resultArray, $result);
                }
                $response = array('data' => $resultArray);
                //echo json_encode($response);
                return Response::json($response);
            }

        }

    }

    public function uploadSummerNoteFiles()
    {

        $input = Input::all();

        $file = Input::file('file');

        if ($_FILES) {

            $resultArray = array();
            foreach ($_FILES as $file) {
                $fileName = $file['name'];
                $tmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileType = $file['type'];
                if ($file['error'] != UPLOAD_ERR_OK) {
                    error_log($file['error']);
                    echo JSON_encode(null);
                }
                $fp = fopen($tmpName, 'r');
                $content = fread($fp, filesize($tmpName));

                $q = uniqid();

                $fileName = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $fileName);

                $filePath = '/media/PostEditor/' . $q . $fileName;
                Storage::put($filePath, $content);

                $Url = url(Config::get('cms.storage.media.path')) . '/PostEditor/' . $q . $fileName;

                fclose($fp);
                $result = array(
                    'name' => $file['name'],
                    'type' => 'image',
                    'src' => $Url,
                    'height' => 350,
                    'width' => 250,
                );

                return response($Url, 200);
            }

        }

    }

    public function uploadCKEditorFiles()
    {

        $input = Input::all();

        $file = Input::file('upload');

        $funcNum = Input::get('CKEditorFuncNum');

        if ($_FILES) {

            $resultArray = array();
            foreach ($_FILES as $file) {
                $fileName = $file['name'];
                $tmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileType = $file['type'];
                if ($file['error'] != UPLOAD_ERR_OK) {
                    error_log($file['error']);
                    echo JSON_encode(null);
                }
                $fp = fopen($tmpName, 'r');
                $content = fread($fp, filesize($tmpName));

                $q = uniqid();

                $fileName = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $fileName);

                $filePath = '/media/PostEditor/' . $q . $fileName;
                Storage::put($filePath, $content);

                $url = url(Config::get('cms.storage.media.path')) . '/PostEditor/' . $q . $fileName;

                fclose($fp);

                return response(
                    "<script>
                    window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$url}', '');
                    </script>", 200
                );
            }

        }

    }


    public function uploadTiptap()
    {

        $input = Input::all();

       

        $file = Input::file('file');

        if ($_FILES) {

            $resultArray = array();
            foreach ($_FILES as $file) {
                $fileName = $file['name'];
                $tmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileType = $file['type'];
                if ($file['error'] != UPLOAD_ERR_OK) {
                    error_log($file['error']);
                    echo JSON_encode(null);
                }
                $fp = fopen($tmpName, 'r');
                $content = fread($fp, filesize($tmpName));

                $q = uniqid();

                $fileName = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $fileName);

                $filePath = '/media/PostEditor/' . $q . $fileName;
                Storage::put($filePath, $content);

                $Url = url(Config::get('cms.storage.media.path')) . '/PostEditor/' . $q . $fileName;

                fclose($fp);
                $result = array(
                    'name' => $file['name'],
                    'type' => 'image',
                    'src' => $Url,
                    'height' => 350,
                    'width' => 250,
                );


// This POSTs using axios to /upload and expects a JSON back of this form:

// {"src": "https://yoursite.com/images/uploadedimage.jpg"}

                return Response::json(array('src' => $Url));
                
            }

        }

    }
    

}
