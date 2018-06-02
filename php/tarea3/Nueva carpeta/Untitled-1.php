<?php 
        /*$filearray = fopen("test.txt");
        if($filearray){
            while(list($var, $val) = each($filearray)){
                ++$var;
                $val = trim($val);
                print "Line $var: $val <br/>";
            }
        }*/
--
$huge_file = fopen("test.txt", "r");
        while(!feof($huge_file)){
            print fread($huge_file, 3).'<br>';
        }
        fclose($huge_file);

--
$access_log = fopen("test.txt", "r");
        while(!feof($access_log)){
            $line = fgets($access_log);
            print $line;
        }
        fclose($access_log);
--
 $filename = "test.txt";
        $myarray[] = "This in line one";
        $myarray[] = "This in line two";
        $mystring = implode("\n", $myarray);
        $numbytes = file_put_contents($filename, $mystring);
        print "$numbytes bytes written \n";
--
fwrite
        $filename = "test.txt";
        $mystring = "This in asddsad";
        $handle = fopen($filename, "w");
        $numbytes = fwrite($handle, $mystring);
        print "$numbytes bytes written \n";
--

// 40 caracteres por persona

?>