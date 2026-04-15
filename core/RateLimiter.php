<?php

namespace Core;

class RateLimiter
{
    private static $dir = __DIR__ . '/../storage/rate_limits/';

    private static function ensureDir()
    {
        if (!is_dir(self::$dir)) {
            mkdir(self::$dir, 0755, true);
        }
    }

    private static function getFilePath(string $key): string
    {
        return self::$dir . md5($key) . '.json';
    }

    private static function load(string $key): array
    {
        $file = self::getFilePath($key);
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            if (is_array($data)) {
                return $data;
            }
        }
        return ['attempts' => 0, 'last_attempt' => 0, 'blocked_until' => 0];
    }

    private static function save(string $key, array $data): void
    {
        self::ensureDir();
        file_put_contents(self::getFilePath($key), json_encode($data), LOCK_EX);
    }

    /**
     * Check and increment attempts. Returns true if allowed, false if blocked.
     *
     * @param string $key       Unique identifier (e.g. "login_" . IP)
     * @param int    $maxAttempts  Max attempts allowed in the window
     * @param int    $windowSeconds  Time window in seconds
     * @param int    $blockSeconds   How long to block after exceeding max attempts
     */
    public static function attempt(string $key, int $maxAttempts = 5, int $windowSeconds = 60, int $blockSeconds = 300): bool
    {
        $data = self::load($key);
        $now = time();

        if ($data['blocked_until'] > $now) {
            return false;
        }

        if (($now - $data['last_attempt']) > $windowSeconds) {
            $data = ['attempts' => 0, 'last_attempt' => $now, 'blocked_until' => 0];
        }

        $data['attempts']++;
        $data['last_attempt'] = $now;

        if ($data['attempts'] > $maxAttempts) {
            $data['blocked_until'] = $now + $blockSeconds;
            self::save($key, $data);
            return false;
        }

        self::save($key, $data);
        return true;
    }

    public static function clear(string $key): void
    {
        $file = self::getFilePath($key);
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public static function remaining(string $key, int $maxAttempts = 5, int $windowSeconds = 60): int
    {
        $data = self::load($key);
        $now = time();

        if ($data['blocked_until'] > $now) {
            return 0;
        }

        if (($now - $data['last_attempt']) > $windowSeconds) {
            return $maxAttempts;
        }

        return max(0, $maxAttempts - $data['attempts']);
    }

    public static function retryAfter(string $key): int
    {
        $data = self::load($key);
        $now = time();
        return ($data['blocked_until'] > $now) ? ($data['blocked_until'] - $now) : 0;
    }
}
