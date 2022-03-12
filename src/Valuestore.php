<?php

namespace Bvtterfly\Valuestore;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Spatie\Valuestore\Valuestore as BaseValueStore;

class Valuestore extends BaseValueStore
{
    /**
     * @param string $fileName
     * @param array|null $values
     *
     * @return Valuestore
     */
    public static function make(string $fileName, array $values = null)
    {
        $filesystem = Storage::disk(config('valuestore.disk'));
        $valuestore = (new Valuestore($filesystem))->setFileName($fileName);

        if (! is_null($values)) {
            $valuestore->put($values);
        }

        return $valuestore;
    }

    protected function __construct(protected Filesystem $filesystem)
    {
        parent::__construct();
    }

    /**
     * @param array $values
     *
     * @return Valuestore
     */
    protected function setContent(array $values)
    {
        $this->filesystem->put($this->fileName, json_encode($values));

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

        return json_decode($this->filesystem->get($this->fileName), true) ?? [];
    }
}
