<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upload</title>
    </head>
    <body>
        <?php
            if (!isset($_POST['submit'])) {
                echo "<meta http-equiv=\"refresh\" content=\"0;url=http://{$_SERVER['HTTP_HOST']}/index.html\" />";
                
                exit;
            }

            $img = $_FILES['img'];
            $ext = pathinfo($img['name'])['extension'];
            $allowed_extensions = ['jpg', 'jpeg', 'png'];

            if (!in_array($ext, $allowed_extensions)) {
                die("Incorrect extension!");
            }

            if (!file_exists('./assets')) {
                mkdir('./assets', 0777, true);
            }

            $filename = './assets/' . $img['name'];

            if (!move_uploaded_file($img['tmp_name'], $filename)) {
                die('Failed to upload the image!');
            }

            echo("
                <img src=\"http://{$_SERVER['HTTP_HOST']}/{$filename}\" alt=\"{$img['name']}\" />
                <br />
                <br />
                <br />
                <br />
                <form action=\"resized_image.php\" method=\"post\">
                    <input type=\"hidden\" name=\"filename\" value=\"$filename\" />
                    <label for=\"width\">
                        Width: <input type=\"number\" name=\"width\" id=\"width\" />
                    </label>
                    <label for=\"height\">
                        Height: <input type=\"number\" name=\"height\" id=\"height\" />
                    </label>
                    <input type=\"submit\" name=\"submit_resize\" value=\"Resize\" />
                </form>
            "); 
        ?>
    </body>
</html>
