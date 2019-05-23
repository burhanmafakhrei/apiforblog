<?php


namespace Application\Services\logging;


use Carbon\Carbon;

class logging
{
    public static function logging($data)
    {

        $data=implode( " ", $data );
            $filename = "logging.log";
            $fh = fopen($filename, "a") or die("Could not open log file.");
            fwrite($fh, Carbon::now('asia/tehran')." - $data\n") or die("Could not write file!");
            fclose($fh);

}
}