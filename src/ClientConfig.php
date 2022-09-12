<?php

namespace Shitutech\Fec;

final class ClientConfig
{
    private $merchantNo = "";
    private $providerNo = "";
    private $productNo = "";
    private $taskCode = "";
    private $privateKey = "";
    private $systemPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxIidk18omKtKTMOD5dTdX353yxvwk4J+VwVlQ5/rAJwnFBeXmy3kJG3hJj/K3lChr5wLrIpUJQB/dyQqOxMvklw13Uldwe9nd+ffCZfJ0V7guXVfymnyicd9Dz9leuXLV7H+xmjyrz8pFWdtE1KjN5yMAkFhv8EXPsHNgqMA1yCTysz+z8RCu27BYQC3OFgLLKxGH46gbu6m8kUEbvPJlZ5WtwUGcgv62KOVmg40dVpKhNXPjGaljj2ZVFYJiszBLcVVJ6UzJkCykjdB7BUPxXWuaprStELnGvnKY68fEWME8gRWmMBydUJZ8YNlTf+6gVyHXWw/eGKIC+vUCqKTMwIDAQAB";

    private function __construct()
    {
        //
    }

    private function __clone()
    {
        //
    }

    public static function getInstance(): ClientConfig
    {
        static $objSelf = null;

        if ($objSelf === null) {
            $objSelf = new self();
        }

        return $objSelf;
    }

    /**
     * @return string
     */
    public function getMerchantNo(): string
    {
        return $this->merchantNo;
    }

    /**
     * @param string $merchantNo
     * @return ClientConfig
     */
    public function setMerchantNo(string $merchantNo): self
    {
        $this->merchantNo = trim($merchantNo);

        return $this;
    }

    /**
     * @return string
     */
    public function getProviderNo(): string
    {
        return $this->providerNo;
    }

    /**
     * @param string $providerNo
     * @return ClientConfig
     */
    public function setProviderNo(string $providerNo): self
    {
        $this->providerNo = trim($providerNo);

        return $this;
    }

    /**
     * @return string
     */
    public function getProductNo(): string
    {
        return $this->productNo;
    }

    /**
     * @param string $productNo
     * @return ClientConfig
     */
    public function setProductNo(string $productNo): self
    {
        $this->productNo = trim($productNo);

        return $this;
    }

    /**
     * @return string
     */
    public function getTaskCode(): string
    {
        return $this->taskCode;
    }

    /**
     * @param string $taskCode
     * @return ClientConfig
     */
    public function setTaskCode(string $taskCode): self
    {
        $this->taskCode = trim($taskCode);

        return $this;
    }

    /**
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    /**
     * @param string $privateKey
     * @return ClientConfig
     */
    public function setPrivateKey(string $privateKey): self
    {
        $this->privateKey = trim($privateKey);

        return $this;
    }

    /**
     * @return string
     */
    public function getSystemPublicKey(): string
    {
        return $this->systemPublicKey;
    }

    /**
     * @param string $systemPublicKey
     * @return ClientConfig
     */
    public function setSystemPublicKey(string $systemPublicKey): self
    {
        $this->systemPublicKey = trim($systemPublicKey);

        return $this;
    }
}
