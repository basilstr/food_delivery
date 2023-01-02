<?php

namespace App\Entity;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class Photo
{
    private $attr;
    private $data;
    private $fileName;
    private $path;

    /**
     *  'avatar' => [
     *      ['prefix' => ''], // залишити оригінал
     *      ['prefix' => 's_', 'w' => 128, 'h' => 128],
     *  ],
     * відсутність ключа в масиві $method не буде виконувати жодні перетворення з файлом що завантажений
     * ключі - назви класів моделей
     */

    private $method = [
        'User' => [
            ['prefix' => '', 'w' => 128, 'h' => 128],
        ],
        'Tag' => [
            ['prefix' => '', 'w' => 512, 'h' => 512], // оригінал буде видалено, замість нього буде ресайзне зображення
        ],
        /*'Provider' => [
            ['prefix' => '', 'w' => 512, 'h' => 512],
        ],
        'Food' => [
            ['prefix' => '', 'w' => 512, 'h' => 512],
        ],*/
    ];

    public function __construct($attr, UploadedFile $data = null)
    {
        $this->attr = $attr;
        $this->data = $data;
        $this->fileName = '';
    }

    public static function make($attr, UploadedFile $data = null)
    {
        $model = new self($attr, $data);
        $model->saveFile();
        $model->transform();
        return $model;
    }

    private function saveFile()
    {
        // формуємо унікальне им'я файлу
        if ($this->data) {
            // зберігаємо його на диск з довільним іменем - в подальшому ми його видалимо
            $this->path = $this->data->store(
                'upload/' . $this->attr,
                'public'
            );
        }
    }

    // якщо є методи обробки зображень для атрибутів - застосовуємо їх
    private function transform()
    {
        if ($this->path) {
            $this->fileName = Str::random(40) . '.' . $this->data->extension(); // Generate a unique, random name + Determine the file's extension based on the file's MIME type...
            if (isset($this->method[$this->attr])) {
                foreach ($this->method[$this->attr] as $method) {
                    if (!is_array($method)) continue;
                    // формування нового имені файлу з урахування префіксів
                    $newPath = 'upload/' . $this->attr . '/' . $method['prefix'] . $this->fileName;
                    copy(storage_path('app/public/') . $this->path, storage_path('app/public/') . $newPath);
                    $img = Image::make(storage_path('app/public/') . $newPath);
                    if (isset($method['w']) && isset($method['h'])) {
                        $img->resize($method['w'], $method['h']);
                    }
                    $img->save(storage_path('app/public/') . $newPath);
                }
                if (is_file(storage_path('app/public/') . $this->path)) {
                    unlink(storage_path('app/public/') . $this->path);
                }
            }else{
                // якщо немає методу обробки, переіменовуємо в визначене і'мя
                $newPath = 'upload/' . $this->attr . '/' .  $this->fileName;
                rename(storage_path('app/public/') . $this->path, storage_path('app/public/') . $newPath);
            }
        }
    }

    public function getFileName()
    {
        return $this->fileName;
    }
}
