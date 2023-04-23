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

    public function delete($key)
    {
        $this->cacheFile = $key . $this->cacheExt;
        $this->cachePath = $this->cacheDir . $this->cacheFile;

        if (file_exists($this->cachePath)) {
            unlink($this->cachePath);
        }
    }

    public function has($key)
    {
        $this->cacheFile = $key . $this->cacheExt;
        $this->cachePath = $this->cacheDir . $this->cacheFile;

        if (file_exists($this->cachePath)) {
            return true;
        }

        return false;
    }

    public function remember($key, $expire, $callback)
    {
        if ($this->has($key)) {
            return $this->get($key);
        }

        $this->set($key, $callback(), $expire);

        return $this->get($key);
    }

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
