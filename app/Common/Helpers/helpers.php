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

if(!function_exists('isDashboardPath'))
{
    /**
     * @return bool
     */
    function isDashboardPath():bool
    {
        $path = request()->path();
        $full_path =  explode('/', $path);
        return $full_path[0] == config('qalzam.dashboard-prefix');
    }
}

if(!function_exists('previousRouteName'))
{
    /**
     * @return mixed
     */
    function previousRouteName()
    {
        return app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
    }
}
