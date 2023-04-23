<?php

namespace Engine\Helper;

class Cache
{
    /**
     * Cache directory
     * 
     * @var string
     */
    protected $cacheDir = '../storage/cache/';

    /**
     * Cache file extension
     * 
     * @var string
     */
    protected $cacheExt = '.cache';

    /**
     * Cache file
     * 
     * @var string
     */
    protected $cacheFile;

    /**
     * Cache file path
     * 
     * @var string
     */
    protected $cachePath;

    /**
     * Cache file content
     * 
     * @var string
     */
    protected $cacheContent;

    /**
     * Cache file expiration time
     * 
     * @var int
     */
    protected $cacheExpire;

    /**
     * Set cache
     * 
     * @param string $key
     * @param mixed $value
     * @param int $expire
     * @return void
     */
    public function set($key, $value, $expire = 3600)
    {
        $this->cacheFile = $key . $this->cacheExt;
        $this->cachePath = $this->cacheDir . $this->cacheFile;
        $this->cacheExpire = $expire;

        $this->cacheContent = serialize([
            'value' => $value,
            'expire' => time() + $this->cacheExpire
        ]);

        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }

        file_put_contents($this->cachePath, $this->cacheContent);
    }

    /**
     * Get cache
     * 
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        $this->cacheFile = $key . $this->cacheExt;
        $this->cachePath = $this->cacheDir . $this->cacheFile;

        if (!file_exists($this->cachePath)) {
            return false;
        }

        $this->cacheContent = unserialize(file_get_contents($this->cachePath));

        if ($this->cacheContent['expire'] < time()) {
            unlink($this->cachePath);
            return false;
        }

        return $this->cacheContent['value'];
    }

    /**
     * Delete cache
     * 
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
        $this->cacheFile = $key . $this->cacheExt;
        $this->cachePath = $this->cacheDir . $this->cacheFile;

        if (file_exists($this->cachePath)) {
            unlink($this->cachePath);
        }
    }

    /**
     * Check if cache exists
     * 
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $this->cacheFile = $key . $this->cacheExt;
        $this->cachePath = $this->cacheDir . $this->cacheFile;

        if (file_exists($this->cachePath)) {
            return true;
        }

        return false;
    }

    /**
     * Remember cache
     * 
     * @param string $key
     * @param int $expire
     * @param callable $callback
     * @return mixed
     */
    public function remember($key, $expire, $callback)
    {
        if ($this->has($key)) {
            return $this->get($key);
        }

        $this->set($key, $callback(), $expire);

        return $this->get($key);
    }

    /**
     * Clear cache
     * 
     * @return void
     */
    public function clear()
    {
        $files = glob($this->cacheDir . '*' . $this->cacheExt);

        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
