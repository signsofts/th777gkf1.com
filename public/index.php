<?php


date_default_timezone_set ( "Asia/Bangkok" );

$minPhpVersion = '8.1'; // If you update this, don't forget to update `spark`.
if ( version_compare ( PHP_VERSION, $minPhpVersion, '<' ) ) {
    $message = sprintf (
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    header ( 'HTTP/1.1 503 Service Unavailable.', TRUE, 503 );
    echo $message;

    exit ( 1 );
}



const JWT_SECRET = "b7d928bf4b84fb12010f30d60a0d75270eb1e4ef2bc7dfc1577c8573cecd93921381812d726e0cf43ec367a2bf52c99b2578b140283aec3a6ba309d6a1fdf347858868373d3af30e2d65d298ac135d63d61a64e417e92fa387870fd16fba3b68f3d9a2db5a9203ef15467229bae5b02286b01618203a7062c84ee507fe9a318463581458c7d440c0e89d9608e512cb1708c5d6cc798ce88713ff8c057fc12274761d19de155248f650da432da4ffba5a740c27f700241b43fef80c930378996f526b18d9e3649c1880daccd3feb70bfb0985079ea6db34b1b05d4f44a083cb2e0e1abf1da9e7b34826399198a95c7a4b22cb5835a058516b1a0e2cb90d46377512a987d226e4df47bf59c32e5f58fe23813dd0bcd8a84fc8adf76ab202012699c7ac09989d79d90f695d6e6c4133697414b469a1992dc5b9518fc3357201cad9974faa86d3d7ccbf2aafdf0c2e12de1ab4c8d7a166cb87cc5f43badb03c27785978cd566e2a3713a6f031b17de7029f114d06eefb081ba875f915614337d630d2e38cee77bf666457cb4509e2dd6ba2b2a38a79f576ed7414ce3af4a1101019f076eb4786de48af2ed7d3b49018daaa1295ee1b4392196fda714763f3a1cfa8fcb6b2dd85932ad588531c7f7cbf8a8d335af4d3a1d5825e11a30e15ea75ab603df4d2b3a0b1b9007dfc42e0437ef5eff1cc9dc967a1cbfd0c35d8007e0f1ac75";

// ID SYS DB
const SYS_CODE = 'bmU-85368698';
const SYS_BANK = '1';


// exit;
/*
 *---------------------------------------------------------------
 * SET THE CURRENT DIRECTORY
 *---------------------------------------------------------------
 */

// Path to the front controller (this file)
define ( 'FCPATH', __DIR__ . DIRECTORY_SEPARATOR );

// Ensure the current directory is pointing to the front controller's directory
if ( getcwd () . DIRECTORY_SEPARATOR !== FCPATH ) {
    chdir ( FCPATH );
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// LOAD OUR PATHS CONFIG FILE
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '../app/Config/Paths.php';
// ^^^ Change this line if you move your application folder
$paths = new Config\Paths();
// LOAD THE FRAMEWORK BOOTSTRAP FILE
require $paths->systemDirectory . '/Boot.php';

exit ( CodeIgniter\Boot::bootWeb ( $paths ) );
