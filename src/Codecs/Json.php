<?php

namespace Bvtterfly\Valuestore\Codecs;

use Bvtterfly\Valuestore\Exceptions\DecodeException;
use Bvtterfly\Valuestore\Exceptions\EncodeException;
use JsonException;

class Json implements Codec
{
    public function encode(mixed $content): string
    {
        try {
            return json_encode($content, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new EncodeException($exception->getMessage());
        }
    }

    /**
     * @throws DecodeException
     */
    public function decode(string $content): ?array
    {
        try {
            return json_decode($content, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new DecodeException($exception->getMessage());
        }
    }
}
