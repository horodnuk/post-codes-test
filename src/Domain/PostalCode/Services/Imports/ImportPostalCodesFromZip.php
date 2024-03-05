<?php

declare(strict_types=1);

namespace App\Domain\PostalCode\Services\Imports;

use App\Domain\PostalCode\PostalCode;
use App\Domain\PostalCode\PostalCodeRepository;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use OpenSpout\Reader\XLSX\Reader;
use ZipArchive;

class ImportPostalCodesFromZip
{
    private PostalCodeRepository $repository;

    public function __construct(PostalCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    private string $tmpDirPath;

    private array $mapColumns = [
        'region' => 1,
        'district_old' => 2,
        'district_new' => 3,
        'settlement' => 4,
        'postal_code' => 5,
        'region_eng' => 6,
        'district_new_eng' => 7,
        'settlement_eng' => 8,
        'post_office' => 9,
        'post_office_eng' => 10,
        'post_code' => 11,
    ];

    public function import(string $filePath): void
    {
        $this->extractFile($filePath);

        $this->handleXlsxFile($filePath);
    }

    /**
     * @throws OpenZipFileException
     */
    private function extractFile(string $filePath): void
    {
        $this->tmpDirPath = storage_path('tmp');

        $zip = new ZipArchive;

        $zipOpenStatus = $zip->open($filePath);
        if ($zipOpenStatus !== true) {
            $status = is_int($zipOpenStatus)
                ? "Status code: {$zipOpenStatus}"
                : '';
            throw new OpenZipFileException("Error open zip file. {$status}");
        }

        $this->createTmpFile();

        $zip->extractTo($this->tmpDirPath);
        $zip->close();
    }

    /**
     * @throws OpenXlsxFileException
     * @throws ReaderNotOpenedException
     * @throws IOException
     */
    private function handleXlsxFile(string $filePath): void
    {
        $xlsxFile = scandir($this->tmpDirPath)[2];
        $xlsxFilePath = "{$this->tmpDirPath}/$xlsxFile";

        if (!file_exists($xlsxFilePath)) {
            throw new OpenXlsxFileException("Error open xlsx file.");
        }

        $this->removeBeforeImportedCodes();

        $reader = new Reader();
        $reader->open($xlsxFilePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            $items = [];

            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->getCells();

                $canHandleRow = isset($cells[$this->mapColumns['post_code']]) && (int)$cells[$this->mapColumns['post_code']]->getValue() > 0;
                if ($canHandleRow) {
                    $payload = [
                        'region' => $cells[$this->mapColumns['region']]->getValue(),
                        'district_old' => $cells[$this->mapColumns['district_old']]->getValue(),
                        'district_new' => $cells[$this->mapColumns['district_new']]->getValue(),
                        'settlement' => $cells[$this->mapColumns['settlement']]->getValue(),
                        'postal_code' => $cells[$this->mapColumns['postal_code']]->getValue(),
                        'post_code' => $cells[$this->mapColumns['post_code']]->getValue(),
                        'region_eng' => $cells[$this->mapColumns['region_eng']]->getValue(),
                        'district_new_eng' => $cells[$this->mapColumns['district_new_eng']]->getValue(),
                        'settlement_eng' => $cells[$this->mapColumns['settlement_eng']]->getValue(),
                        'post_office' => $cells[$this->mapColumns['post_office']]->getValue(),
                        'post_office_eng' => $cells[$this->mapColumns['post_office_eng']]->getValue(),
                        'is_imported' => true,
                    ];

                    $items[] = new PostalCode(...$payload);
                }

                if (count($items) > 100) {
                    $this->saveItems($items);
                    $items = [];
                }
            }
        }

        $reader->close();

        $this->removeTmpFile();
    }

    private function createTmpFile(): void
    {
        if (!file_exists($this->tmpDirPath)) {
            mkdir($this->tmpDirPath, 0777, true);
        } else {
            array_map('unlink', glob("$this->tmpDirPath/*.*"));
        }
    }

    private function removeTmpFile(): void
    {
        if (!file_exists($this->tmpDirPath)) {
            return;
        }

        array_map('unlink', glob("$this->tmpDirPath/*.*"));

        rmdir($this->tmpDirPath);
    }

    private function removeBeforeImportedCodes(): void
    {
        $this->repository->removeImported();
    }

    private function saveItems(array $items): void
    {
        $this->repository->bulkInsert($items);
    }
}
