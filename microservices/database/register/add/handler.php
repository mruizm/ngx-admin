<?php
require __DIR__.'/vendor/autoload.php';
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Database\Capsule\Manager as Capsule;

function dbregistryadd($data)
{
    header("Access-Control-Allow-Methods","GET, POST");
    header("Access-Control-Allow-Origin","*");
    $data = json_decode($data['body'], true);
    $role_type = $data['role_type'];
    $db_action = $data['db_action'];    
    $created_by = $data['user_id'];
    $in_data_glob = $data['in_data_glob'];
    $date_time = new DateTime('NOW', new DateTimeZone('US/Eastern'));
    // $report_id = $date_time->format('Ymd_His_u');
    $created_timestamp = date("Y-m-d H:i:s");

    $db_host = $_ENV['DB_HOST'];
    $db_name = $_ENV['DB_NAME'];
    $db_user = $_ENV['DB_USER'];
    $db_pwd = $_ENV['DB_PASSWORD'];

    $capsule = new Capsule;
    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => $db_host,
        'database'  => $db_name,
        'username'  => $db_user,
        'password'  => $db_pwd,
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);
    $capsule->setAsGlobal();
    try{
        $users = Capsule::table('register_logging')->where('action', '=', 'add')->first();
        // $test = Capsule::select('select * from register_logging where id = :id', ['id' => $user_id]);
        print "$date".":DEBUG:".$created_timestamp.":create_registry:".$user_id."\n";
        if($users->id == $user_id){
            $r_json_response = array(
                'status_code' => 200,
                'response' => 'User id exists.'
            );
        }
        else{
            $r_json_response = array(
                'status_code' => 200,
                'response' => 'User id does not exists.'
            );
        }
        return [
            'body' => json_encode($r_json_response, JSON_PRETTY_PRINT)
        ];
    }
    catch(ServerException $e){
        $r_json_response = array(
            'status_code' => 401,
            'response' => Psr7\str($e->getResponse())
        );
        return [
            'body' => json_encode($r_json_response, JSON_PRETTY_PRINT)
        ];
    }
    catch(RequestException $e){
        $r_json_response = array(
            'status_code' => '401',
            'response' => Psr7\str($e->getResponse())
        );
        return [
            'body' => json_encode($r_json_response, JSON_PRETTY_PRINT)
        ];
    }
}
##################################################################################
##################################################################################