<?php
class RedisCache {
    private $redis;

    public function __construct() {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function set($key, $value, $expiration = 3600) {
        $this->redis->set($key, json_encode($value), $expiration);
    }

    public function get($key) {
        $value = $this->redis->get($key);
        return $value ? json_decode($value, true) : null;
    }
}
?>
