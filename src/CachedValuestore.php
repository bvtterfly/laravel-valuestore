<?php

namespace Bvtterfly\Valuestore;

class CachedValuestore extends Valuestore
{
    protected ?array $cache;

    /**
     * @param array $values
     *
     * @return Valuestore
     */
    protected function setContent(array $values)
    {
        return parent::setContent($this->cache = $values);
    }

    /**
     * Get all values from the store.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->cache ?? $this->cache = parent::all();
    }

    /**
     * Clears the local cache.
     *
     * @return $this
     */
    public function clearCache()
    {
        $this->cache = null;

        return $this;
    }
}
