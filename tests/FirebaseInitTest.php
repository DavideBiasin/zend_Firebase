<?php
namespace ZendFirebaseTest;

use ZendFirebase\FirebaseInit;
use ZendFirebase\Config\AuthSetup;
require_once 'src/FirebaseInit.php';
require_once 'src/Config/AuthSetup.php';

/**
 * FirebaseInit test case.
 */
class FirebaseInitTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var FirebaseInit
     */
    private $firebaseInit;
    
    // --- set up your own database here
    protected $baseUri = 'https://zendfirebase.firebaseio.com/';

    protected $token = 'YdLUSTlxVOAEEuLAMpB49lAm98AMMCMMWm6y82r4';

    private $auth;

    private $path;

    private $options = [];

    private $operation;

    private $status;

    private $responce;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->auth = new AuthSetup();
        
        $this->auth->setServertoken($this->token);
        $this->auth->setBaseURI($this->baseUri);
        // TODO Auto-generated FirebaseInitTest::setUp()
        $this->firebaseInit = new FirebaseInit($this->auth);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated FirebaseInitTest::tearDown()
        $this->firebaseInit = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        //
    }

    /**
     * Tests FirebaseInit->__construct()
     */
    public function testConstruct()
    {
        $this->firebaseInit->__construct($this->auth);
        $testAuth = new AuthSetup();
        $testAuth->setServertoken($this->token);
        $testAuth->setBaseURI($this->baseUri);
        
        $this->assertEquals($testAuth, $this->auth);
    }

    /**
     * Tests FirebaseInit->setTimeout()
     * @depends testConstruct
     */
    public function testSetTimeout()
    {
        $timeout = 10;
        
        $this->firebaseInit->setTimeout($timeout);
        
        /* not empty */
        $this->assertNotEmpty($this->firebaseInit->getTimeout());
        
        /* type int */
        $this->assertInternalType('int', $this->firebaseInit->getTimeout());
    }

    /**
     * Test FirebaseInit->makeResponce()
     */
    public function testMakeResponce()
    {
        $this->firebaseInit->get('users');
        $this->firebaseInit->makeResponce();
        
        $this->assertNotEmpty($this->firebaseInit->getFirebaseData());
        
        return [
            'responce' => $this->firebaseInit->getFirebaseData(),
            'status' => $this->firebaseInit->getStatus(),
            'operation' => $this->firebaseInit->getOperation()
        ];
    }

    /**
     * Test FirebaseInit->getStatus()
     * @depends testMakeResponce
     * @dataProvider testMakeResponce
     */
    public function testGetStatus($status)
    {
        $this->assertNotNull($status['status']);
        /* type int */
        $this->assertInternalType('int', $status['status']);
    }

    /**
     * Test FirebaseInit->getOperation()
     * @depends testMakeResponce
     * @dataProvider testMakeResponce
     */
    public function testGetOperation($operation)
    {
        $this->assertNotNull($operation['operation']);
        
        /* type string */
        $this->assertInternalType('string', $operation['operation']);
    }

    /**
     * Test FirebaseInit->getFirebaseData()
     * @depends testMakeResponce
     * @dataProvider testMakeResponce
     */
    public function testGetFirebaseData($firebase)
    {
        $this->assertNotNull($firebase['responce']);
        
        /* type array */
        $this->assertInternalType('array', $firebase['responce']);
    }

    /**
     * Tests FirebaseInit->__destruct()
     * @depends testConstruct
     */
    public function testDestruct()
    {
        $firebase = $this->firebaseInit->__destruct();
        
        $this->assertNull($firebase);
    }
}