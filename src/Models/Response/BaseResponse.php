<?php

namespace Shitutech\Fec\Models\Response;

abstract class BaseResponse
{
    /**
     * @var string 业务返回码
     */
    protected $statusCode = '';

    /**
     * 返回信息
     */
    protected $msg = '';

    /**
     * @return string
     */
    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @param array $resultData
     * @return void
     */
    public function setProperty(array $resultData)
    {
        foreach ($resultData as $name => $value) {
            if (property_exists($this, $name)) {
                $pType = gettype($this->{$name});
                switch ($pType) {
                    case 'boolean':
                        $value = (boolean)$value;
                        break;
                    case 'array':
                        $value = (array)$value;
                        break;
                    case 'object':
                        break;
                    case 'integer':
                        $value = intval($value);
                        break;
                    case 'float':
                    case "double":
                        $value = floatval($value);
                        break;
                    case 'NULL':
                        $value = null;
                        break;
                    case 'string':
                    default:
                        $value = trim($value);
                        break;
                }

                $this->{$name} = $value;
            }
        }
    }
}
