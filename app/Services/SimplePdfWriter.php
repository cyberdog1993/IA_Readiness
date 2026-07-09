<?php

namespace App\Services;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SimplePdfWriter
{
    public function download(string $filename, string $title, array $lines): BinaryFileResponse
    {
        $path = storage_path('app/'.Str::slug($filename, '_').'.pdf');
        file_put_contents($path, $this->buildPdf($title, $lines));

        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }

    public function buildPdf(string $title, array $lines): string
    {
        $pages = $this->paginate(array_merge([$title, ''], $lines));
        $objects = [];
        $pagesObjectId = 2;
        $fontObjectId = 3;
        $pageObjectId = 4;
        $pageIds = [];

        foreach ($pages as $pageLines) {
            $content = $this->buildPageContent($pageLines);
            $contentObjectId = $pageObjectId++;
            $pageObject = $pageObjectId++;
            $pageIds[] = $pageObject;

            $objects[$contentObjectId] = $this->streamObject($content);
            $objects[$pageObject] = $this->pageObject($contentObjectId, $fontObjectId);
        }

        $objects[1] = "<< /Type /Catalog /Pages {$pagesObjectId} 0 R >>";
        $objects[$pagesObjectId] = "<< /Type /Pages /Kids [".implode(' ', array_map(fn ($id) => "{$id} 0 R", $pageIds))."] /Count ".count($pageIds)." >>";
        $objects[$fontObjectId] = "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>";

        ksort($objects);

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $id => $object) {
            $offsets[$id] = strlen($pdf);
            $pdf .= $id." 0 obj\n".$object."\nendobj\n";
        }

        $xrefPosition = strlen($pdf);
        $count = max(array_keys($objects)) + 1;
        $pdf .= "xref\n0 {$count}\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i < $count; $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i] ?? 0);
        }

        $pdf .= "trailer\n<< /Size {$count} /Root 1 0 R >>\nstartxref\n{$xrefPosition}\n%%EOF";

        return $pdf;
    }

    private function paginate(array $lines, int $linesPerPage = 42): array
    {
        $pages = [];
        $current = [];

        foreach ($lines as $line) {
            $wrapped = $this->wrapLine((string) $line);
            foreach ($wrapped as $wrappedLine) {
                $current[] = $wrappedLine;
                if (count($current) >= $linesPerPage) {
                    $pages[] = $current;
                    $current = [];
                }
            }
        }

        if ($current !== []) {
            $pages[] = $current;
        }

        return $pages ?: [[]];
    }

    private function wrapLine(string $line, int $width = 92): array
    {
        $line = rtrim($line);
        if ($line === '') {
            return [''];
        }

        return explode("\n", wordwrap($line, $width, "\n", true));
    }

    private function buildPageContent(array $lines): string
    {
        $content = "BT\n/F1 12 Tf\n14 TL\n40 800 Td\n";

        foreach ($lines as $index => $line) {
            $safe = $this->escapeText($line);
            if ($index === 0) {
                $content .= "/F1 16 Tf\n({$safe}) Tj\n/F1 12 Tf\n14 TL\n";
            } elseif ($line === '') {
                $content .= "T*\n";
            } else {
                $content .= "({$safe}) Tj\nT*\n";
            }
        }

        $content .= "ET";

        return $content;
    }

    private function pageObject(int $contentObjectId, int $fontObjectId): string
    {
        return "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 {$fontObjectId} 0 R >> >> /Contents {$contentObjectId} 0 R >>";
    }

    private function streamObject(string $content): string
    {
        return "<< /Length ".strlen($content)." >>\nstream\n{$content}\nendstream";
    }

    private function escapeText(string $text): string
    {
        $converted = @iconv('UTF-8', 'Windows-1252//TRANSLIT', $text) ?: $text;

        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $converted);
    }
}
