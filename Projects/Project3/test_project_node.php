<?php
// to install PHP:
// sudo apt-get update
// sudo apt-get install php7.0

// to run this script:
// php test_project_node.php <username> <name>
// e.g.:
// php test_project_node.php dmgics dean

if ( empty( $argv[1] ) || empty( $argv[2] ) ) {
  echo "Include the company (your RIT username) and an employee name when calling this script.\n";
  echo "php test_project_node.php <username> <name>\n";
  echo "E.g.:\n";
  echo "php test_project_node.php dmgics Dean\n";
  die();
}
$company  = $argv[1];
$emp_name = $argv[2];
$base_url = "http://localhost:8080/CompanyServices/";



// SET UP DATES

const YMD = "Y-m-d";

$now = new DateTime( null, new DateTimeZone( "America/New_York" ) );
$day_of_week = $now->format( "w" );

// timecard date is today
$tc_dt = $now;

// set hire date to a week ago
$hire_dt = clone $now;
$hire_dt->sub( new DateInterval( "P7D" ) );

// if today (and hire day) is a weekend or Monday, subtract three days
// (exclude Monday so we can be sure when subtracting one day later that we don't end up on a weekend)
if ( $day_of_week <= 1 || $day_of_week === 6 ) {
  $hire_dt->sub( new DateInterval( "P3D" ) );
  $tc_dt->sub( new DateInterval( "P3D" ) );
}
$hire_date = $hire_dt->format( YMD );
$tc_date = $tc_dt->format( YMD );

$hire_future_dt = clone $hire_dt;
$hire_future_dt->add( new DateInterval( "P14D" ) );
$hire_future_date = $hire_future_dt->format( YMD );

$hire_weekend_dt = clone $hire_dt;
$hire_weekend_dt->sub( new DateInterval( "P{$day_of_week}D" ) );
$hire_weekend_date = $hire_weekend_dt->format( YMD );

$tc_diff_dt = clone $tc_dt;
$tc_diff_dt->sub( new DateInterval( "P1D" ) );
$tc_diff_date = $tc_diff_dt->format( YMD );

$tc_weekend_dt = clone $tc_dt;
$tc_weekend_dt->sub( new DateInterval( "P{$day_of_week}D" ) );
$tc_weekend_date = $tc_weekend_dt->format( YMD );



// DEPARTMENT

echo "GET departments\n";
echo file_get_contents( $base_url . "departments/?company=$company" ) . "\n\n";

echo "POST department\n";
$content = json_encode( [ "company" => "$company", "dept_name" => "$company", "dept_no" => $company . rand( 10, 100 ), "location" => "Rochester" ]);
$context = stream_context_create( [ "http" => [ "method" => "POST", "header" => "Content-type: application/json\r\n", "content" => $content ] ] );
$results = file_get_contents( $base_url . "department", false, $context ) . "\n\n";
echo $results;
$results = json_decode( $results );
$dept_id = $results->success->dept_id ? $results->success->dept_id : $results->dept_id;

echo "GET department\n";
echo file_get_contents( $base_url . "department/?company=$company&dept_id=$dept_id" ) . "\n\n";

echo "PUT department\n";
$content = http_build_query( [ "company" => "$company", "dept_id" => $dept_id, "location" => "Foo" ] );
$context = stream_context_create( [ "http" => [ "method" => "PUT", "header" => "Content-type: application/x-www-form-urlencoded\r\n", "content" => $content ] ] );
echo file_get_contents( $base_url . "department", false, $context ) . "\n\n";



// EMPLOYEE

echo "GET employees\n";
echo file_get_contents( $base_url . "employees/?company=$company" ) . "\n\n";

echo "POST employee\n";
$content = json_encode( [ "emp_name" => $emp_name, "emp_no" => $company . rand( 10, 100 ), "hire_date" => $hire_date, "job" => "programmer", "salary" => 5000.0, "dept_id" => $dept_id, "mng_id" => 0 ] );
$context = stream_context_create( [ "http" => [ "method" => "POST", "header" => "Content-type: application/json\r\n", "content" => $content ] ] );
$results = file_get_contents( $base_url . "employee", false, $context ) . "\n\n";
echo $results;
$results = json_decode( $results );
$emp_id  = $results->success->emp_id ? $results->success->emp_id : $results->emp_id;

echo "GET employee\n";
echo file_get_contents( $base_url . "employee/?company=$company&emp_id=$emp_id" ) . "\n\n";

echo "PUT employee\n";
$content = http_build_query( [ "emp_id" => $emp_id, "job" => "sleeping" ] );
$context = stream_context_create( [ "http" => [ "method" => "PUT", "header" => "Content-type: application/x-www-form-urlencoded\r\n", "content" => $content ] ] );
echo file_get_contents( $base_url . "employee", false, $context ) . "\n\n";



// TIMECARDS

echo "POST timecard\n";
$content = json_encode( [ "emp_id" => $emp_id, "start_time" => "$tc_date 09:30:00", "end_time" => "$tc_date 17:30:00" ] );
$context = stream_context_create( [ "http" => [ "method" => "POST", "header" => "Content-type: application/json\r\n", "content" => $content ] ] );
$results = file_get_contents( $base_url . "timecard", false, $context ) . "\n\n";
echo $results;
$results = json_decode( $results );
$tc_id   = $results->success->timecard_id ? $results->success->timecard_id : $results->timecard_id;

echo "GET timecards\n";
echo file_get_contents( $base_url . "timecards/?emp_id=$emp_id" ) . "\n\n";

echo "GET timecard\n";
echo file_get_contents( $base_url . "timecard/?timecard_id=$tc_id" ) . "\n\n";

echo "PUT timecard\n";
$content = http_build_query( [ "timecard_id" => $tc_id, "start_time" => "$tc_date 09:00:00" ] );
$context = stream_context_create( [ "http" => [ "method" => "PUT", "header" => "Content-type: application/x-www-form-urlencoded\r\n", "content" => $content ] ] );
echo file_get_contents( $base_url . "timecard", false, $context ) . "\n\n";



// VALIDATION

echo "\n=================\nVALIDATION\n\n";

echo "POST employee - hire date in future\n";
$content = json_encode( [ "emp_name" => $emp_name, "emp_no" => "$company$hire_future_date", "hire_date" => $hire_future_date, "job" => "programmer", "salary" => 5000.0, "dept_id" => $dept_id, "mng_id" => 0 ] );
$context = stream_context_create( [ "http" => [ "method" => "POST", "header" => "Content-type: application/json\r\n", "content" => $content ] ] );
echo file_get_contents( $base_url . "employee", false, $context ) . "\n\n";

echo "POST employee - hire date on weekend\n";
$content = json_encode( [ "emp_name" => $emp_name, "emp_no" => "$company$hire_weekend_date", "hire_date" => $hire_weekend_date, "job" => "programmer", "salary" => 5000.0, "dept_id" => $dept_id, "mng_id" => 0 ] );
$context = stream_context_create( [ "http" => [ "method" => "POST", "header" => "Content-type: application/json\r\n", "content" => $content ] ] );
echo file_get_contents( $base_url . "employee", false, $context ) . "\n\n";

echo "POST timecard - end time before start time\n";
$content = json_encode( [ "emp_id" => $emp_id, "start_time" => "$tc_diff_date 09:30:00", "end_time" => "$tc_diff_date 07:30:00" ] );
$context = stream_context_create( [ "http" => [ "method" => "POST", "header" => "Content-type: application/json\r\n", "content" => $content ] ] );
echo file_get_contents( $base_url . "timecard", false, $context ) . "\n\n";

echo "POST timecard - weekend\n";
$content = json_encode( [ "emp_id" => $emp_id, "start_time" => "$tc_weekend_date 09:30:00", "end_time" => "$tc_weekend_date 17:30:00" ] );
$context = stream_context_create( [ "http" => [ "method" => "POST", "header" => "Content-type: application/json\r\n", "content" => $content ] ] );
echo file_get_contents( $base_url . "timecard", false, $context ) . "\n\n";

echo "POST timecard - start time too early\n";
$content = json_encode( [ "emp_id" => $emp_id, "start_time" => "$tc_diff_date 03:30:00", "end_time" => "$tc_diff_date 17:30:00" ] );
$context = stream_context_create( [ "http" => [ "method" => "POST", "header" => "Content-type: application/json\r\n", "content" => $content ] ] );
echo file_get_contents( $base_url . "timecard", false, $context ) . "\n\n";

echo "POST timecard - same day as another timecard\n";
$content = json_encode( [ "emp_id" => $emp_id, "start_time" => "$tc_date 09:30:00", "end_time" => "$tc_date 17:30:00" ] );
$context = stream_context_create( [ "http" => [ "method" => "POST", "header" => "Content-type: application/json\r\n", "content" => $content ] ] );
echo file_get_contents( $base_url . "timecard", false, $context ) . "\n\n\n";



// CLEAN UP

echo "\n=================\nCLEAN UP\n\n";

echo "DELETE timecard\n";
$context = stream_context_create( [ "http" => [ "method" => "DELETE" ] ] );
echo file_get_contents( $base_url . "timecard?timecard_id=$tc_id", false, $context ) . "\n\n";

echo "GET timecards\n";
echo file_get_contents( $base_url . "timecards/?emp_id=$emp_id" ) . "\n\n";


echo "DELETE employee\n";
$context = stream_context_create( [ "http" => [ "method" => "DELETE" ] ] );
echo file_get_contents( $base_url . "employee?emp_id=$emp_id", false, $context ) . "\n\n";

echo "GET employees\n";
echo file_get_contents( $base_url . "employees/?company=$company" ) . "\n\n";


echo "DELETE department\n";
$context = stream_context_create( [ "http" => [ "method" => "DELETE" ] ] );
echo file_get_contents( $base_url . "department?company=$company&dept_id=$dept_id", false, $context ) . "\n\n";

echo "GET departments\n";
echo file_get_contents( $base_url . "departments/?company=$company" ) . "\n\n";

?>
