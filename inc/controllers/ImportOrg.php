<?php

class ImportOrg {

    public static function prepareXlsxFile($filesArr) {
        $uploadDir = ROOT.'/tmp/';
        $uploadfile = $uploadDir.'importfile.xlsx';
        if (move_uploaded_file($filesArr['import']['tmp_name'], $uploadfile)) {
            rename($uploadfile, $uploadDir . 'importfile.zip'); // переименовываем файл в zip архив
            $zip = new ZipArchive; // распаковываем файл
            if ($zip->open($uploadDir . 'importfile.zip') === TRUE) {
                $zip->extractTo($uploadDir . '/importfile/');
                $zip->close();
                return $uploadDir . 'importfile/';
            }
        }
    }

    public static function getCountRowsInXlsx($dirImpPath) {
        $reader = new XMLReader();
        $reader->open($dirImpPath . 'xl/worksheets/sheet1.xml');
        $count = 0;
        while($reader->read()) {
            if($reader->nodeType == XMLReader::ELEMENT) {
                if($reader->localName == 'row') {
                    $count = $reader->getAttribute("r");
                }
            }
        }
        echo '{"count":"'.$count.'"}';
    }

    public static function importFromXlsx($dirImpPath,$startRow,$allRows) {
        require_once (ROOT.'/inc/models/OrgModel.php');
        $xml = simplexml_load_file($dirImpPath . 'xl/sharedStrings.xml');

        foreach ($xml->children() as $item) {
            $sharedStringsArr[] = (string)$item->t;
        }

        $chunkSize = 10;
        //$startRow = 2;
        $end = '';

        $reader = new XMLReader();
        $reader->open($dirImpPath . 'xl/worksheets/sheet1.xml');



        $rowsArr = array();
        $lettersArr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC');
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT) {
                if ($reader->localName == 'row') {
                    $rowNum = $reader->getAttribute("r");
                    if ($rowNum > $startRow+$chunkSize) break;
                    if (($rowNum > $startRow)) {
                        $node = new SimpleXMLElement($reader->readOuterXML());
                        $curIdLetter = 0;
                        $curLetter = $lettersArr[$curIdLetter] . $rowNum;
                        $row = array();
                        foreach ($node->children() as $item) {
                            $attr = $item->attributes();
                            $letter = $attr['r'];
                            //if ($curLetter == $letter) {

                            //}else {
                            while ($curLetter != $letter) {
                                //echo $curLetter .' -- '. $letter.'<br>';
                                $row[] = '';
                                $curIdLetter++;
                                if ($curIdLetter >= count($lettersArr)) break;
                                $curLetter = $lettersArr[$curIdLetter] . $rowNum;
                            }
                            //}
                            $curIdLetter++;
                            if ($curIdLetter <= count($lettersArr) - 1) $curLetter = $lettersArr[$curIdLetter] . $rowNum;


                            $value = isset($item->v) ? (string)$item->v : '';
                            $row[] = (isset($attr['t']) && $attr['t'] == 's') ? $sharedStringsArr[$value] : $value;
                        }
                        while ($curIdLetter < count($lettersArr)) {
                            $row[] = '';
                            $curIdLetter++;
                        }

                        if (!empty($row[0])) {
                            $rowOut = array();
                            $rowOut['name'] = $row[3];
                            $rowOut['fullname'] = $row[4];
                            $rowOut['descr'] = $row[5];
                            $rowOut['cats'] = $row[7];
                            $rowOut['city'] = $row[9];
                            $rowOut['address'] = $row[10];
                            $rowOut['prim'] = $row[11];
                            $rowOut['mobile'] = $row[12];
                            $rowOut['phones'] = $row[13];
                            $rowOut['fax'] = $row[14];
                            $rowOut['site'] = $row[15];
                            $rowOut['email'] = $row[16];
                            $rowOut['width'] = $row[17];
                            $rowOut['length'] = $row[18];
                            $rowOut['facebook'] = $row[19];
                            $rowOut['instagram'] = $row[20];
                            $rowOut['twitter'] = $row[21];
                            $rowOut['vk'] = $row[22];
                            $rowOut['grafik'] = $row[23];
                            $rowOut['yslugi'] = $row[24];
                            $rowOut['opisanie'] = $row[25];
                            $rowOut['metro'] = $row[27];
                            $rowOut['dometro'] = $row[28];
                            //$rowsArr[] = $rowOut;
                            OrgModel::import($rowOut);
                        }
                    }
                    if ($rowNum == $allRows) {
                        $end = 'end';
                        self::clearTmpDir(ROOT.'/tmp');
                    }

                }
            }
        }
        $startRow += $chunkSize;
        echo '{"end":"'.$end.'","endRow":"'.$startRow.'"}';
    }

    public static function clearTmpDir($dir) {
        if ($objs = glob($dir."/*")) {
            foreach($objs as $obj) {
                is_dir($obj) ? rmdir($obj) : unlink($obj);
            }
        }
        self::clearTmpDir($dir);
    }

}