<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Facades\Storage;

final class FileServices
{
    private const FOLDER = 'public/course/';
    public function savePromo($file, Course $course): void
    {

        $savedFiles = $this->processFilePromo($file, $course);
        $course->promo_img = $savedFiles;
        $course->save();
    }

    public function savaFiles(array $files, Course $course)
    {
        $savedFiles = array_map(
            fn( $file) => $this->processFile($file, $course),
            $files
        );

        $course->files()->createMany($savedFiles);
    }

    private function processFilePromo($file, Course $course): string
    {
        $folder = self::FOLDER . $course->id;
        $name = $this->saveElement($file, $folder);
        return Storage::url("$folder/$name");
    }

    private function processFile($file, Course $course): array
    {

        $folder = self::FOLDER . $course->id;
        $name = $this->saveElement($file, $folder);
        $path = Storage::url("$folder/$name");
        $type = $this->determineFileType($file->getMimeType());
        $promo = $type === 'image' ? $path : asset('images/promo/' . $type . '.png');
        return ['path' => $path, 'type' => $type, 'promo' => $promo , 'name' => $name];
    }


    private function saveElement($file, string $folder): string
    {
        $name = uniqid('', true) . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs($folder, $file, $name);
        return $name;
    }

    /**
     * @param string $mimeType
     * @return string
     */
    private function determineFileType(string $mimeType): string
    {
        return match (true) {
            str_starts_with($mimeType, 'image/') => 'image',
            str_starts_with($mimeType, 'audio/') => 'audio',
            str_starts_with($mimeType, 'video/') => 'video',
            str_starts_with($mimeType, 'text/') => 'text',
            $mimeType === 'application/pdf' => 'pdf',
            $mimeType === 'application/zip' => 'zip',
            $mimeType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                $mimeType === 'application/octet-stream' => 'docx',
            $mimeType === 'application/json' => 'json',
            $mimeType === 'application/xml' => 'xml',
            $mimeType === 'application/x-7z-compressed' => '7z',
            default => 'unknown',
        };
    }


    public function delete(int $id, string $uuid): void
    {

    }
}
