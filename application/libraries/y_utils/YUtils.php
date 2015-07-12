<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class YUtils {

    public function __construct($params){
        // Do something with $params
    }
	
	public function agecal($dob){
		
		//dob format '1970-02-01'
		$from = new DateTime($dob);
		$to   = new DateTime('today');
		echo $from->diff($to)->y;
		
		return date_diff(date_create(dob), date_create('today'))->y;
	}
	
	
    public function random_key($len, $readable = false, $hash = false) {
        $key = '';

        if ($hash)
            $key = substr(sha1(uniqid(rand(), true)), 0, $len);
        else if ($readable) {
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

            for ($i = 0; $i < $len; ++$i)
                $key .= substr($chars, (mt_rand() % strlen($chars)), 1);
        } else
            for ($i = 0; $i < $len; ++$i)
                $key .= chr(mt_rand(33, 126));

        return strtoupper($key);
    }

    public function sanitize($input) {
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = sanitize($val);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $input = cleanInput($input);
            $output = mysql_real_escape_string($input);
        }
        return $output;
    }

    public function generate_CSV($data, $delimiter = ',', $enclosure = '"') {
        $handle = fopen('php://temp', 'r+');
        foreach ($data as $line) {
            fputcsv($handle, $line, $delimiter, $enclosure);
        }
        rewind($handle);
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        fclose($handle);
        return $contents;
    }

    public function get_real_IPAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function check_date_format($date) {
        //match the format of the date
        if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {
            //check weather the date is valid of not
            if (checkdate($parts[2], $parts[3], $parts[1]))
                return true;
            else
                return false;
        } else
            return false;
    }

    public function get_distance_between_points_new($latitude1, $longitude1, $latitude2, $longitude2) {
        $theta = $longitude1 - $longitude2;
        $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('miles', 'feet', 'yards', 'kilometers', 'meters');
    }

    public function get_client_language($availableLanguages, $default = 'en') {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

            foreach ($langs as $value) {
                $choice = substr($value, 0, 2);
                if (in_array($choice, $availableLanguages)) {
                    return $choice;
                }
            }
        }
        return $default;
    }

    public function ordinal($cdnl) {
        $test_c = abs($cdnl) % 10;
        $ext = ((abs($cdnl) % 100 < 21 && abs($cdnl) % 100 > 4) ? 'th' : (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1) ? 'th' : 'st' : 'nd' : 'rd' : 'th'));
        return $cdnl . $ext;
    }

    public function whois_query($domain) {

        // fix the domain name:
        $domain = strtolower(trim($domain));
        $domain = preg_replace('/^http:\/\//i', '', $domain);
        $domain = preg_replace('/^www\./i', '', $domain);
        $domain = explode('/', $domain);
        $domain = trim($domain[0]);

        // split the TLD from domain name
        $_domain = explode('.', $domain);
        $lst = count($_domain) - 1;
        $ext = $_domain[$lst];

        // You find resources and lists 
        // like these on wikipedia: 
        //
    // <a href="http://de.wikipedia.org/wiki/Whois">http://de.wikipedia.org/wiki/Whois</a>
        //
    $servers = array(
            "biz" => "whois.neulevel.biz",
            "com" => "whois.internic.net",
            "us" => "whois.nic.us",
            "coop" => "whois.nic.coop",
            "info" => "whois.nic.info",
            "name" => "whois.nic.name",
            "net" => "whois.internic.net",
            "gov" => "whois.nic.gov",
            "edu" => "whois.internic.net",
            "mil" => "rs.internic.net",
            "int" => "whois.iana.org",
            "ac" => "whois.nic.ac",
            "ae" => "whois.uaenic.ae",
            "at" => "whois.ripe.net",
            "au" => "whois.aunic.net",
            "be" => "whois.dns.be",
            "bg" => "whois.ripe.net",
            "br" => "whois.registro.br",
            "bz" => "whois.belizenic.bz",
            "ca" => "whois.cira.ca",
            "cc" => "whois.nic.cc",
            "ch" => "whois.nic.ch",
            "cl" => "whois.nic.cl",
            "cn" => "whois.cnnic.net.cn",
            "cz" => "whois.nic.cz",
            "de" => "whois.nic.de",
            "fr" => "whois.nic.fr",
            "hu" => "whois.nic.hu",
            "ie" => "whois.domainregistry.ie",
            "il" => "whois.isoc.org.il",
            "in" => "whois.ncst.ernet.in",
            "ir" => "whois.nic.ir",
            "mc" => "whois.ripe.net",
            "to" => "whois.tonic.to",
            "tv" => "whois.tv",
            "ru" => "whois.ripn.net",
            "org" => "whois.pir.org",
            "aero" => "whois.information.aero",
            "nl" => "whois.domain-registry.nl"
        );

        if (!isset($servers[$ext])) {
            die('Error: No matching nic server found!');
        }

        $nic_server = $servers[$ext];

        $output = '';

        // connect to whois server:
        if ($conn = fsockopen($nic_server, 43)) {
            fputs($conn, $domain . "\r\n");
            while (!feof($conn)) {
                $output .= fgets($conn, 128);
            }
            fclose($conn);
        } else {
            die('Error: Could not connect to ' . $nic_server . '!');
        }

        return $output;
    }

    /**
     * Replace the last occurrence of a string.
     * 
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return string
     */
    public function str_replace_last($search, $replace, $subject) {

        $lenOfSearch = strlen($search);
        $posOfSearch = strrpos($subject, $search);

        return substr_replace($subject, $replace, $posOfSearch, $lenOfSearch);
    }

    /**
     * Remove all characters except letters, numbers, and spaces.
     * 
     * @param string $string
     * @return string
     */
    public function strip_nonAlphaNumeric_spaces($string) {
        return preg_replace("/[^a-z0-9 ]/i", "", $string);
    }

    public function encode_email($email = 'info@domain.com', $linkText = 'Contact Us', $attrs = 'class="emailencoder"') {
        // remplazar aroba y puntos
        $email = str_replace('@', '&#64;', $email);
        $email = str_replace('.', '&#46;', $email);
        $email = str_split($email, 5);

        $linkText = str_replace('@', '&#64;', $linkText);
        $linkText = str_replace('.', '&#46;', $linkText);
        $linkText = str_split($linkText, 5);

        $part1 = '<a href="ma';
        $part2 = 'ilto&#58;';
        $part3 = '" ' . $attrs . ' >';
        $part4 = '</a>';

        $encoded = '<script type="text/javascript">';
        $encoded .= "document.write('$part1');";
        $encoded .= "document.write('$part2');";
        foreach ($email as $e) {
            $encoded .= "document.write('$e');";
        }
        $encoded .= "document.write('$part3');";
        foreach ($linkText as $l) {
            $encoded .= "document.write('$l');";
        }
        $encoded .= "document.write('$part4');";
        $encoded .= '</script>';

        return $encoded;
    }

    public function is_valid_email($email, $test_mx = false) {
        if (eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
            if ($test_mx) {
                list($username, $domain) = split("@", $email);
                return getmxrr($domain, $mxrecords);
            } else
                return true;
        else
            return false;
    }

    /*     * ***
     * @dir - Directory to destroy
     * @virtual[optional]- whether a virtual directory
     */

    public function destroyDir($dir, $virtual = false) {
        $ds = DIRECTORY_SEPARATOR;
        $dir = $virtual ? realpath($dir) : $dir;
        $dir = substr($dir, -1) == $ds ? substr($dir, 0, -1) : $dir;
        if (is_dir($dir) && $handle = opendir($dir)) {
            while ($file = readdir($handle)) {
                if ($file == '.' || $file == '..') {
                    continue;
                } elseif (is_dir($dir . $ds . $file)) {
                    destroyDir($dir . $ds . $file);
                } else {
                    unlink($dir . $ds . $file);
                }
            }
            closedir($handle);
            rmdir($dir);
            return true;
        } else {
            return false;
        }
    }

    public function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }

    /*     * ********************
     * @filename - path to the image
     * @tmpname - temporary path to thumbnail
     * @xmax - max width
     * @ymax - max height
     */

    public function resize_image($filename, $tmpname, $xmax, $ymax) {
        $ext = explode(".", $filename);
        $ext = $ext[count($ext) - 1];

        if ($ext == "jpg" || $ext == "jpeg")
            $im = imagecreatefromjpeg($tmpname);
        elseif ($ext == "png")
            $im = imagecreatefrompng($tmpname);
        elseif ($ext == "gif")
            $im = imagecreatefromgif($tmpname);

        $x = imagesx($im);
        $y = imagesy($im);

        if ($x <= $xmax && $y <= $ymax)
            return $im;

        if ($x >= $y) {
            $newx = $xmax;
            $newy = $newx * $y / $x;
        } else {
            $newy = $ymax;
            $newx = $x / $y * $newy;
        }

        $im2 = imagecreatetruecolor($newx, $newy);
        imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);
        return $im2;
    }

    public function make_clickable_links($text) {
        $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_+.~#?&//=]+)', '<a href="\1">\1</a>', $text);
        $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_+.~#?&//=]+)', '\1<a href="http://\2">\2</a>', $text);
        $text = eregi_replace('([_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3})', '<a href="mailto:\1">\1</a>', $text);

        return $text;
    }

    /* creates a compressed zip file */

    public function create_zip($files = array(), $destination = '', $overwrite = false) {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            return false;
        }
        //vars
        $valid_files = array();
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new ZipArchive();
            if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach ($valid_files as $file) {
                $zip->addFile($file, $file);
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        } else {
            return false;
        }
    }

// Our custom error handler
    public function nettuts_error_handler($number, $message, $file, $line, $vars) {
        $email = "
		<p>An error ($number) occurred on line
		<strong>$line</strong> and in the <strong>file: $file.</strong>
		<p> $message </p>";

        $email .= "<pre>" . print_r($vars, 1) . "</pre>";

        $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Email the error to someone...
        error_log($email, 1, 'you@youremail.com', $headers);

        // Make sure that you decide how to respond to errors (on the user's side)
        // Either echo an error message, or kill the entire project. Up to you...
        // The code below ensures that we only "die" if the error was more than
        // just a NOTICE.
        if (($number !== E_NOTICE) && ($number < 2048)) {
            die("There was an error. Please try again later.");
        }

        // We should use our custom function to handle errors.
//set_error_handler('nettuts_error_handler');
    }

    public function to_CSV(array $data, array $colHeaders = array(), $asString = false) {
        $stream = ($asString) ? fopen("php://temp/maxmemory", "w+") : fopen("php://output", "w");

        if (!empty($colHeaders)) {
            fputcsv($stream, $colHeaders);
        }

        foreach ($data as $record) {
            fputcsv($stream, $record);
        }

        if ($asString) {
            rewind($stream);
            $returnVal = stream_get_contents($stream);
            fclose($stream);
            return $returnVal;
        } else {
            fclose($stream);
        }
    }

    public function age_from_dob($dob) {
        $dob = strtotime($dob);
        $y = date('Y', $dob);
        if (($m = (date('m') - date('m', $dob))) < 0) {
            $y++;
        } elseif ($m == 0 && date('d') - date('d', $dob) < 0) {
            $y++;
        }
        return date('Y') - $y;
    }

    public function rand_password($length) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $chars .= '0123456789';
        $chars .= '!@#%^&*()_,./<>?;:[]{}\|=+';

        $str = '';
        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++)
            $str .= $chars[rand(0, $max)];

        return $str;
    }

    public function date_diff($start, $end) {
        $start = date("G:i:s:m:d:Y", strtotime($start));
        $date1 = explode(":", $start);

        $end = date("G:i:s:m:d:Y", strtotime($end));
        $date2 = explode(":", $end);

        $starttime = mktime(date($date1[0]), date($date1[1]), date($date1[2]), date($date1[3]), date($date1[4]), date($date1[5]));
        $endtime = mktime(date($date2[0]), date($date2[1]), date($date2[2]), date($date2[3]), date($date2[4]), date($date2[5]));

        $seconds_dif = $starttime - $endtime;

        return $seconds_dif;

        //  $today = date("Y-n-j H:i:s");
        //$fromday = "2012-12-31 23:59:59";
        //$timediffer = dt_differ($fromday, $today);
        //echo $timediffer." seconds";
    }

    public function seconds_to_days($mysec) {
        $mysec = (int) $mysec;
        if ($mysec === 0) {
            return '0 second';
        }

        $mins = 0;
        $hours = 0;
        $days = 0;


        if ($mysec >= 60) {
            $mins = (int) ($mysec / 60);
            $mysec = $mysec % 60;
        }
        if ($mins >= 60) {
            $hours = (int) ($mins / 60);
            $mins = $mins % 60;
        }
        if ($hours >= 24) {
            $days = (int) ($hours / 24);
            $hours = $hours % 60;
        }

        $output = '';

        if ($days) {
            $output .= $days . " days ";
        }
        if ($hours) {
            $output .= $hours . " hours ";
        }
        if ($mins) {
            $output .= $mins . " minutes ";
        }
        if ($mysec) {
            $output .= $mysec . " seconds ";
        }
        $output = rtrim($output);
        return $output;
    }

    /**
     * Ensures a value is an integer value. If not, the default value is returned.
     *
     * @param mixed $s Value to convert to integer
     * @param mixed $def The default value. Not converted to integer.
     * @return mixed The integer value, or $def if it can not be converted to an integer
     */
    public function to_integer($s, $def = null) {
        if (is_numeric($s))
            return intval($s);
        return $def;
    }

    /**
     * Ensures a value is an double value. If not, the default value is returned.
     *
     * @param mixed $s Value to convert to double
     * @param mixed $def The default value. Not converted to double.
     * @return mixed The double value, or $def if it can not be converted to an integer
     */
    public function to_double($s, $def = null) {
        if (is_numeric($s))
            return doubleval($s);
        return $def;
    }

    public function ago($time) {
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();

        $difference = $now - $time;
        $tense = "ago";

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] 'ago' ";
    }

    // ------------ lixlpixel recursive PHP functions -------------
// scan_directory_recursively( directory to scan, filter )
// expects path to directory and optional an extension to filter
// of course PHP has to have the permissions to read the directory
// you specify and all files and folders inside this directory
// ------------------------------------------------------------
// to use this function to get all files and directories in an array, write:
// $filestructure = scan_directory_recursively('path/to/directory');
// to use this function to scan a directory and filter the results, write:
// $fileselection = scan_directory_recursively('directory', 'extension');

    public function scan_directory_recursively($directory, $filter = FALSE) {
        // if the path has a slash at the end we remove it here
        if (substr($directory, -1) == '/') {
            $directory = substr($directory, 0, -1);
        }

        // if the path is not valid or is not a directory ...
        if (!file_exists($directory) || !is_dir($directory)) {
            // ... we return false and exit the function
            return FALSE;

            // ... else if the path is readable
        } elseif (is_readable($directory)) {
            // initialize directory tree variable
            $directory_tree = array();

            // we open the directory
            $directory_list = opendir($directory);

            // and scan through the items inside
            while (FALSE !== ($file = readdir($directory_list))) {
                // if the filepointer is not the current directory
                // or the parent directory
                if ($file != '.' && $file != '..') {
                    // we build the new path to scan
                    $path = $directory . '/' . $file;

                    // if the path is readable
                    if (is_readable($path)) {
                        // we split the new path by directories
                        $subdirectories = explode('/', $path);

                        // if the new path is a directory
                        if (is_dir($path)) {
                            // add the directory details to the file list
                            $directory_tree[] = array(
                                'path' => $path,
                                'name' => end($subdirectories),
                                'kind' => 'directory',
                                // we scan the new path by calling this function
                                'content' => scan_directory_recursively($path, $filter));

                            // if the new path is a file
                        } elseif (is_file($path)) {
                            // get the file extension by taking everything after the last dot
                            $extension = end(explode('.', end($subdirectories)));

                            // if there is no filter set or the filter is set and matches
                            if ($filter === FALSE || $filter == $extension) {
                                // add the file details to the file list
                                $directory_tree[] = array(
                                    'path' => $path,
                                    'name' => end($subdirectories),
                                    'extension' => $extension,
                                    'size' => filesize($path),
                                    'kind' => 'file');
                            }
                        }
                    }
                }
            }
            // close the directory
            closedir($directory_list);

            // return file list
            return $directory_tree;

            // if the path is not readable ...
        } else {
            // ... we return false
            return FALSE;
        }
    }

// ------------------------------------------------------------
    // ------------ lixlpixel recursive PHP functions -------------
// recursive_remove_directory( directory to delete, empty )
// expects path to directory and optional TRUE / FALSE to empty
// of course PHP has to have the rights to delete the directory
// you specify and all files and folders inside the directory
// ------------------------------------------------------------
// to use this function to totally remove a directory, write:
// recursive_remove_directory('path/to/directory/to/delete');
// to use this function to empty a directory, write:
// recursive_remove_directory('path/to/full_directory',TRUE);

    public function recursive_remove_directory($directory, $empty = FALSE) {
        // if the path has a slash at the end we remove it here
        if (substr($directory, -1) == '/') {
            $directory = substr($directory, 0, -1);
        }

        // if the path is not valid or is not a directory ...
        if (!file_exists($directory) || !is_dir($directory)) {
            // ... we return false and exit the function
            return FALSE;

            // ... if the path is not readable
        } elseif (!is_readable($directory)) {
            // ... we return false and exit the function
            return FALSE;

            // ... else if the path is readable
        } else {

            // we open the directory
            $handle = opendir($directory);

            // and scan through the items inside
            while (FALSE !== ($item = readdir($handle))) {
                // if the filepointer is not the current directory
                // or the parent directory
                if ($item != '.' && $item != '..') {
                    // we build the new path to delete
                    $path = $directory . '/' . $item;

                    // if the new path is a directory
                    if (is_dir($path)) {
                        // we call this function with the new path
                        recursive_remove_directory($path);

                        // if the new path is a file
                    } else {
                        // we remove the file
                        unlink($path);
                    }
                }
            }
            // close the directory
            closedir($handle);

            // if the option to empty is not set to true
            if ($empty == FALSE) {
                // try to delete the now empty directory
                if (!rmdir($directory)) {
                    // return false if not possible
                    return FALSE;
                }
            }
            // return success
            return TRUE;
        }
    }

// ------------------------------------------------------------
// ------------ lixlpixel recursive PHP functions -------------
// recursive_directory_size( directory, human readable format )
// expects path to directory and optional TRUE / FALSE
// PHP has to have the rights to read the directory you specify
// and all files and folders inside the directory to count size
// if you choose to get human readable format,
// the function returns the filesize in bytes, KB and MB
// ------------------------------------------------------------
// to use this function to get the filesize in bytes, write:
// recursive_directory_size('path/to/directory/to/count');
// to use this function to get the size in a nice format, write:
// recursive_directory_size('path/to/directory/to/count',TRUE);

    public function recursive_directory_size($directory, $format = FALSE) {
        $size = 0;

        // if the path has a slash at the end we remove it here
        if (substr($directory, -1) == '/') {
            $directory = substr($directory, 0, -1);
        }

        // if the path is not valid or is not a directory ...
        if (!file_exists($directory) || !is_dir($directory) || !is_readable($directory)) {
            // ... we return -1 and exit the function
            return -1;
        }
        // we open the directory
        if ($handle = opendir($directory)) {
            // and scan through the items inside
            while (($file = readdir($handle)) !== false) {
                // we build the new path
                $path = $directory . '/' . $file;

                // if the filepointer is not the current directory
                // or the parent directory
                if ($file != '.' && $file != '..') {
                    // if the new path is a file
                    if (is_file($path)) {
                        // we add the filesize to the total size
                        $size += filesize($path);

                        // if the new path is a directory
                    } elseif (is_dir($path)) {
                        // we call this function with the new path
                        $handlesize = recursive_directory_size($path);

                        // if the function returns more than zero
                        if ($handlesize >= 0) {
                            // we add the result to the total size
                            $size += $handlesize;

                            // else we return -1 and exit the function
                        } else {
                            return -1;
                        }
                    }
                }
            }
            // close the directory
            closedir($handle);
        }
        // if the format is set to human readable
        if ($format == TRUE) {
            // if the total size is bigger than 1 MB
            if ($size / 1048576 > 1) {
                return round($size / 1048576, 1) . ' MB';

                // if the total size is bigger than 1 KB
            } elseif ($size / 1024 > 1) {
                return round($size / 1024, 1) . ' KB';

                // else return the filesize in bytes
            } else {
                return round($size, 1) . ' bytes';
            }
        } else {
            // return the total filesize in bytes
            return $size;
        }
    }

// ------------------------------------------------------------

    public function build_calendar($month, $year, $dateArray) {

        // Create array containing abbreviations of days of week.
        $daysOfWeek = array('S', 'M', 'T', 'W', 'T', 'F', 'S');

        // What is the first day of the month in question?
        $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

        // How many days does this month contain?
        $numberDays = date('t', $firstDayOfMonth);

        // Retrieve some information about the first day of the
        // month in question.
        $dateComponents = getdate($firstDayOfMonth);

        // What is the name of the month in question?
        $monthName = $dateComponents['month'];

        // What is the index value (0-6) of the first day of the
        // month in question.
        $dayOfWeek = $dateComponents['wday'];

        // Create the table tag opener and day headers

        $calendar = "<table class='calendar'>";
        $calendar .= "<caption>$monthName $year</caption>";
        $calendar .= "<tr>";

        // Create the calendar headers

        foreach ($daysOfWeek as $day) {
            $calendar .= "<th class='header'>$day</th>";
        }

        // Create the rest of the calendar
        // Initiate the day counter, starting with the 1st.

        $currentDay = 1;

        $calendar .= "</tr><tr>";

        // The variable $dayOfWeek is used to
        // ensure that the calendar
        // display consists of exactly 7 columns.

        if ($dayOfWeek > 0) {
            $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
        }

        $month = str_pad($month, 2, "0", STR_PAD_LEFT);

        while ($currentDay <= $numberDays) {

            // Seventh column (Saturday) reached. Start a new row.

            if ($dayOfWeek == 7) {

                $dayOfWeek = 0;
                $calendar .= "</tr><tr>";
            }

            $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);

            $date = "$year-$month-$currentDayRel";

            $calendar .= "<td class='day' rel='$date'>$currentDay</td>";

            // Increment counters

            $currentDay++;
            $dayOfWeek++;
        }



        // Complete the row of the last week in month, if necessary

        if ($dayOfWeek != 7) {

            $remainingDays = 7 - $dayOfWeek;
            $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
        }

        $calendar .= "</tr>";

        $calendar .= "</table>";

        return $calendar;

        //$dateComponents = getdate();
        //$month = $dateComponents['mon']; 			     
        //$year = $dateComponents['year'];
        //echo build_calendar($month,$year,$dateArray);
    }

    public function isValidEmail($email) {
        //Perform a basic syntax-Check
        //If this check fails, there's no need to continue
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        //extract host
        list($user, $host) = explode("@", $email);
        //check, if host is accessible
        if (!checkdnsrr($host, "MX") && !checkdnsrr($host, "A")) {
            return false;
        }

        return true;
    }

    public function pagination($item_count, $limit, $cur_page, $link) {
        $page_count = ceil($item_count / $limit);
        $current_range = array(($cur_page - 2 < 1 ? 1 : $cur_page - 2), ($cur_page + 2 > $page_count ? $page_count : $cur_page + 2));

        // First and Last pages
        $first_page = $cur_page > 3 ? '<a href="' . sprintf($link, '1') . '">1</a>' . ($cur_page < 5 ? ', ' : ' ... ') : null;
        $last_page = $cur_page < $page_count - 2 ? ($cur_page > $page_count - 4 ? ', ' : ' ... ') . '<a href="' . sprintf($link, $page_count) . '">' . $page_count . '</a>' : null;

        // Previous and next page
        $previous_page = $cur_page > 1 ? '<a href="' . sprintf($link, ($cur_page - 1)) . '">Previous</a> | ' : null;
        $next_page = $cur_page < $page_count ? ' | <a href="' . sprintf($link, ($cur_page + 1)) . '">Next</a>' : null;

        // Display pages that are in range
        for ($x = $current_range[0]; $x <= $current_range[1]; ++$x)
            $pages[] = '<a href="' . sprintf($link, $x) . '">' . ($x == $cur_page ? '<strong>' . $x . '</strong>' : $x) . '</a>';

        if ($page_count > 1)
            return '<p class="pagination"><strong>Pages:</strong> ' . $previous_page . $first_page . implode(', ', $pages) . $last_page . $next_page . '</p>';

        /*
         * pagination(
          total amount of item/rows/whatever,
          limit of items per page,
          current page number,
          url
          );
         */
    }

    // function to escape data and strip tags
    public function safestrip($string) {
        $string = strip_tags($string);
        $string = mysql_real_escape_string($string);
        return $string;
    }

//function to show any messages
    private function messages() {
        $message = '';
        if ($_SESSION['success'] != '') {
            $message = '<span class="success" id="message">' . $_SESSION['success'] . '</span>';
            $_SESSION['success'] = '';
        }
        if ($_SESSION['error'] != '') {
            $message = '<span class="error" id="message">' . $_SESSION['error'] . '</span>';
            $_SESSION['error'] = '';
        }
        return $message;
    }

// log user in function
    function login($username, $password) {

        //call safestrip function
        $user = $this->safestrip($username);
        $pass = $this->safestrip($password);

        //convert password to md5
        $pass = md5($pass);

        // check if the user id and password combination exist in database
        $sql = mysql_query("SELECT * FROM table WHERE username = '$user' AND password = '$pass'")or die(mysql_error());

        //if match is equal to 1 there is a match
        if (mysql_num_rows($sql) == 1) {

            //set session
            $_SESSION['authorized'] = true;

            // reload the page
            $_SESSION['success'] = 'Login Successful';
            header('Location: ./index.php');
            exit;
        } else {
            // login failed save error to a session
            $_SESSION['error'] = 'Sorry, wrong username or password';
        }
    }

    public function html_tidy($input_html, $indent = "true", $no_body_tags = "true", $fix = "true") {
        ob_start();
        $tidy = new tidy;
        $config = array('indent' => $indent, 'output-xhtml' => true, 'wrap' => 200, 'clean' => $fix, 'show-body-only' => $no_body_tags);
        $tidy->parseString($input_html, $config, 'utf8');
        $tidy->cleanRepair();
        $input = $tidy;
        return $input;
    }

    //Performs a regex-texthighlight
    public function textHighlight($text, $search, $highlightColor = '#0000FF', $casesensitive = false) {
        $modifier = ($casesensitive) ? 'i' : '';
        //quote search-string, cause preg_replace wouldn't work correctly if chars like $?. were in search-string
        $quotedSearch = preg_quote($search, '/');
        //generate regex-search-pattern
        $checkPattern = '/' . $quotedSearch . '/' . $modifier;
        //generate regex-replace-pattern
        $strReplacement = '$0';
        return preg_replace($checkPattern, $strReplacement, $text);
    }

    public function array_non_empty_items($input) {
        // If it is an element, then just return it
        if (!is_array($input)) {
            return $input;
        }

        $non_empty_items = array();

        foreach ($input as $key => $value) {
            // Ignore empty cells
            if ($value) {
                // Use recursion to evaluate cells
                $non_empty_items[$key] = array_non_empty_items($value);
            }
        }

        // Finally return the array without empty items
        return $non_empty_items;
    }

    public function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function getSelectBoxTag($p_array, $p_name, $p_sel_value = '') {
        $m_tag = '';
        if (!is_array($p_array) || empty($p_array) || empty($p_name)) {
            return $m_tag;
        }

        $m_tag .= '<select name="' . $p_name . '">';
        foreach ($p_array as $key => $value) {
            $m_tag .= '<option value="' . $key . '"';
            if ($key == $p_sel_value)
                $m_tag .= ' selected';
            $m_tag .= '>' . $value . '</option>';
        }
        $m_tag .= '</select>';

        return $m_tag;
    }


}

?>