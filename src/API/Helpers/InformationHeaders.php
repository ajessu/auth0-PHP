<?php

namespace Auth0\SDK\API\Helpers;

final class InformationHeaders
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param string $name
     * @param string $version
     */
    public function setPackage($name, $version)
    {
        $this->data['name'] = $name;
        $this->data['version'] = $version;
    }

    /**
     * @param string $name
     * @param string $version
     */
    public function setEnvironment($name, $version)
    {
        $this->data['environment'][] = [
            'name'    => $name,
            'version' => $version,
        ];
    }

    /**
     * @param array $data
     */
    public function setEnvironmentData($data)
    {
        $this->data['environment'] = $data;
    }

    /**
     * @param string $name
     * @param string $version
     */
    public function setDependency($name, $version)
    {
        $this->data['dependencies'][] = [
            'name'    => $name,
            'version' => $version,
        ];
    }

    /**
     * @param array $data
     */
    public function setDependencyData($data)
    {
        $this->data['dependencies'] = $data;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function build()
    {
        return base64_encode(json_encode($this->get()));
    }

    /**
     * @param InformationHeaders $headers
     *
     * @return InformationHeaders
     */
    public static function Extend(InformationHeaders $headers)
    {
        $newHeaders = new self();

        $oldData = $headers->get();

        $newHeaders->setEnvironmentData($oldData['environment']);
        $newHeaders->setDependency($oldData['name'], $oldData['version']);

        return $newHeaders;
    }
}
