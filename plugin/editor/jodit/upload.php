<?php
include "_common.php";
header('Content-Type: application/json');
$ym = date('ym', G5_SERVER_TIME);

$data_dir = G5_DATA_PATH.'/editor/'.$ym.'/';
$data_url = G5_DATA_URL.'/editor/'.$ym.'/';

@mkdir($data_dir, G5_DIR_PERMISSION);
@chmod($data_dir, G5_DIR_PERMISSION);
$base = '';
$root = $data_dir;
$relpath = isset($_REQUEST['path']) ?  $_REQUEST['path'] : ''; // Use options.uploader.pathVariableName

$path = $root;

// Do not give the file to load into the category that is lower than the root
if (realpath($root.$relpath) && is_dir(realpath($root.$relpath)) && strpos(realpath($root.$relpath).'/', $root) !== false) {
    $path = realpath($root.$relpath).'/';
}

$errors = [
    'There is no error, the file uploaded with success',
    'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    'The uploaded file was only partially uploaded',
    'No file was uploaded',
    'Missing a temporary folder',
    'Failed to write file to disk.',
    'A PHP extension stopped the file upload.',
];

// Black and white list
$config = [
    'white_extensions' => ['png', 'jpeg', 'gif', 'jpg'],
    'black_extensions' => ['php', 'exe', 'phtml'],
];

// function for creating safe name of file
function makeSafe($file) {
    $file = rtrim($file, '.');
    $regex = ['#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#'];
    return get_microtime().trim(preg_replace($regex, '', $file));
}

$result = (object)[
	'data'=> (object)[
		'baseurl' => $data_url,
		'code' => 0,
		'files' => [],
		'isImages' => [],
		'messages' => [],
	],
	'success'=> true, 'time'=> G5_SERVER_TIME
];

function warning_handler($errno, $errstr) {
    global $result;
    $result->data->code = $errno;
    $result->data->messages[] = $errstr;
    exit(json_encode($result));
}

set_error_handler('warning_handler', E_ALL);

//Here 'images' is options.uploader.filesVariableName
if (isset($_FILES['files'])
    and is_array($_FILES['files'])
    and isset($_FILES['files']['name'])
    and is_array($_FILES['files']['name'])
    and count($_FILES['files']['name'])
) {
    foreach ($_FILES['files']['name'] as $i=>$file) {
        if ($_FILES['files']['error'][$i]) {
            trigger_error(isset($errors[$_FILES['files']['error'][$i]]) ? $errors[$_FILES['files']['error'][$i]] : 'Error', E_USER_WARNING);
            continue;
        }
        $tmp_name = $_FILES['files']['tmp_name'][$i];
        if (move_uploaded_file($tmp_name, $file = $path.makeSafe($_FILES['files']['name'][$i]))) {
						$info = pathinfo($file);
            // check whether the file extension is included in the whitelist
            if (isset($config['white_extensions']) and count($config['white_extensions'])) {
                if (!in_array(strtolower($info['extension']), $config['white_extensions'])) {
                    unlink($file);
                    trigger_error('File type not in white list', E_USER_WARNING);
                    continue;
                }
            }
            //check whether the file extension is included in the black list
            if (isset($config['black_extensions']) and count($config['black_extensions'])) {
                if (in_array(strtolower($info['extension']), $config['black_extensions'])) {
                    unlink($file);
                    trigger_error('File type in black list', E_USER_WARNING);
                    continue;
                }
            }
            $result->data->messages[] = 'File '.$_FILES['files']['name'][$i].' was upload';
            $result->data->images[] = $base.basename($file);
            $result->data->isImages[] = true;
        } else {
						$result->data->code = 5;
						$result->success = false;
						$result->data->isImages[] = false;
            if (!is_writable($path)) {
                trigger_error('Destination directory is not writeble', E_USER_WARNING);
            } else {
                trigger_error('No images have been uploaded', E_USER_WARNING);
            }
        }
    }
};

if (!$result->data->code and !count($result->data->files)) {
    $result->data->code = 5;
    trigger_error('No files have been uploaded', E_USER_WARNING);
}

exit(json_encode($result));
