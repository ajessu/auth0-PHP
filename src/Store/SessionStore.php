<?php

namespace Auth0\SDK\Store;

/*
 * This file is part of Auth0-PHP package.
 *
 * (c) Auth0
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */
use Auth0\SDK\API\Oauth2Client;

/**
 * This class provides a layer to persist user access using PHP Sessions.
 *
 * @author Auth0
 */
final class SessionStore implements StoreInterface
{
    const BASE_NAME = 'auth0_';

    /**
     * @see Oauth2Client
     */
    public function __construct()
    {
        $this->initSession();
    }

    /**
     * This basic implementation of BaseAuth0 SDK uses
     * PHP Sessions to store volatile data.
     */
    private function initSession()
    {
        if (!session_id()) {
            session_set_cookie_params(60 * 60 * 24 * 7); //seven days
            session_start();
        }
    }

    /**
     * Persists $value on $_SESSION, idetified by $key.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $keyName = $this->getSessionKeyName($key);

        $_SESSION[$keyName] = $value;
    }

    /**
     * Gets persisted values idetified by $key.
     * If the value is not setted, returns $default.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $keyName = $this->getSessionKeyName($key);

        if (isset($_SESSION[$keyName])) {
            return $_SESSION[$keyName];
        } else {
            return $default;
        }
    }

    /**
     * Removes a persisted value identified by $key.
     *
     * @param string $key
     */
    public function delete($key)
    {
        $keyName = $this->getSessionKeyName($key);

        unset($_SESSION[$keyName]);
    }

    /**
     * Constructs a session var name.
     *
     * @param string $key
     *
     * @return string
     */
    public function getSessionKeyName($key)
    {
        return self::BASE_NAME.'_'.$key;
    }
}
