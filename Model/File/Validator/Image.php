<?php

declare(strict_types=1);

namespace Flipdev\Xicon\Model\File\Validator;

use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Image\Factory;

use Magento\MediaStorage\Model\File\Validator\Image as flipdev_xicon;

class Image extends flipdev_xicon
{
    /**
     * @var array
     */
    private $imageMimeTypes = [
        'png'  => 'image/png',
        'jpe'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg'  => 'image/jpeg',
        'gif'  => 'image/gif',
        'bmp'  => 'image/bmp',
        'ico'  => 'image/vnd.microsoft.icon',
        'ico'  => 'image/x-icon'
    ];

    /**
     * @var Mime
     */
    private $fileMime;

    /**
     * @var Factory
     */
    private $imageFactory;

    /**
     * @var File
     */
    private $file;

    /**
     * @param Mime $fileMime
     * @param Factory $imageFactory
     * @param File $file
     */
    public function __construct(
        Mime $fileMime,
        Factory $imageFactory,
        File $file
    ) {
        $this->fileMime = $fileMime;
        $this->imageFactory = $imageFactory;
        $this->file = $file;
    }

    /**
     * @inheritDoc
     */
    public function isValid($filePath): bool
    {
        $fileMimeType = $this->fileMime->getMimeType($filePath);
        $isValid = true;

        if (in_array($fileMimeType, $this->imageMimeTypes)) {
            try {
                $image = $this->imageFactory->create($filePath);
                $image->open();
            } catch (\Exception $e) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
