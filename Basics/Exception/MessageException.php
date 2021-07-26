<?php

namespace HugCode\WeChat\Basics\Exception;

class MessageException extends WeChatException
{

    /**
     * MessageException constructor.
     * @param $errorCode
     * @param null $errorMessage
     * @param null $previous
     */
    public function __construct($errorCode, $errorMessage = null, $previous = null)
    {
        if (empty($errorMessage)) {
            $errorMessage = $this->codeGetMessage($errorCode);
        }
        parent::__construct($errorMessage, 0, $previous);
        $this->errorMessage = $errorMessage;
        $this->errorCode    = $errorCode;
    }


}
