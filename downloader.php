<?php

/*
|===============================================
|   define default CHUNK_SIZE
|===============================================
*/
define("CHUNK_SIZE", 1024*1024);


/*
|===============================================
|   Download main logic here
|===============================================
*/
sendHeaders($filename, $mime_type, $orig_name);
readfile_chunked($filename);


/*
|===============================================
|   Function responsible for read chunked file
|   param1 => file_path_on_this_machine (String)
|===============================================
*/
function readfile_chunked($filename, $retbytes = TRUE) {
    $buffer = "";
    $cnt =0;
    $handle = fopen($filename, "rb");
    if ($handle === false) {
        return false;
    }
    while (!feof($handle)) {
        $buffer = fread($handle, CHUNK_SIZE);
        echo $buffer;
        // Never use this
        // ob_flush();
        flush();
        if ($retbytes) {
            $cnt += strlen($buffer);
        }
    }
    $status = fclose($handle);
    if ($retbytes and $status) {
        return $cnt;
    }
    return $status;
}


/*
|===============================================
|   Function to set download headers
|   param1 => file_path_on_this_machine (String)
|   param2 => MIME type of the file (String)
|   param3 => name_file_you_want_to_dwd_with
|===============================================
*/
function sendHeaders($file, $type, $name=NULL)
{
    if (empty($name))
    {
        $name = basename($file);
    }
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header('Content-Transfer-Encoding: binary');
    header('Content-Disposition: attachment; filename="'.$name.'";');
    header('Content-Type: ' . $type);
    header('Content-Length: ' . filesize($file));
}
?>