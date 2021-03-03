<?php


namespace App\Enum;


interface Message
{
    const SUCCESS = 'Item has been save successfully';
    const DELETE = 'Item has been delete successfully';
    const ERROR   = 'Something went wrong, Please try again';
}
