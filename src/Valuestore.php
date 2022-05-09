<?php

namespace Bvtterfly\Valuestore;

use Bvtterfly\Valuestore\Codecs\Codec;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Spatie\Valuestore\Valuestore as BaseValueStore;

class Valuestore extends BaseValueStore
{
    /**
     * @param string $fileName
     * @param array|null $values
     *
     * @return static
     */
    public static function make(string $fileName, array $values = null): static
    {
        $filesystem = Storage::disk(config('valuestore.disk'));
        $codec = CodecManager::get(CodecManager::guessType($fileName));
        $valuestore = (new static($filesystem, $codec))->setFileName($fileName);

        if (! is_null($values)) {
            $valuestore->put($values);
        }

        return $valuestore;
    }

    protected function __construct(protected Filesystem $filesystem, protected Codec $codec)
    {
        parent::__construct();
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    protected function setContent(array $values)
    {
        $this->filesystem->put($this->fileName, $this->codec->encode($values));

        if (! count($values)) {
            $this->filesystem->delete($this->fileName);
        }

        return $this;
    }

    /**
     * Get all values from the store.
     *
     * @return array
     */
    public function all(): array
    {
        if (! $this->filesystem->exists($this->fileName)) {
            return [];
        }

        return $this->codec->decode($this->filesystem->get($this->fileName)) ?? [];
    }
}
