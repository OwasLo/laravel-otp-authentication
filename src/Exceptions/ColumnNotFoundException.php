<?php

class ColumnNotFoundException extends Exception
{
    public function errorMessage()
    {
        //error message
        $errorMsg = $this->getMessage() . ' is not a valid attribute.';

        return $errorMsg;
    }
}
