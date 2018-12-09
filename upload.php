<?php
    use App\MyDB;
    require_once 'DBInterface.php';
    require_once 'connect.php';
    $db = new MyDB();

    if (isset($_GET['next_dir'])) {
        $dir = $_GET['next_dir'];
        if(!is_dir($dir) and is_file($dir))
            processShare($dir, $db);
        else
            echo "Something is wrong !!!";
    } else {
        echo "FILE FORMAT NOT CORRECT !!!";
    }


function processShare($file, $db) {
    $idx = explode( '.', $file);
    $count_explode = count($idx);
    $idx = strtolower($idx[$count_explode-1]);


    $title = basename($file, '.'.$idx);
    $file_hash = generateRandomString(6);
    $mime_type = get_mime_type($file);
    $orig_name = basename($file);
    $server_pub = file_get_contents('https://api.ipify.org');
    $server_loc = gethostbyname(trim(`hostname`));
    $file_loc = str_replace('\\', '\\\\', $file);
    $status = '1';
    $created_at = time();
    $updated_at = time();


    $query = "INSERT INTO files VALUES ('', '$title', '$file_hash', '$mime_type', '$orig_name', '$server_loc', '$server_pub', '$file_loc', '$status', '$created_at', '$updated_at')";

    $db->query($query);
    echo "Sharing Your File !!!!";


}

function get_mime_type($filename) {
    $idx = explode( '.', $filename );
    $count_explode = count($idx);
    $idx = strtolower($idx[$count_explode-1]);

    $mimet = array( 
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'mp4' => 'video/mp4',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'docx' => 'application/msword',
        'xlsx' => 'application/vnd.ms-excel',
        'pptx' => 'application/vnd.ms-powerpoint',


        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    if (isset( $mimet[$idx] )) {
     return $mimet[$idx];
    } else {
     return 'application/octet-stream';
    }
 }


function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



?>