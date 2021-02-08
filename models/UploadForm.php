<?php
namespace app\models;

use yii\base\Model;
use app\models\UploadForm;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $csvFile;

    public function rules()
    {
        return [
            [['csvFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv', 'checkExtensionByMimeType'=>false, 'maxSize' => 1024*1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'csvFile' => 'Файл csv',
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->csvFile->saveAs('uploads/csv/' . $this->csvFile->baseName . '.' . $this->csvFile->extension);
            return true;
        } else {
            return false;
        }
    }
}