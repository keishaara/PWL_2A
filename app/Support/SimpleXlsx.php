<?php

namespace App\Support;

use ZipArchive;

class SimpleXlsx
{
    /**
     * Build an XLSX file and return its temporary file path.
     *
     * @param  array<string, array{headers: array<int, string>, rows: array<int, array<int, mixed>>}>  $sheets
     * @return string Temporary file path of the generated XLSX file
     */
    public static function create(array $sheets): string
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'xlsx_');
        $zip = new ZipArchive();

        if ($zip->open($tempFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException("Cannot create zip archive: {$tempFile}");
        }

        $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
        $contentTypes .= '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">' . "\n";
        $contentTypes .= '  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>' . "\n";
        $contentTypes .= '  <Default Extension="xml" ContentType="application/xml"/>' . "\n";
        $contentTypes .= '  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>' . "\n";

        $sheetIndex = 1;
        foreach ($sheets as $name => $data) {
            $contentTypes .= "  <Override PartName=\"/xl/worksheets/sheet{$sheetIndex}.xml\" ContentType=\"application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml\"/>\n";
            $sheetIndex++;
        }
        $contentTypes .= '</Types>';
        $zip->addFromString('[Content_Types].xml', $contentTypes);

        $rootRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
        $rootRels .= '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' . "\n";
        $rootRels .= '  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>' . "\n";
        $rootRels .= '</Relationships>';
        $zip->addFromString('_rels/.rels', $rootRels);

        $workbookXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
        $workbookXml .= '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">' . "\n";
        $workbookXml .= '  <sheets>' . "\n";

        $workbookRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
        $workbookRels .= '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' . "\n";

        $sheetIndex = 1;
        foreach ($sheets as $sheetTitle => $data) {
            $safeTitle = htmlspecialchars(mb_substr($sheetTitle, 0, 31), ENT_QUOTES | ENT_XML1, 'UTF-8');
            $workbookXml .= "    <sheet name=\"{$safeTitle}\" sheetId=\"{$sheetIndex}\" r:id=\"rId{$sheetIndex}\"/>\n";
            $workbookRels .= "  <Relationship Id=\"rId{$sheetIndex}\" Type=\"http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet\" Target=\"worksheets/sheet{$sheetIndex}.xml\"/>\n";
            $sheetIndex++;
        }

        $workbookXml .= '  </sheets>' . "\n";
        $workbookXml .= '</workbook>';
        $zip->addFromString('xl/workbook.xml', $workbookXml);

        $workbookRels .= '</Relationships>';
        $zip->addFromString('xl/_rels/workbook.xml.rels', $workbookRels);

        $sheetIndex = 1;
        foreach ($sheets as $sheetTitle => $data) {
            $sheetXml = static::buildSheetXml($data['headers'] ?? [], $data['rows'] ?? []);
            $zip->addFromString("xl/worksheets/sheet{$sheetIndex}.xml", $sheetXml);
            $sheetIndex++;
        }

        $zip->close();

        return $tempFile;
    }

    protected static function buildSheetXml(array $headers, array $rows): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
        $xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">' . "\n";
        $xml .= '  <sheetData>' . "\n";

        $rowIndex = 1;

        if (! empty($headers)) {
            $xml .= "    <row r=\"{$rowIndex}\">\n";
            $colIndex = 1;
            foreach ($headers as $h) {
                $cellRef = static::colLetter($colIndex) . $rowIndex;
                $val = htmlspecialchars((string) $h, ENT_QUOTES | ENT_XML1, 'UTF-8');
                $xml .= "      <c r=\"{$cellRef}\" t=\"inlineStr\"><is><t>{$val}</t></is></c>\n";
                $colIndex++;
            }
            $xml .= "    </row>\n";
            $rowIndex++;
        }

        foreach ($rows as $row) {
            $xml .= "    <row r=\"{$rowIndex}\">\n";
            $colIndex = 1;
            foreach ($row as $cell) {
                $cellRef = static::colLetter($colIndex) . $rowIndex;
                if (is_numeric($cell) && ! str_starts_with((string) $cell, '0') && strlen((string) $cell) <= 15) {
                    $xml .= "      <c r=\"{$cellRef}\" t=\"n\"><v>{$cell}</v></c>\n";
                } else {
                    $val = htmlspecialchars((string) ($cell ?? ''), ENT_QUOTES | ENT_XML1, 'UTF-8');
                    $xml .= "      <c r=\"{$cellRef}\" t=\"inlineStr\"><is><t>{$val}</t></is></c>\n";
                }
                $colIndex++;
            }
            $xml .= "    </row>\n";
            $rowIndex++;
        }

        $xml .= '  </sheetData>' . "\n";
        $xml .= '</worksheet>';

        return $xml;
    }

    protected static function colLetter(int $colNumber): string
    {
        $letter = '';
        while ($colNumber > 0) {
            $remainder = ($colNumber - 1) % 26;
            $letter = chr(65 + $remainder) . $letter;
            $colNumber = (int) (($colNumber - 1) / 26);
        }

        return $letter;
    }
}
