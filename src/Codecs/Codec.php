<?php

namespace Bvtterfly\Valuestore\Codecs;

interface Codec
{
    public function encode(mixed $content): string;

    public function decode(string $content): ?array;
}
