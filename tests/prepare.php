<?php
// Import the teammate's exact setup into a NEW disposable schema, never the running site.
if(PHP_SAPI!=='cli'){http_response_code(404);exit;}
$name=getenv('RECYCLABLES_TEST_DB_NAME')?:'';
if(!preg_match('/^recyclables_test_[a-z0-9_]+$/D',$name)){fwrite(STDERR,"Choose a new recyclables_test_* name.\n");exit(1);}
mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
$db=new mysqli(getenv('RECYCLABLES_TEST_DB_HOST')?:'127.0.0.1',getenv('RECYCLABLES_TEST_DB_USER')?:'root',getenv('RECYCLABLES_TEST_DB_PASSWORD')?:'','',(int)(getenv('RECYCLABLES_TEST_DB_PORT')?:3306));
$db->query('CREATE DATABASE `'.$name.'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
$db->select_db($name);
$sql=file_get_contents(dirname(__DIR__).'/database/setup.sql');
$sql=preg_replace('/^CREATE DATABASE IF NOT EXISTS recyclables[^;]*;\s*/m','',$sql,1,$removed);
if($removed!==1)throw new RuntimeException('Review setup header before importing.');
$sql=preg_replace('/^USE recyclables;\s*/m','USE `'.$name.'`;'.PHP_EOL,$sql,-1,$uses);
if(!$uses||preg_match('/^USE (?!`'.preg_quote($name,'/').'`)/m',$sql))throw new RuntimeException('Unexpected setup namespace.');
$db->multi_query($sql);do{if($result=$db->store_result())$result->free();}while($db->more_results()&&$db->next_result());
$db->query('CREATE TABLE _ui_test_harness (purpose VARCHAR(50) NOT NULL)');
$db->query("INSERT INTO _ui_test_harness VALUES('g21-ui-port-tests')");
$db->query("INSERT INTO audit_logs(actor_id,action,details) VALUES(1,'UI test fixture','Disposable integration database only')");
$db->query("INSERT INTO challenges(title,category,description,tracked_item,points,start_date,end_date,submission_limit,completion_requirement,status,created_by) VALUES('UI port workflow fixture','Recycling','Only for disposable browser tests','Plastic bottles',5,CURDATE(),DATE_ADD(CURDATE(),INTERVAL 1 MONTH),10,'A clear photo','open',2)");
$workflowChallenge=$db->insert_id;
$db->query('INSERT INTO user_challenges(user_id,challenge_id) VALUES(7,'.(int)$workflowChallenge.')');
require dirname(__DIR__).'/includes/routes.php';
$catalog=[];
$selected='/^(challenges-view-challenge|submit-evidence-submission-details|achievements-recycling-helper|participation-campus-cleanup|promote-challenges-feature-challenge|faculty-activities-faculty-cleanup|submit-report-activity-report|announcements-edit|campaigns-edit|campaigns-performance|challenges-edit|challenges-edit-upload-photo|submissions-review-submission|achievements-edit|achievements-edit-upload-badge|audit-log-audit-details|challenge-balancing|challenge-balancing-delete-challenge|challenge-balancing-upload-challenge-photo|leaderboard-review-user-points|reports-faculty-report|users-delete-user|users-edit-user|users-suspend-user)$/';
foreach(screen_routes() as $logical=>$route){$id=0;$stem=basename($logical,'.php');if(preg_match($selected,$stem))$id=1;if($logical==='faculty/announcements-edit.php')$id=3;if(str_starts_with($logical,'admin/users-')&&$id)$id=7;if($stem==='submissions-review-submission')$id=75;$catalog[]=['logical'=>$logical,'route'=>$route.($id?'&id='.$id:''),'role'=>explode('/',$logical)[0]];}
if(!is_dir(__DIR__.'/.runtime'))mkdir(__DIR__.'/.runtime',0700,true);
file_put_contents(__DIR__.'/.runtime/catalog.json',json_encode(['database'=>$name,'challenge'=>$workflowChallenge,'routes'=>$catalog],JSON_PRETTY_PRINT));
echo 'Prepared '.$name.' with '.count($catalog)." logical screens.\n";
