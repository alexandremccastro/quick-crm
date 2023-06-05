<?php

function validateCPF($cpf)
{
  // Remove any non-digit characters from the CPF
  $cpf = preg_replace('/[^0-9]/is', '', $cpf);

  // heck if the CPF has 11 digits
  if (strlen($cpf) != 11) {
    return false;
  }

  // Check if is not a repeated pattern
  if (preg_match('/(\d)\1{10}/', $cpf)) {

    return false;
  }

  // Makes the calculation to validate the CPF
  for ($t = 9; $t < 11; $t++) {
    for ($d = 0, $c = 0; $c < $t; $c++) {
      $d += $cpf[$c] * (($t + 1) - $c);
    }
    $d = ((10 * $d) % 11) % 10;
    if ($cpf[$c] != $d) {
      return false;
    }
  }
  return true;
}

function validateCNPJ($cnpj)
{
  // Remove any non-digit characters from the CNPJ
  $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

  // Check if the CNPJ has 14 digits
  if (strlen($cnpj) !== 14) {
    return false;
  }

  // Validate the CNPJ using the verification digits
  $sum = 0;
  $weight = 2;
  for ($i = 11; $i >= 0; $i--) {
    $sum += $cnpj[$i] * $weight;
    $weight = ($weight == 9) ? 2 : $weight + 1;
  }

  $remainder = $sum % 11;
  $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

  if ($cnpj[12] != $digit1) {
    return false;
  }

  $sum = 0;
  $weight = 2;
  for ($i = 12; $i >= 0; $i--) {
    $sum += $cnpj[$i] * $weight;
    $weight = ($weight == 9) ? 2 : $weight + 1;
  }

  $remainder = $sum % 11;
  $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

  if ($cnpj[13] != $digit2) {
    return false;
  }

  return true;
}
