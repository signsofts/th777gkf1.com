<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class EnvController extends Controller
{
    protected $envPath;

    public function __construct()
    {
        // กำหนดพาธไปยังไฟล์ .env
        $this->envPath = ROOTPATH . '.env';
    }

    // แสดงหน้าและข้อมูลใน .env
    public function index()
    {
        $envVars = $this->readEnv ();
        // กรองตัวแปรที่ขึ้นต้นด้วย database.default.
        $filteredEnvVars = array_filter ( $envVars, function ($key) {
            return strpos ( $key, 'database.default.' ) !== 0;
        }, ARRAY_FILTER_USE_KEY );

        $filteredEnvVars = array_filter ( $filteredEnvVars, function ($key) {
            return strpos ( $key, 'session.' ) !== 0;
        }, ARRAY_FILTER_USE_KEY );


        $filteredEnvVars = array_filter ( $filteredEnvVars, function ($key) {
            return strpos ( $key, 'app.' ) !== 0;
        }, ARRAY_FILTER_USE_KEY );

        $filteredEnvVars = array_filter ( $filteredEnvVars, function ($key) {
            return strpos ( $key, 'app_' ) !== 0;
        }, ARRAY_FILTER_USE_KEY );

        $filteredEnvVars = array_filter ( $filteredEnvVars, function ($key) {
            return strpos ( $key, 'encryption.' ) !== 0;
        }, ARRAY_FILTER_USE_KEY );

        $data[ 'envVars' ] = $filteredEnvVars;
        $data[ 'message' ] = session ()->getFlashdata ( 'message' );
        return view ( 'pages/admin/env_settings', $data );
    }
    public function save()
    {
        $key   = $this->request->getPost ( 'key' );
        $value = $this->request->getPost ( 'value' );

        if ( empty ( $key ) ) {
            return redirect ()->to ( 'admin/setting/env' )->with ( 'message', 'Key ห้ามว่าง' );
        }

        try {
            $envData         = $this->readEnv ();
            $envData[ $key ] = $value;
            $this->writeEnv ( $envData );
            return redirect ()->to ( 'admin/setting/env' )->with ( 'message', "บันทึก $key สำเร็จ" );
        } catch ( \Exception $e ) {
            return redirect ()->to ( 'admin/setting/env' )->with ( 'message', 'เกิดข้อผิดพลาด: ' . $e->getMessage () );
        }
    }

    // ลบตัวแปร
    public function delete( $key )
    {
        $envData = $this->readEnv ();
        if ( isset ( $envData[ $key ] ) ) {
            unset ( $envData[ $key ] );
            $this->writeEnv ( $envData );
            return redirect ()->to ( 'admin/setting/env' )->with ( 'message', "ลบ $key สำเร็จ" );
        }
        return redirect ()->to ( 'admin/setting/env' )->with ( 'message', "ไม่พบ $key" );
    }

    // อ่านข้อมูลจาก .env
    private function readEnv()
    {
        $envData = [];
        if ( file_exists ( $this->envPath ) ) {
            $lines = file ( $this->envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
            foreach ( $lines as $line ) {
                // ข้ามคอมเมนต์
                if ( strpos ( trim ( $line ), '#' ) === 0 ) {
                    continue;
                }
                // แยก key=value
                if ( strpos ( $line, '=' ) !== FALSE ) {
                    list( $key, $value )      = explode ( '=', $line, 2 );
                    $envData[ trim ( $key ) ] = trim ( $value );
                }
            }
        }
        return $envData;
    }

    // เขียนข้อมูลลง .env
    // private function writeEnv($data)
    // {
    //     $content = "# Environment Variables\n";
    //     foreach ($data as $key => $value) {
    //         $content .= "$key=$value\n";
    //     }
    //     file_put_contents($this->envPath, $content);
    // }

    private function writeEnv( $data )
    {
        $lines       = file_exists ( $this->envPath ) ? file ( $this->envPath ) : [];
        $newContent  = [];
        $updatedKeys = [];

        foreach ( $lines as $line ) {
            $trimmedLine = trim ( $line );
            if ( strpos ( $trimmedLine, '#' ) === 0 || empty ( $trimmedLine ) ) {
                $newContent[] = $line;
            } elseif ( strpos ( $line, '=' ) !== FALSE ) {
                list( $key, $value ) = explode ( '=', $line, 2 );
                $key                 = trim ( $key );
                if ( isset ( $data[ $key ] ) ) {
                    // Escape value ถ้ามีช่องว่างหรืออักขระพิเศษ
                    $val                 = ( strpos ( $data[ $key ], ' ' ) !== FALSE || strpos ( $data[ $key ], '#' ) !== FALSE ) ? "\"{$data[ $key ]}\"" : $data[ $key ];
                    $newContent[]        = "$key=$val\n";
                    $updatedKeys[ $key ] = TRUE;
                } else {
                    $newContent[] = $line;
                }
            }
        }

        // เพิ่ม key ใหม่
        foreach ( $data as $key => $value ) {
            if ( !isset ( $updatedKeys[ $key ] ) ) {
                $val          = ( strpos ( $value, ' ' ) !== FALSE || strpos ( $value, '#' ) !== FALSE ) ? "\"{$value}\"" : $value;
                $newContent[] = "$key=$val\n";
            }
        }

        // บันทึกและตรวจสอบผลลัพธ์
        if ( file_put_contents ( $this->envPath, implode ( '', $newContent ) ) === FALSE ) {
            throw new \Exception( 'ไม่สามารถเขียนไฟล์ .env ได้ กรุณาตรวจสอบสิทธิ์' );
        }
    }

}