<?php

namespace App\Controllers\Resources;

use App\Models\BanklistModel;
use App\Models\BankStatementModel;
use App\Models\MembersModel;
use App\Models\MemberStatementModel;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use GuzzleHttp\Client;

class MemberStatementsResource extends ResourceController
{


    protected $helpers = [ 
        'url',
        'array',
        'cookie',
        'date',
        'filesystem',
        'form',
        'html',
        'inflector',
        'number',
        'security',
        'text',
        'xml',
        'session',
        'function'
    ];

    protected $modelName = 'App\Models\MemberStatementModel';
    protected $format = 'json';

    public function index()
    {
    }

    public function show( $id = NULL )
    {
    }

    public function new()
    {
        //
    }

    public function create()
    {

        // $request = new Request();
        // $this->request

        // dd($this->request->getVar('statement_IN'));

        // return ;
        // $impu = (object) $_POST;
        $MemberStatementModel = new MemberStatementModel();

        $BanklistModel = new BanklistModel();
        $MemberModel   = new MembersModel();
        $statement_IN  = $this->request->getVar ( 'statement_IN' );
        $statement_OUT = $this->request->getVar ( 'statement_OUT' );

        $user_id    = $this->request->getVar ( 'user_id' );
        $memberRow = $MemberModel->find ( $user_id );


        if ( empty ( $memberRow ) ) {
            return $this->respond ( [ 'error' => 'empty data', "status" => 401 ], 200 );
        }

        $blit_id  = $this->request->getVar ( 'blit_id' );
        $bListRow = $BanklistModel->find ( $blit_id );
        if ( empty ( $bListRow ) ) {
            return $this->respond ( [ 'error' => 'empty data', "status" => 401 ], 200 );
        }


        $user_remain = $memberRow->user_remain;
        // $_bstate_slip = $this->request->getVar('_statement_slip') ?? false;

        if ( isset ( $_POST[ '_statement_slip' ] ) && !empty ( $_POST[ '_statement_slip' ] ) ) {
            $statement_slip = $_POST[ '_statement_slip' ];
        } else {
            if ( isset ( $_FILES[ 'statement_slip' ] ) && $_FILES[ 'statement_slip' ][ 'error' ] != 4 ) {
                $statement_slip = $this->request->getFile ( 'statement_slip' );
                // if ($_FILES['statement_slip']['error'] != 4) {
                // return $this->respond(['ddd'], 200);

                // $filepath = WRITEPATH . 'uploads/' . $statement_slip->store();
                // $writable = explode("writable", $filepath);
                // $path = explode("/", $writable[1]);

                // $file = $path[2];
                // $path = $path[1];
                // $filepath = $path . "/" . $file;
                // $statement_slip = $filepath;



                // Get the original file name
                $originalName = $statement_slip->getClientName ();

                // Define a custom file name if needed
                $newName = $statement_slip->getRandomName (); // You can change this to $originalName if you want to keep the original
                // Move the file to the writable/uploads directory

                $path = WRITEPATH . 'uploads/' . date ( "Ymd" );
                $statement_slip->move ( $path, $newName );
                // Store the relative path
                // $filepath        = 'uploads/' . $newName;
                $statement_slip = date ( "Ymd" ) . "/" . $newName;

            } else {
                $statement_slip = NULL;
            }
        }
        // return $this->respond(!$_bstate_slip, 200);


        // return $this->respond(['fffff' => '333'], 200);


        if ( $statement_IN == '1' && $statement_OUT == '0' ) {

            $rules = [ 
                'user_id'         => [ 'rules' => 'required' ], //|is_unique[banklists.blit_number]
                'money_incoming' => [ 'rules' => 'required' ],
            ];
            if ( !$this->validate ( $rules ) ) {
                return $this->respond ( [ 'error' => 'required', "status" => 401 ], 200 );
            }
            $user_TotalAmount = $memberRow->user_TotalAmount ?? 0;


            $user_remain += floatval ( $this->request->getVar ( 'money_incoming' ) );
            $user_TotalAmount += floatval ( $this->request->getVar ( 'money_incoming' ) );
            $MemberModel->update ( $this->request->getVar ( 'user_id' ), [ 
                "user_remain"      => $user_remain,
                "user_TotalAmount" => $user_TotalAmount,
            ] );

            $data = [ 
                // "statement_ID" => $this->request->getVar(''),
                "user_id"           => $this->request->getVar ( 'user_id' ),
                "statement_IN"     => $this->request->getVar ( 'statement_IN' ),
                "statement_OUT"    => $this->request->getVar ( 'statement_OUT' ),
                "status_id"        => $this->request->getVar ( 'status_id' ),
                "statement_note"   => $this->request->getVar ( 'statement_note' ),
                "statement_remain" => $user_remain,
                "money_incoming"   => $this->request->getVar ( 'money_incoming' ),
                // "money_out" => $this->request->getVar('money_out'),
                // "ac_code" => session('ac_code'),
                'ac_code'          => $this->request->getVar ( 'ac_code' ) ?? session ( "ac_code" ),
                // "statement_remain" => $this->request->getVar(''),
                "statement_slip"   => $statement_slip,
                "blit_id"          => $this->request->getVar ( 'blit_id' ),
            ];


            $chk = $this->request->getVar ( "chk" ) ?? FALSE;
            if ( !$chk ) {
                $postResp = $this->postApi ( site_url ( 'api/v1/resource/statements' ), [ 
                    "blit_id"        => $this->request->getVar ( 'blit_id' ),
                    "bank_id"        => $bListRow->bank_id,
                    "bstate_IN"      => $this->request->getVar ( 'statement_IN' ),
                    "bstate_out"     => $this->request->getVar ( 'statement_OUT' ),
                    "type"           => 'member',
                    "user_id"         => $this->request->getVar ( 'user_id' ),
                    "money_incoming" => $this->request->getVar ( 'money_incoming' ),
                    "_bstate_slip"   => $statement_slip,
                    "bstate_note"    => $this->request->getVar ( 'statement_note' ),
                    "ac_code"        => $this->request->getVar ( 'ac_code' ) ?? session ( "ac_code" ),
                    "chk"            => TRUE
                ], FALSE, session ( 'token' ) );
            }
            
            $MemberStatementModel->save ( $data );

            return $this->respond ( [ 'success' => 'Insert Data Success', "status" => 200 ], 200 );
        } else if ( $statement_IN == '0' && $statement_OUT == '1' ) {
            $user_TotalWithdrawal = $memberRow->user_TotalWithdrawal ?? 0;

            $rules = [ 
                'user_id'    => [ 'rules' => 'required' ], //|is_unique[banklists.blit_number]
                'money_out' => [ 'rules' => 'required' ],
            ];
            if ( !$this->validate ( $rules ) ) {
                return $this->respond ( [ 'error' => 'required', "status" => 401 ], 200 );
            }

            $user_remain -= floatval ( $this->request->getVar ( 'money_out' ) );


            if ( $user_remain < 0 ) {
                return $this->respond ( [ 'error' => 'money 0', "status" => 401 ], 200 );
            }


            $MemberModel->update ( $this->request->getVar ( 'user_id' ), [ 
                "user_remain"          => $user_remain,
                "user_TotalWithdrawal" => $user_TotalWithdrawal,
            ] );


            $data = [ 
                // "statement_ID" => $this->request->getVar(''),
                "user_id"           => $this->request->getVar ( 'user_id' ),
                "statement_IN"     => $this->request->getVar ( 'statement_IN' ),
                "statement_OUT"    => $this->request->getVar ( 'statement_OUT' ),
                "status_id"        => $this->request->getVar ( 'status_id' ),
                "statement_note"   => $this->request->getVar ( 'statement_note' ),
                "statement_remain" => $user_remain,
                // "money_incoming" => $this->request->getVar('money_incoming'),
                "money_out"        => $this->request->getVar ( 'money_out' ),
                // "ac_code" => session('ac_code'),
                'ac_code'          => $this->request->getVar ( 'ac_code' ) ?? session ( "ac_code" ),
                // "statement_remain" => $this->request->getVar(''),
                "statement_slip"   => $statement_slip,
                "blit_id"          => $this->request->getVar ( 'blit_id' ),
            ];



            $chk = $this->request->getVar ( "chk" ) ?? FALSE;
            if ( !$chk ) {
                $postResp = $this->postApi ( site_url ( 'api/v1/resource/statements' ), [ 
                    "user_id"       => $this->request->getVar ( 'user_id' ),
                    "blit_id"      => $this->request->getVar ( 'blit_id' ),
                    "bank_id"      => $bListRow->bank_id,
                    "bstate_IN"    => $this->request->getVar ( 'statement_IN' ),
                    "bstate_out"   => $this->request->getVar ( 'statement_OUT' ),
                    "type"         => 'member',
                    // "money_incoming" => $this->request->getVar('money_incoming'),
                    "money_out"    => $this->request->getVar ( 'money_out' ),
                    "_bstate_slip" => $statement_slip,
                    "bstate_note"  => $this->request->getVar ( 'statement_note' ),
                    'ac_code'      => $this->request->getVar ( 'ac_code' ) ?? session ( "ac_code" ),
                    "chk"          => TRUE
                ], FALSE, session ( 'token' ) );
            }

            $MemberStatementModel->save ( $data );
            return $this->respond ( [ 'success' => 'Insert Data Success', "status" => 200 ], 200 );
        } else {
            return $this->respond ( [ 'error' => 'error status', "status" => 401 ], 200 );
        }
    }

    public function edit( $id = NULL )
    {
        //
    }

    public function update( $id = NULL )
    {
        //
    }

    public function delete( $id = NULL )
    {
        //
    }

    public function postApi( $url, $data = array(), $returnThis = FALSE, $token )
    {
        // $client = \Config\Services::curlrequest();
        $client   = new Client();
        $response = $client->request ( "POST", $url, [ 
            'timeout'     => 10,
            'headers'     => [ 
                'Authorization' => 'Bearer ' . $token,
                // 'Accept' => 'application/json',
            ],
            'form_params' => $data
        ] );

        $statusCode = $response->getStatusCode ();
        $body       = $response->getBody ();
        if ( $statusCode == ResponseInterface::HTTP_OK && $returnThis ) {
            // Success
            return $response;
        } else if ( $statusCode == ResponseInterface::HTTP_OK && !$returnThis ) {
            return $body;
        } else {
            return $statusCode;
        }
    }
}
