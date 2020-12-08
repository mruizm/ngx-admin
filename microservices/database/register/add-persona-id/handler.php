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

function regaddpersonaid($data)
{
    header("Access-Control-Allow-Methods","GET, POST");
    header("Access-Control-Allow-Origin","*");
    $data = json_decode($data['body'], true);
    $record_id = $data['register_id'];
    $record_transaction = $data['register_transaction'];    
    $record_action = $data['register_action'];
    $record_type = $data['register_type'];
    $record_created_by = $data['register_created_by'];
    // $date_time = new DateTime('NOW', new DateTimeZone('US/Eastern'));
    $record_created_timestamp = date("Y-m-d H:i:s");

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
        'prefix'    => ''
    ]);
    $capsule->setAsGlobal();
    try{
        $insert_record = Capsule::table('register_logging')->insert(
            ['id' => $record_id,
             'transaction' => $record_transaction,
             'action' => $record_action,
             'type' =>  $record_type,
             'created_by' => $record_created_by,
             'created_timestamp' => $record_created_timestamp,
             'updated_by' => 'none',
             'updated_timestamp' => 'none'
             ]
        );
        // $test = Capsule::select('select * from register_logging where id = :id', ['id' => $user_id]);
        print "$record_created_timestamp".":DEBUG".":record_insert:".$record_id.":"."$record_transaction".":"."$record_action".":"."$record_type".":"."$record_created_by".":"."$record_created_timestamp".":".$insert_record.":".""."\n";
        if($insert_record){
            $r_json_response = array(
                'status_code' => 200,
                'response' => 'ok:insert_record:register_logging'
            );
        }
        else{
            $r_json_response = array(
                'status_code' => 200,
                'response' => 'nok:insert_record:register_logging'
            );
        }
        return [
            'body' => json_encode($r_json_response, JSON_PRETTY_PRINT)
        ];
    }
    catch(PDOException $e){
        $r_json_response = array(
            'status_code' => 401,
            'response' => $e->getMessage()
        );
        return [
            'body' => json_encode($r_json_response, JSON_PRETTY_PRINT)
        ];
    }
    catch(RequestException $e){
        $r_json_response = array(
            'status_code' => 401,
            'response' => Psr7\str($e->getResponse())
        );
        return [
            'body' => json_encode($r_json_response, JSON_PRETTY_PRINT)
        ];
    }
}
##################################################################################
##################################################################################