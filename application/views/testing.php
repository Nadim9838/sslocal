<?php
echo "Total records: ".count($result);
for ($i = 0; $i < count($result); $i++) {
        echo 'userid'.$result[$i]['platform'],
        'application_id' => $applicationId,
        'session_year' => $fd['session_year'][$i],
        'fd_amount' => $fd['fd_amount'][$i],
        'fd_number' => $fd['fd_number'][$i],
        'fd_ac_no' => $fd['fd_ac_no'][$i],
        'maturity_date' => $fd['maturity_date'][$i];
}
echo "<pre>";
// echo "Mobile id is: ".$mobileId."<br>";
print_r($result);
echo "</pre>";
?>