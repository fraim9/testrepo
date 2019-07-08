<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ExpiredPassportLoader
{
    protected $_downloadUrl = 'http://guvm.mvd.ru/upload/expired-passports/list_of_expired_passports.csv.bz2';
    protected $_unzippedFilename = 'expired_passports.csv';
    
    public function run()
    {
        $this->download();
        $this->unpack();
        $this->loadToDb();
    }
    
    
    public function download()
    {
        $resource = fopen($this->_downloadUrl, 'r');
        if ($resource) {
            $localName =  pathinfo($this->_downloadUrl, PATHINFO_BASENAME);
            Storage::disk('downloads')->put($localName, $resource);
            fclose($resource);
        }
    }
    
    public function unpack()
    {
        $localName =  pathinfo($this->_downloadUrl, PATHINFO_BASENAME);
        $zippedFilename = storage_path('downloads' . DIRECTORY_SEPARATOR . $localName);
        $unzippendFilename = storage_path('downloads' . DIRECTORY_SEPARATOR . $this->_unzippedFilename);
        if (is_readable($zippedFilename)) {
            $bz = bzopen($zippedFilename, "r");
            $fp = fopen($unzippendFilename, 'w');
            if ($bz && $fp) {
                while (!feof($bz)) {
                    $chunk = bzread($bz, 4096);
                    fputs($fp, $chunk);
                }
                bzclose($bz);
                fclose($fp);
            }
        }
    }
    
    
    public function loadToDb()
    {
        $manager = new ExpiredPassportManager();
        
        $tableName = $manager->getInactiveTablename();
        
        $conn = DB::connection('omnipos_auth');
        $conn->statement('TRUNCATE ' . $tableName);
        $conn->statement('ALTER TABLE ' . $tableName . ' DISABLE KEYS');

        $filename = storage_path('downloads' . DIRECTORY_SEPARATOR . $this->_unzippedFilename);
        $fp = fopen($filename, 'r');
        if ($fp) {
            //$t = 0;
            $i = 0;
            $values = [];
            while ($row = fgetcsv($fp, null, ',')) {
                
                $values[] = '("' . addslashes($row[0]) . '", "' . addslashes($row[1]) . '")';
                
                if ($i++ > 10000) {
                    $conn->statement('INSERT INTO `' . $tableName . '` (`series`, `number`) VALUES ' . implode(',', $values));
                    $i = 0;
                    $values = [];
                }
                
                //if ($t++ > 100000) {
                //    break;
                //}
            }
            fclose($fp);
        }
        
        $conn->statement('ALTER TABLE ' . $tableName . ' ENABLE KEYS');
        
        $manager->switchTables();
    }
    
    
}