<?php

namespace App\Helpers;

class ActionResult implements \ArrayAccess
{
    const CODE_ERROR        = 500;
    const CODE_BAD_REQUEST  = 400;
    const CODE_UNAUTHORIZED = 401;
    const CODE_NOT_FOUND    = 404;
    const CODE_NOT_ALLOWED  = 405;
    const CODE_OK           = 200;
    const CODE_HZ           = 0;
    const TYPE_SUCCESS      = 'success';
    const TYPE_ERROR        = 'error';
    //
    public $success;
    public $error;
    public $type;
    public $message = '';
    public $validation = [];
    public $code = self::CODE_HZ;
    public $data = [];

    public function __construct($isSuccess = null, $message = null, $code = null)
    {
        $this->answer($isSuccess, $message, $code);
    }

    public function answer($isSuccess, $message, $code = null)
    {
        if ($isSuccess) {
            $this->success($message, $code);
        } else {
            $this->error($message, $code);
        }
        return $this;
    }

    public function success($message, $code = null)
    {
        return $this->setSuccess($message, $code);
    }

    public function allOK($message = 'The operation completed successfully.')
    {
        $this->success($message);
        return $this;
    }

    public function errorDB($message = 'There was an error while processing a database query')
    {
        $this->error($message);
        return $this;
    }

    public function error404($message = 'Item not found')
    {
        $this->error($message);
        $this->code = self::CODE_NOT_FOUND;
        return $this;
    }

    public function errorResource404($message = 'Resource not found')
    {
        $this->error($message);
        $this->code = self::CODE_NOT_FOUND;
        return $this;
    }

    public function errorNotAllowed($message = 'Method not allowed')
    {
        $this->error($message);
        $this->code = self::CODE_NOT_ALLOWED;
        return $this;
    }

    public function errorPerms($message = 'You do not have sufficient permissions to perform this action')
    {
        $this->error($message);
        return $this;
    }

    public function errorRequest($message = 'An error occurred while processing the request')
    {
        $this->error($message);
        return $this;
    }

    public function errorIncomingData($message = 'Invalid incoming data')
    {
        $this->error($message);
        $this->code = self::CODE_BAD_REQUEST;
        return $this;
    }

    public function errorUnauthorized($message = 'Unauthorized')
    {
        $this->error($message, false, self::CODE_UNAUTHORIZED);
        return $this;
    }

    public function errorValidation($messages = [])
    {
        $this->error('Validation error');
        $this->setValidation($messages);
        return $this;
    }

    public function error($message, $addValidationMessage = false, $code = null)
    {
        $this->setError($message, $addValidationMessage, $code);
        return $this;
    }

    public function setData($key, $val = null)
    {
        if (is_array($key)) {
            $this->data = $key;
        } else {
            $this->data[strval($key)] = $val;
        }
        return $this;
    }

    public function getData($key = null, $defaultVal = null)
    {
        if (null !== $key) {
            return isset($this->data[$key]) ? $this->data[$key] : $defaultVal;
        } else {
            return $this->data;
        }
    }

    public function setValidation($messages)
    {
        if (is_object($messages) && method_exists($messages, 'toArray')) {
            $this->validation = $messages->toArray();
        } else {
            $this->validation = (array)$messages;
        }
        return $this;
    }

    public function addValidation($message, $field = '')
    {
        $this->validation[$field][] = strval($message);
        return $this;
    }

    public function getValidation()
    {
        return $this->validation;
    }

    protected function setSuccess($message, $code = null)
    {
        if (is_null($code)) {
            $code = self::CODE_OK;
        }
        $this->message = $message;
        $this->success = true;
        $this->error = !$this->success;
        $this->code = $code;
        $this->type = self::TYPE_SUCCESS;
        return $this;
    }
    protected function setError($message, $addValidationMessage, $code = null)
    {
        if (is_null($code)) {
            $code = self::CODE_ERROR;
        }
        $this->message = $message;
        $this->success = false;
        $this->error = !$this->success;
        $this->code = $code;
        $this->type = self::TYPE_ERROR;
        if ($addValidationMessage) {
            $this->addValidation($message);
        }
        return $this;
    }

    public function offsetSet($offset, $value)
    {
        if ($offset && property_exists($this, $offset)) {
            $this->{$offset} = $value;
        }
    }
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }
    public function offsetUnset($offset)
    {
    }
    public function offsetGet($offset)
    {
        return property_exists($this, $offset) ? $this->{$offset} : null;
    }

    public function toArray()
    {
        // we need only public properties
        $props = call_user_func('get_object_vars', $this);
        //$props = array_arrvals($props);
        return $props;
    }

    public static function getInstance()
    {
        return new self();
    }
}