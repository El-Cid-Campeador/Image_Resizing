<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resize</title>
    </head>
    <body>
    <?php 
        if (!isset($_POST['submit_resize']) || !isset($_POST['filename'])) {
            echo "<meta http-equiv=\"refresh\" content=\"0;url=http://{$_SERVER['HTTP_HOST']}/index.html\">";
            
            exit;
        }

        $filename = $_POST['filename'];
        list($srcWidth, $srcHeight) = getimagesize($filename);

        $width = $srcWidth;
        $height = $srcHeight;

        if (isset($_POST['width']) && (int)$_POST['width'] > 0) {
            $width = (int)$_POST['width'];
        }

        if (isset($_POST['height']) && (int)$_POST['height'] > 0) {
            $height = (int)$_POST['height'];
        }

        $dst = imagecreatetruecolor($width, $height);

        if (!file_exists('./output')) {
            mkdir('./output', 0777, true);
        }

        $output = './output/' . pathinfo($filename)['basename'];

        if (exif_imagetype($filename) === IMAGETYPE_JPEG) {
            $src = imagecreatefromjpeg($filename);
            imagecopyresized($dst, $src, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            imagejpeg($dst, $output);
        } else if (exif_imagetype($filename) === IMAGETYPE_PNG) {
            $src = imagecreatefrompng($filename);
            imagecopyresized($dst, $src, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            imagepng($dst, $output);
        }

        imagedestroy($src);
        imagedestroy($dst);

        echo("<img src=\"http://{$_SERVER['HTTP_HOST']}/$output\" alt=\"$filename\" />");
    ?>
    </body>
</html>
