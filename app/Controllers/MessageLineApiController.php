<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\MessageLineApiLibraie;
use App\Models\LogsWebhookModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use LINE\Webhook\Model\MessageContent;
use \LINE\Clients\MessagingApi\Model\TextMessage;
use \LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use \GuzzleHttp\Client;
use \LINE\Clients\MessagingApi\Configuration;
use \LINE\Clients\MessagingApi\Api;
use \LINE\Constants\MessageType;
use LINE\Webhook\Test\Model\ContentProviderTest;
use CodeIgniter\API\ResponseTrait;


class MessageLineApiController extends LineApiController
{
    use ResponseTrait;

    public function index()
    {
        //
    }
    public function webhook()
    {

        header('Content-Type: application/json; charset=utf-8');

        // $LogsWebhookModel = new LogsWebhookModel();


        $content = file_get_contents('php://input');
        $events = (object) json_decode($content, TRUE);

        // $this->log('events.json', $events);
        // return $this->respond([], 200);
        if (isset($events->events) && !empty($events->events)) {
            // $LogsWebhookModel->save([
            //     "lwb_destination" => $events->destination,
            //     "lwb_events" => json_encode($events->events),
            // ]);

            $MessageLineApiLibraie = new MessageLineApiLibraie();
            $respond = $MessageLineApiLibraie->MessageRequest($events);

            $respond = array_filter($respond, function ($obj) {
                return $obj === FALSE;
            });


            // if ( count ( $respond ) > 0 ) {
            //     http_response_code ( 400 );
            //     log_message ( 'error', "respond False" );
            //     return $this->respond ( [], 400 );
            // } else {

            // }

            return $this->respond([$respond], 200);

        }

        http_response_code(200);
        return $this->respond([], 200);
    }

    public function webhook_log($fileName = 'events.json')
    {
        header('Content-Type: application/json; charset=utf-8');
        $events = json_decode(file_get_contents(WRITEPATH . $fileName), TRUE);
        return $this->respond($events, 200);

    }

    // public function mlog( $fileName = 'events.json' )
    // {
    //     log_message ( 'error', $fileName );
    // }

    public function logm()
    {
        $file = WRITEPATH . 'logs/log-' . date('Y-m-d') . '.log';
        if (isset($_GET["d"]) && $_GET["d"] == '1') {

            if (file_exists($file)) {
                if (unlink($file)) {
                    echo "Log file deleted successfully";
                } else {
                    error_log("Failed to delete log file: $file");
                    echo "Failed to delete log file";
                }
            } else {
                error_log("Log file not found: $file");
                echo "Log file not found";
            }

        }

        try {
            if (file_exists($file) && is_readable($file)) {
                $content = file_get_contents($file);
                echo "Log file content: <br> " . $content; // Safer output
            } else {
                error_log("Log file not found or unreadable: $file");
                echo "Log file not found or unreadable";
            }
        } catch (Exception $e) {
            error_log("Error reading log file $file: " . $e->getMessage());
            echo "An error occurred while reading the log file";
        }

        return;
    }


}
