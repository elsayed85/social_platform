<?php

namespace App\Logic\MediaConversions;

use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use App\Logic\Abstracts\MediaConversion;
use App\Logic\Support\MediaConversionData;
use App\Logic\Support\MediaFilesystem;
use App\Logic\Support\MediaTemporaryDirectory;

class MediaVideoThumbConversion extends MediaConversion
{
    protected float $atSecond = 0;

    public function getEngineName(): string
    {
        return 'VideoThumb';
    }

    public function canPerform(): bool
    {
        return $this->isVideo();
    }

    public function getPath(): string
    {
        return $this->getFilePathWithSuffix('jpg');
    }

    public function atSecond(float $value = 0): static
    {
        $this->atSecond = $value;

        return $this;
    }

    public function handle(): MediaConversionData|null
    {
        // Create & copy to temporary directory
        $temporaryDirectory = MediaTemporaryDirectory::create();

        $file = $temporaryDirectory->path($this->getFilepath());
        $thumbFilepath = $this->getFilePathWithSuffix('jpg', $file);

        MediaFilesystem::copyFromDisk($this->getFilepath(), $this->getFromDisk(), $file);

        // Convert
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => config('social.ffmpeg_path'),
            'ffprobe.binaries' => config('social.ffprobe_path'),
        ]);

        $video = $ffmpeg->open($file);
        $duration = $ffmpeg->getFFProbe()->format($file)->get('duration');
        $seconds = $duration <= $this->atSecond ? 0 : $this->atSecond;

        $frame = $video->frame(TimeCode::fromSeconds($seconds));
        $frame->save($thumbFilepath);

        // Copy
        MediaFilesystem::copyToDisk($this->getToDisk(), $this->getPath(), $thumbFilepath);

        // Delete temporary directory
        $temporaryDirectory->delete();

        return MediaConversionData::conversion($this);
    }
}
