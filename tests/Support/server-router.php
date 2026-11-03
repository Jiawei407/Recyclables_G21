<?php
if(PHP_SAPI!=='cli-server'||!getenv('RECYCLABLES_TEST_SERVER_TOKEN')){http_response_code(404);exit;}
$path=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
if($path==='/__test_health'){
    require dirname(__DIR__,2).'/includes/config.php';
    if(!preg_match('/^recyclables_test_[a-z0-9_]+$/D',$db_name)){http_response_code(403);exit;}
    $db=new mysqli($db_host,$db_user,$db_password,$db_name,$db_port);
    if(($db->query('SELECT purpose FROM _ui_test_harness')->fetch_assoc()['purpose']??'')!=='g21-ui-port-tests'){http_response_code(403);exit;}
    header('Content-Type: application/json');echo json_encode(['database'=>$db_name,'token'=>getenv('RECYCLABLES_TEST_SERVER_TOKEN')]);exit;
}
if(preg_match('~^/(tests|tools|\.git)(/|$)~i',rawurldecode($path))){http_response_code(403);exit;}
return require dirname(__DIR__,2).'/router.php';
