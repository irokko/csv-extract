<?php
$file = 'sample_data.csv';

//get the total number of records in the file. 

$num_records = file($file, FILE_SKIP_EMPTY_LINES);
echo "The total number of records on '$file' is ".count($num_records);

//get the total number of unique email addresses in the file.
$stored=[];
if((($handle = fopen($file, 'r')) !== false)) {
    while(($data = fgetcsv($handle,1000, ',')) !== false) {
        //skip current row if it is a duplicate
        if (in_array($data[0], $stored)) { continue;}
        //remember inserted value
        $stored[] = $data[0];
    }
}
echo "\nThe total number of unique email addresses on '$file' is ".count($stored);

//get the total number of valid email addresses in the file
$count_valid_emails=1;
if((($handle = fopen($file, 'r')) !== false)) {
    while(($data = fgetcsv($handle,1000, ',')) !== false) {
        if(filter_var($data[0], FILTER_VALIDATE_EMAIL)){
            $count_valid_emails++;
        }
    }
}
echo "\nThe total number of valid email addresses on '$file' is ".$count_valid_emails;

//A list of record counts by domain, sorted in descending order
$stored=[];
if((($handle = fopen($file, 'r')) !== false)) {
    while(($data = fgetcsv($handle,1000, ',')) !== false) {
        if(filter_var($data[0], FILTER_VALIDATE_EMAIL)){
            if(in_array($data[0], $stored)){
                continue;
            }else{
                $stored[] = $data[0];
                //echo "Email is ".$data[0]."\n";
            }
        }
    }
}

//A list of record counts by domain, sorted in descending order
function sortMyList($myFile) {
        $myArray = array_unique(array_map('strtolower', $myFile));

        usort($myArray, function($a, $b){
            preg_match_all("/(.*)@(.*)\./", $a, $m1);
            preg_match_all("/(.*)@(.*)\./", $b, $m2);

            if(($cmp = strcmp($m1[2][0], $m2[2][0])) == 0) {
                return strcmp($m1[1][0], $m2[1][0]);
            } else {
                return ($cmp < 0 ? -1 : 1);
            }

        });

        return $myTextFile = implode(PHP_EOL, $myArray);
    }
    echo "\nSorting by domain name...\n";
    echo sortMyList($stored)."\n";
?>
