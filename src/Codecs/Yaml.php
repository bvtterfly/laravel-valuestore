<?php

namespace Bvtterfly\Valuestore\Codecs;

use Bvtterfly\Valuestore\Exceptions\DecodeException;
use Bvtterfly\Valuestore\Exceptions\EncodeException;
use Exception;

class Yaml implements Codec
{
    public function encode(mixed $content): string
    {
        try {
            return \Symfony\Component\Yaml\Yaml::dump($content);
        } catch (Exception $exception) {
            throw new EncodeException($exception->getMessage());
        }
    }

    public function decode(string $content): ?array
    {
        try {
            return \Symfony\Component\Yaml\Yaml::parse($content);
        } catch (Exception $exception) {
            throw new DecodeException($exception->getMessage());
        }
    }
}
