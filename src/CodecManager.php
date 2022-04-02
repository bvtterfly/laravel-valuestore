<?php

namespace Bvtterfly\Valuestore;

use Bvtterfly\Valuestore\Codecs\Codec;
use Bvtterfly\Valuestore\Codecs\Json;
use Bvtterfly\Valuestore\Codecs\Yaml;
use Bvtterfly\Valuestore\Exceptions\UnknownCodecException;
use Illuminate\Support\Str;

class CodecManager
{
    public static function get(string $type): Codec
    {
        return match ($type) {
            'json' => app(Json::class),
            'yaml' => app(Yaml::class),
            default => throw new UnknownCodecException()
        };
    }

    public static function guessType(string $fileName): string
    {
        return Str::of($fileName)
            ->lower()
            ->afterLast('.')
            ->value();
    }
}
