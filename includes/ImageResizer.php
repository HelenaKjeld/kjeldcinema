<?php

declare(strict_types=1);

class ImageResizer
{
    /** @var GdImage|null */
    protected $image = null;
    protected int $imageType;

    // Hard limits to avoid huge memory use
    protected int $maxWidth  = 4000;
    protected int $maxHeight = 4000;

    // Minimum acceptable size (you can tweak)
    protected int $minWidth  = 300;
    protected int $minHeight = 450;

    // Aspect ratio limits (width / height)
    protected float $minAspectRatio = 0.4; // e.g., portrait-ish
    protected float $maxAspectRatio = 2.5; // e.g., landscape-ish

    protected const ALLOWED_TYPES = [
        IMAGETYPE_JPEG => 'image/jpeg',
        IMAGETYPE_PNG  => 'image/png',
        IMAGETYPE_GIF  => 'image/gif',
    ];

    /**
     * Set minimum image dimensions.
     */
    public function setMinimumSize(int $minWidth, int $minHeight): void
    {
        $this->minWidth  = $minWidth;
        $this->minHeight = $minHeight;
    }

    /**
     * Load and validate an image file.
     *
     * @throws RuntimeException
     */
    public function load(string $filename): void
    {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new RuntimeException('Image not found or not readable.');
        }

        $info = @getimagesize($filename);
        if ($info === false) {
            throw new RuntimeException('File is not a valid image.');
        }

        [$width, $height, $type] = $info;

        if (!isset(self::ALLOWED_TYPES[$type])) {
            throw new RuntimeException('Unsupported image type.');
        }

        if ($width <= 0 || $height <= 0) {
            throw new RuntimeException('Image dimensions are invalid.');
        }

        // Max size protection
        if ($width > $this->maxWidth || $height > $this->maxHeight) {
            throw new RuntimeException('Image is too large in dimensions.');
        }

        // Min size protection
        if ($width < $this->minWidth || $height < $this->minHeight) {
            throw new RuntimeException(
                "Image too small. Minimum size is {$this->minWidth}x{$this->minHeight}px."
            );
        }

        // Aspect ratio protection
        $aspect = $width / $height;
        if ($aspect < $this->minAspectRatio || $aspect > $this->maxAspectRatio) {
            throw new RuntimeException(
                'Image aspect ratio is too unusual. Please upload a more standard poster shape.'
            );
        }

        $this->imageType = $type;

        switch ($type) {
            case IMAGETYPE_JPEG:
                $img = @imagecreatefromjpeg($filename);
                break;
            case IMAGETYPE_PNG:
                $img = @imagecreatefrompng($filename);
                break;
            case IMAGETYPE_GIF:
                $img = @imagecreatefromgif($filename);
                break;
            default:
                throw new RuntimeException('Unsupported image type.');
        }

        if (!$img) {
            throw new RuntimeException('Failed to create image resource.');
        }

        $this->image = $img;
    }

    /**
     * Save the image to a file.
     *
     * @throws RuntimeException
     */
    public function save(string $filename, ?int $imageType = null, int $compression = 85): void
    {
        if (!$this->image) {
            throw new RuntimeException('No image loaded.');
        }

        $type = $imageType ?? $this->imageType;

        // Ensure target directory exists
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
                throw new RuntimeException('Failed to create image directory.');
            }
        }

        switch ($type) {
            case IMAGETYPE_JPEG:
                if (!imagejpeg($this->image, $filename, $compression)) {
                    throw new RuntimeException('Failed to save JPEG.');
                }
                break;

            case IMAGETYPE_PNG:
                // JPEG-style 0–100 → PNG 0–9
                $pngQuality = (int) round(9 - ($compression / 100 * 9));
                imagealphablending($this->image, false);
                imagesavealpha($this->image, true);
                if (!imagepng($this->image, $filename, $pngQuality)) {
                    throw new RuntimeException('Failed to save PNG.');
                }
                break;

            case IMAGETYPE_GIF:
                if (!imagegif($this->image, $filename)) {
                    throw new RuntimeException('Failed to save GIF.');
                }
                break;

            default:
                throw new RuntimeException('Unsupported output type.');
        }
    }

    public function getImageType(): int
    {
        return $this->imageType;
    }

    protected function getWidth(): int
    {
        return imagesx($this->image);
    }

    protected function getHeight(): int
    {
        return imagesy($this->image);
    }

    /**
     * Resize maintaining aspect ratio, based on width.
     */
    public function resizeToWidth(int $width): void
    {
        if ($width <= 0) {
            throw new InvalidArgumentException('Width must be > 0.');
        }
        $ratio  = $width / $this->getWidth();
        $height = (int) round($this->getHeight() * $ratio);
        $this->resize($width, $height);
    }

    /**
     * Resize maintaining aspect ratio, based on height.
     */
    public function resizeToHeight(int $height): void
    {
        if ($height <= 0) {
            throw new InvalidArgumentException('Height must be > 0.');
        }
        $ratio  = $height / $this->getHeight();
        $width  = (int) round($this->getWidth() * $ratio);
        $this->resize($width, $height);
    }

    /**
     * Resize to fixed size (no aspect ratio protection).
     *
     * @throws RuntimeException
     */
    public function resize(int $width, int $height): void
    {
        $width  = max(1, $width);
        $height = max(1, $height);

        if ($width > $this->maxWidth || $height > $this->maxHeight) {
            throw new RuntimeException('Target dimensions too large.');
        }

        $newImage = imagecreatetruecolor($width, $height);

        // Preserve transparency for PNG/GIF
        if (in_array($this->imageType, [IMAGETYPE_PNG, IMAGETYPE_GIF], true)) {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
            imagefilledrectangle($newImage, 0, 0, $width, $height, $transparent);
        }

        if (!imagecopyresampled(
            $newImage,
            $this->image,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $this->getWidth(),
            $this->getHeight()
        )) {
            imagedestroy($newImage);
            throw new RuntimeException('Failed to resize image.');
        }

        if ($this->image) {
            imagedestroy($this->image);
        }

        $this->image = $newImage;
    }

    /**
     * Resize to fit inside a target box and pad (letterbox) to exact size.
     */
    public function resizeAndPad(int $targetWidth, int $targetHeight, array $bgColor = [0, 0, 0, 127]): void
    {
        $srcWidth  = $this->getWidth();
        $srcHeight = $this->getHeight();

        $srcRatio    = $srcWidth / $srcHeight;
        $targetRatio = $targetWidth / $targetHeight;

        if ($srcRatio > $targetRatio) {
            // Source is wider relative to target
            $newWidth  = $targetWidth;
            $newHeight = (int) round($targetWidth / $srcRatio);
        } else {
            // Source is taller relative to target
            $newHeight = $targetHeight;
            $newWidth  = (int) round($targetHeight * $srcRatio);
        }

        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

        // Preserve transparency
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $background = imagecolorallocatealpha($canvas, $bgColor[0], $bgColor[1], $bgColor[2], $bgColor[3]);
        imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $background);

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);

        imagecopyresampled(
            $resized,
            $this->image,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $srcWidth,
            $srcHeight
        );

        // Center the resized image on the canvas
        $dstX = (int) (($targetWidth - $newWidth) / 2);
        $dstY = (int) (($targetHeight - $newHeight) / 2);

        imagecopy($canvas, $resized, $dstX, $dstY, 0, 0, $newWidth, $newHeight);

        if ($this->image) {
            imagedestroy($this->image);
        }
        imagedestroy($resized);

        $this->image = $canvas;
    }

    /**
     * Convenience method for standard poster size.
     */
    public function fitToPosterBox(): void
    {
        // 600x900 is a nice poster size, tweak if you like
        $this->resizeAndPad(600, 900);
    }

    public function __destruct()
    {
        if ($this->image && (is_resource($this->image) || $this->image instanceof GdImage)) {
            imagedestroy($this->image);
        }
    }
}
