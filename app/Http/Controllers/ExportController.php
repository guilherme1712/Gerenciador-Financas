<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Financa;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportController extends Controller
{
    public function exportToExcel()
    {
        $nomeMes = strtoupper(date('M'));
        $ano = date('y');

        $filePath = '/mnt/d/area de trabalho/CONTA_CORRENE.xlsx';

        $spreadsheet = null;
        if (file_exists($filePath)) {
            $spreadsheet = IOFactory::load($filePath);
        } else {
            $spreadsheet = new Spreadsheet();
        }

        $baseSheetName = $nomeMes . $ano;
        $newSheetName = null;

        if ($spreadsheet->sheetNameExists($baseSheetName)) {
            $newSheetName = $baseSheetName . '_new';
        } else {
            $newSheetName = $baseSheetName;
        }
        $sheet = $spreadsheet->createSheet();

        $financa = new Financa();
        $contasData = $financa->searchBillings();
        $creditosData = $financa->searchCreditos();

        $rowIndex = 6;
        usort($contasData, function ($a, $b) {
            return strtotime($a->vencimento) - strtotime($b->vencimento);
        });
        foreach ($contasData as $row) {
            $sheet->getStyle('D')->getNumberFormat()->setFormatCode($this->getCurrencyFormat());
            $banco = $row->banco;
            $vencimento = date('d/m', strtotime($row->vencimento));
            $descricao = strval($row->descricao);
            $valor = strval($row->valor);

            if ($banco == 1) {
                if (date('d', strtotime($row->vencimento)) <= 15) {
                    // Até o dia 15, coloca em colunas A, B, C
                    $sheet->setCellValue("A$rowIndex", $vencimento);
                    $sheet->setCellValue("B$rowIndex", $descricao);
                    $sheet->setCellValue("C$rowIndex", $valor);
                } else {
                    // A partir do dia 16, coloca em colunas E, F, G
                    $sheet->setCellValue("E$rowIndex", $vencimento);
                    $sheet->setCellValue("F$rowIndex", $descricao);
                    $sheet->setCellValue("G$rowIndex", $valor);
                }
            } elseif ($banco == 2) {
                $sheet->setCellValue("I$rowIndex", $vencimento);
                $sheet->setCellValue("J$rowIndex", $descricao);
                $sheet->setCellValue("K$rowIndex", $valor);
            }

            $sheet->getStyle('D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $rowIndex++;
        }

        $creditosData = $financa->searchCreditos();
        $totalEntradas1Q = 0;
        $totalEntradas2Q = 0;
        $currencyFormat = $this->getCurrencyFormat();

        foreach ($creditosData as $credito) {
            $dataCredito = Carbon::parse($credito->data)->format('d');
            $valorCredito = $credito->valor;

            if ($dataCredito <= 15) {
                // Crédito até o dia 15 vai para coluna C5
                $totalEntradas1Q += $valorCredito;
            } else {
                // Crédito após o dia 15 vai para coluna G5
                $totalEntradas2Q += $valorCredito;
            }
        }

        $this->addHeaders($sheet, 3, 'A');
        $this->addHeaders($sheet, 3, 'E');
        $this->addHeaders($sheet, 3, 'I');

        foreach (range('A', $sheet->getHighestColumn()) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $greenStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '00FF00'],
            ],
        ];
        $styleYellow = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
        ];
        $currencyFormat = $this->getCurrencyFormat();

        $sheet->setCellValue("A4", "----");
        $sheet->setCellValue("B4", "Inicial");
        $sheet->setCellValue("C4", 0);
        $sheet->getStyle("A4:C4")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $rowIndex++;
        $sheet->setCellValue("A$rowIndex", "----");
        $sheet->setCellValue("B$rowIndex", "Saídas");
        $sheet->setCellValue("C$rowIndex", '=SUM(C6:C' . ($sheet->getHighestRow() - 1) . ')');
        $sheet->getStyle("C4:C".$sheet->getHighestRow())->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("A$rowIndex:C$rowIndex")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A$rowIndex:C$rowIndex")->applyFromArray($styleYellow);

        $sheet->setCellValue("E$rowIndex", "----");
        $sheet->setCellValue("F$rowIndex", "Saídas");
        $sheet->setCellValue("G$rowIndex", '=SUM(G6:G' . ($sheet->getHighestRow() - 1) . ')');
        $sheet->getStyle("G4:G".$sheet->getHighestRow())->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("E$rowIndex:G$rowIndex")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("E$rowIndex:G$rowIndex")->applyFromArray($styleYellow);

        $rowIndex++;
        $sheet->setCellValue("A$rowIndex", "----");
        $sheet->setCellValue("B$rowIndex", "Entradas");
        $sheet->setCellValue("C$rowIndex", '0');
        $sheet->getStyle("C$rowIndex")->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("A$rowIndex:C$rowIndex")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A$rowIndex:C$rowIndex")->applyFromArray($greenStyle);

        $sheet->setCellValue("E$rowIndex", "----");
        $sheet->setCellValue("F$rowIndex", "Entradas");
        $sheet->setCellValue("G$rowIndex", '0');
        $sheet->getStyle("G$rowIndex")->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("E$rowIndex:G$rowIndex")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("E$rowIndex:G$rowIndex")->applyFromArray($greenStyle);

        $rowIndex++;
        $sheet->setCellValue("A$rowIndex", now()->startOfMonth()->addDays(14)->format('d'));
        $sheet->setCellValue("B$rowIndex", "Final");
        $sheet->setCellValue("C$rowIndex", '=C4+C5-C'.($sheet->getHighestRow() - 2) . '+C'.($sheet->getHighestRow() - 1));
        $sheet->getStyle("C$rowIndex")->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("A$rowIndex:C$rowIndex")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue("E$rowIndex", now()->startOfMonth()->addDays(14)->format('d'));
        $sheet->setCellValue("F$rowIndex", "Final");
        $sheet->setCellValue("G$rowIndex", '=G4+G5-G'.($sheet->getHighestRow() - 2) . '+G'.($sheet->getHighestRow() - 1));
        $sheet->getStyle("G$rowIndex")->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("E$rowIndex:G$rowIndex")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue("E4", "----");
        $sheet->setCellValue("F4", "Inicial");
        $sheet->setCellValue("G4", "=C$rowIndex");
        $sheet->getStyle("A4:C4")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue("A5", now()->startOfMonth()->format('d'));
        $sheet->setCellValue("B5", "entrada");
        $sheet->getStyle("A5:B5")->applyFromArray($greenStyle);
        $sheet->setCellValue("C5", $totalEntradas1Q);
        $sheet->getStyle("C5")->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("C5")->applyFromArray($greenStyle);

        $sheet->setCellValue("E5", now()->startOfMonth()->addDays(15)->format('d'));
        $sheet->setCellValue("F5", "Entrada");
        $sheet->getStyle("E5:F5")->applyFromArray($greenStyle);
        $sheet->setCellValue("G5", $totalEntradas2Q);
        $sheet->getStyle("G5")->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("G5")->applyFromArray($greenStyle);

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'BRADESCO');
        $sheet->getStyle('A1:G1')->getFont()->setSize(20)->setBold(true)->setColor(new Color('FF0000'));
        $sheet->getStyle('H1:H'.$sheet->getHighestRow())->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');

        $sheet->mergeCells('I1:L1');
        $sheet->setCellValue('I1', 'NUBANK');
        $sheet->getStyle('I1:L1')->getFont()->setSize(20)->setBold(true)->setColor(new Color('FF0000'));
        $sheet->getStyle('I1:L1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A2:C2');
        $sheet->getStyle('A2:C2')->getFont()->setSize(14)->setBold(true)->setColor(new Color('000000'));
        $sheet->getStyle('A2:C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:C2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00'); // Amarelo
        $sheet->setCellValue('A2', '1ª QUINZENA');

        $sheet->setCellValue('D2', '');
        $sheet->getStyle('D2:D'. $sheet->getHighestRow())->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');

        $sheet->mergeCells('E2:G2');
        $sheet->getStyle('E2:G2')->getFont()->setSize(14)->setBold(true)->setColor(new Color('000000'));
        $sheet->getStyle('E2:G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2:G2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00'); // Amarelo
        $sheet->setCellValue('E2', '2ª QUINZENA');

        $sheet->mergeCells('I2:L2');
        $sheet->getStyle('I2:L2')->getFont()->setSize(14)->setBold(true)->setColor(new Color('000000'));
        $sheet->getStyle('I2:L2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I2:L2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00'); // Amarelo
        $sheet->setCellValue('I2', '1ª QUINZENA/2ª QUINZENA');

        $sheet->setCellValue('L2', '');
        $sheet->getStyle('L2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00'); // Amarelo

        $this->addHeaders($sheet, 3, 'A');
        $this->addHeaders($sheet, 3, 'E');
        $this->addHeaders($sheet, 3, 'I');

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $spreadsheet = IOFactory::load($filePath);
        $spreadsheet->getActiveSheet()->setTitle($newSheetName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        // $spreadsheet->createSheet();
        // $spreadsheet->setActiveSheetIndex(1);
        // $blankSheet = $spreadsheet->getActiveSheet();
        // $blankSheet->setTitle('BlankSheet');

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return redirect()->route('home');
    }

    private function addHeaders(Worksheet $sheet, int $rowIndex, string $columnIndex)
    {
        $sheet->setCellValue("{$columnIndex}{$rowIndex}", 'DATA');
        $sheet->getStyle("{$columnIndex}{$rowIndex}")->getFont()->setBold(true);
        $columnIndex++;
        $sheet->setCellValue("{$columnIndex}{$rowIndex}", 'GASTO');
        $sheet->getStyle("{$columnIndex}{$rowIndex}")->getFont()->setBold(true);
        $columnIndex++;
        $sheet->setCellValue("{$columnIndex}{$rowIndex}", 'VALOR');
        $sheet->getStyle("{$columnIndex}{$rowIndex}")->getFont()->setBold(true);
    }

    private function getCurrencyFormat()
    {
        return 'R$ #,##0.00';
    }
}
