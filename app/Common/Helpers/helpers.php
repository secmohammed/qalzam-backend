<?php
if (!function_exists('compress_image')) {
    /**
     * @param $source
     * @param $destination
     * @param $quality
     */
    function compress_image($source, $destination, $quality)
    {
        $info = getimagesize($source);
        if ($info) {
            if ($info['mime'] === 'image/jpeg' || $info['mime'] === 'image/jpg') {
                $image = imagecreatefromjpeg($source);
            } elseif ($info['mime'] === 'image/gif') {
                $image = imagecreatefromgif($source);

            } elseif ($info['mime'] === 'image/png') {
                $image = imagecreatefrompng($source);

            }

            imagejpeg($image, $destination, $quality);

        }
    }
}
