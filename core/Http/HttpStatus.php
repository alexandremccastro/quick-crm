<?php

namespace Core\Http;

enum HttpStatus: int
{
  case OK = 200;
  case CREATED = 201;
  case NOT_FOUND = 400;
  case UNAUTHORIZED = 401;
  case FORBIDEN = 403;
  case INTERNAL_SERVER_ERROR = 500;
}
