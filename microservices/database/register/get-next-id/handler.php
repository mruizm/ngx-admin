<?php
//Microservice name: get-next-id
//Purpose: To generate the id for next record based on form type (student, teacher, admin)
//Version: 1.0
//Date: Aug 9, 2020
//By: marco.ruiz.mora@gmail.com
require __DIR__.'/vendor/autoload.php';
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Database\Capsule\Manager as Capsule;
use Ramsey\Uuid\Uuid;

function dbregistergetnextid($data)
{
    header("Access-Control-Allow-Methods","GET, POST");
    header("Access-Control-Allow-Origin","*");
    $data = json_decode($data['body'], true);
    $reg_action = $data['register_action'];
    $reg_type = $data['register_type'];    

    $db_host = $_ENV['DB_HOST'];
    $db_name = $_ENV['DB_NAME'];
    $db_user = $_ENV['DB_USER'];
    $db_pwd = $_ENV['DB_PASSWORD'];
    $created_timestamp = date("Y-m-d H:i:s");
    $uuid = Uuid::uuid1();

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
        $last_id = Capsule::table('register_logging')
            ->where([
                ['action', '=', $reg_action],
                ['type', '=', $reg_type],
            ])
            ->orderByDesc('id')
            ->limit(1)
            ->first();
        // $test = Capsule::select('select * from register_logging where id = :id', ['id' => $user_id]);
        print "$created_timestamp".":DEBUG:var_last_id:".$last_id->id."\n";
        
        if(empty($last_id->id)){
            $last_record = 0;
            $next_record = $last_record + 1;
            $next_record = sprintf('%04s', $next_record);
            $data = array(
                'record_type' => $reg_type,
                'record_action' => $reg_action,
                'record_id' => $next_record,
                'transaction_id' => $uuid->toString(),
            );
        }
        else{
            $last_record = $last_id->id;
            $next_record = $last_record + 1;
            $next_record = sprintf('%04s', $next_record); 
            $data = array(
                'record_type' => $reg_type,
                'record_action' => $reg_action,
                'record_id' => $next_record,
                'transaction_id' => $uuid->toString(),
            );
        }
        $r_json_response = array(
            'status_code' => 200,
            'response' => $data
        );
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