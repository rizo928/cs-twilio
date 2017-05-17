<?php

$GLOBALS['hConfig'] = new FileBox();

// Comment out the below line to perform Unit testing
defined('BASEPATH') OR exit('No direct script access allowed');

/////////////////////////////////////////////////////////////////////
//
// CLASS: FileBox
//
// A very simple class to persistently store an array of key value
// pairs using a simple JSON file.  This class doesn't care what
// the keys or values actually are.
//
// If the JSON file is manipulated/edited directly, care must be taken
// to ensure that it contains valid JSON as decodable by
// json_decode.
//
// Example usage can be found in the unit test section at the
// end of this file.
//
// PERFORMANCE NOTE:
//
// READs are lightening fast (similar to simply retrieving
// information from an array plus the overhead of a method call).
//
// However, UPDATEs will progressively slow as the total number of
// key value pairs increase. This is due to the fact the entire data
// store is converted to JSON and persisted every time it is
// updated/modified.
//
// MEMORY USAGE:
//
// Each instance/object stores a copy of the entire data store
// as an array in memory, which could be an issue for massive data sets.
//
// CONCURRENCY:
//
// There is no attempt to maintain sycronization between multiple
// instances of this class referencing the same physical persistent
// data storage path.  Each instance has it's own in memory copy
// of the data. For example...
//
//      $pName = 'foo.json';
//      $boxA = new FileBox($pName);
//      $boxB = new FileBox($pName);

//      $boxA.set('Bird','Cardinal');
//      $boxB.set('Bird','Robin');
//
//      echo $boxA.get('Bird'); // = 'Cardinal'
//          ^^^^^ $boxA in memory array
//                is now out of sync with the persisted
//                data (JSON file).
//      echo $boxB.get('Bird'); // = 'Robin'
//
//      $boxC = new FileBox($pName);
//      echo $boxB.get('Bird'); // = 'Robin' (last value persisted)
//
class FileBox
{
    private $_da;     // data array
    private $_dPath;  // persistent data storage (i.e. file) path


    // Create with default persistent storage path
    //      new FileBox();
    //
    // Create with custom persistent storage path
    //      new Filebox('\mydirectory\myfile.json');
    //
    function __construct($fname=NULL){
        $this->_da = NULL;
        if (is_null($fname)){
            $this->_dPath = "filebox.json";
        }
        else {
            $this->_dPath = $fname;
        }
        if (file_exists($this->_dPath)){
            $jc = file_get_contents($this->_dPath);
            $this->_da = json_decode($jc, true);
        }
    } // __construct()

    /////////////////////////////////////////////////////////////////
    //
    // Sets a value into the data store and persists it.
    //
    // If the persistent doesn't exist yet, it will be created.
    //
    // If the attempt to persist the data fails, the in
    // memory copy of the data store is unchanged and we return NULL.
    //
    // (see comments for setAll method below)
    //
    public function set($key,$value){
        // First create and update a temporary array to work with
        $ta = $this->_da;   
        if (array_key_exists($key, $ta)){
            $ta[$key] = $value;
        }
        else {
            $ta[$key] = $value;
        }

        // persist the data
        return $this->setAll($ta);
    } // set()

    /////////////////////////////////////////////////////////////////
    //
    public function get($key){
        if (!is_array($this->_da)){
            return NULL;
        }

        if (array_key_exists($key, $this->_da)){
            return $this->_da[$key];
        }
        // key isn't in the array
        return NULL;
    } // get()

    /////////////////////////////////////////////////////////////////
    //
    // Returns an array of all values or NULL (if empty).
    //
    // Warning: this does not go out an re-read the persistent file.
    // if the persistent store has changed other than through this
    // object (i.e. through another instance or direct file
    // manipulation), it will only be re-read by creating a new instance.
    //
    public function getAll(){
        return $this->_da;
    } // getAll()

    /////////////////////////////////////////////////////////////////
    //
    // Writes full array of data to file (in JSON format)
    //
    // Note that if json_encode or persist fails for some reason, this
    // method returns NULL and does not modify the existing
    // in memory data store.  It only updates the in memory
    // data if the presist is successful.
    //
    // This method will fail if $aData is NULL.  You must use
    // the method reset() to persistently reset the data store.
    //
    public function setAll($aData){  
        // echo "var_dump($aData)...\n";
        // var_dump($aData);   
        if (is_null($aData)){
            return NULL;
        }
        else {
            $jc = json_encode($aData);
        }
        if (is_null($jc))
            return NULL;
        $writeOK = file_put_contents($this->_dPath,$jc);
        if (is_null($writeOK)){
            return NULL;
        }
        else {
            $this->_da = $aData;
            return $writeOK;          
        }
    } // setAll()

    /////////////////////////////////////////////////////////////////
    //
    // Completely resets the data store in a presistent manner
    //
    public function reset(){
        if (file_exists($this->_dPath)){
            if (unlink($this->_dPath)){
                $this->_da = NULL;
                return true;
            }
            else {
                // most likely a directory or file permissions issue
                return false;
            }
        }
        $this->_da = NULL;
        return true;
    } // reset()
} // class

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
//
// UNIT TESTS/EXAMPLE USAGE
//
// Uncomment the code below AND the first line of code in this file
// to run this file directly (i.e. php -f FileBox.php)
// if you want to perform unit testing.
//
// Permissions for the current directory must be set such that
// the unit tests can read/write files in order to run succcessfully.
//
// The default json file (filebox.json) should NOT exist
// in the current directory.
//
// The non-default json file 'filebox2.json' should NOT exist
// in the current directory.

/********************************************************************

$testNo = 0;

function runningTest($theTestNo){
    $testNo = $theTestNo;
    echo "Running test[".$testNo."]...";
} // runningTest()

function cleanupFiles(){
    echo "Removing temporary files...";
    if (file_exists('filebox.json')){
        unlink('filebox.json');
    }    
    if (file_exists('filebox2.json')){
        unlink('filebox2.json');
    }
    echo "done.\n";
} // cleanupFiles()

function expectEquality($returnedValue, $testValue)
{
    if ($returnedValue !== $testValue){
        echo "failed!\n";
        echo "Expected equality.\n";
        echo "Returned value: ";
        var_dump($returnedValue);     
        echo "Expected Value: ";
        var_dump($testValue);
        cleanupFiles();
        exit($testNo); 
    }
    else {
        echo "PASSED.\n";
    }
} // expectEquality()

function expectDifference($returnedValue, $testValue)
{
    if ($returnedValue === $testValue){
        echo "failed!\n";
        echo "Expected difference.\n";
        echo "Returned value: ";
        var_dump($returnedValue);     
        echo "Expected Value: ";
        var_dump($testValue);
        cleanupFiles();
        exit($testNo); 
    }
    else {
        echo "PASSED.\n";
    }
} // expectDifference()

echo "FileBox Unit tests...\n";

runningTest(1);
expectEquality(file_exists('filebox.json'),false);

runningTest(2);
$a = array('key1' => 'value1', 'key2' => 'value2');
$box1 = new FileBox();
expectEquality($box1->get('key1'), NULL);

runningTest(3);
expectDifference($box1->setAll($a),NULL);

runningTest(4);
expectEquality($box1->get('key1'),'value1');

runningTest(5);
expectEquality($box1->get('key2'), 'value2');

runningTest(6);
expectDifference($box1->set('key3','value3'),NULL);

runningTest(7);
expectEquality($box1->get('key3'),'value3');

runningTest(8);
$fa = $box1->getAll();
expectDifference($fa,NULL);

runningTest(9);
expectEquality($fa['key3'],'value3');

runningTest(10);
$box2 = new FileBox();
expectEquality($box2->get('key3'),'value3');

runningTest(11);
expectDifference($box2->set('key3','notValue3'),NULL);

runningTest(12);
expectEquality($box1->get('key3'),'value3');

runningTest(13);
expectEquality(file_exists('filebox2.json'),false);

runningTest(14);
$a2 = array(1 => 'value1', 2 => 'value2');
$box3 = new FileBox('filebox2.json');
expectDifference($box3->setAll($a2),NULL);

runningTest(15);
expectDifference($box1->get(2),'value2');

runningTest(16);
expectEquality($box3->get(2),'value2');

runningTest(17);
$box4 = new FileBox('filebox2.json');
expectEquality($box3->get(2),'value2');

runningTest(18);
expectEquality($box3->get('2'),'value2');

// PASSED ALL TESTS!
cleanupFiles();
echo "All unit tests PASSED!\n";

*********************************************************/



