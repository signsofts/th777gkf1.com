<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ImageController extends Controller
{

    // $path = null, $image = null
    public function showImage()
    {
        $filename = null;
        if (isset($_GET["img"])) {
            $filename = $_GET["img"];
        }

        if (is_null($filename)) {
            return false;
        }


        $filePath = WRITEPATH . 'uploads/' . $filename;

        if (file_exists($filePath)) {
            $mime = mime_content_type($filePath); // ตรวจจับ MIME type
            return $this->response
                ->setHeader('Content-Type', $mime)
                ->setBody(file_get_contents($filePath));
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }




        // var_dump($image);
        // exit;
        // Sanitize the inputs to prevent directory traversal attacks
        // $safePath = realpath(WRITEPATH . 'uploads/' . $image);
        // // $safeImage = basename($image);

        // // Construct the full path to the image
        // $imagePath = WRITEPATH . "uploads/" . $image;

        // // Check if the file exists and is a valid file
        // if (file_exists($imagePath) && is_file($imagePath)) {
        //     // Get the MIME type of the image
        //     $imageType = mime_content_type($imagePath);

        //     // Set the appropriate headers
        //     header("Content-Type: $imageType");
        //     header("Content-Length: " . filesize($imagePath));

        //     // Output the image data
        //     readfile($imagePath);
        //     exit;
        // } else {
        //     // Image not found, show 404 error
        //     return $this->response->setStatusCode(404, 'Image not found');
        // }
    }
}
