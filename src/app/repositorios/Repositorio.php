<?php
class Repositorio {
  private PDO $conexion;

  public function __construct(PDO $conexion) {
      $this->conexion = $conexion;
  }

  public function iniciarTransaccion(): void { 
      if (!$this->conexion->inTransaction()) $this->conexion->beginTransaction(); 
  }

  public function confirmarTransaccion(): void {
      if ($this->conexion->inTransaction()) $this->conexion->commit(); 
  }
  public function revertirTransaccion(): void { 
      if ($this->conexion->inTransaction()) $this->conexion->rollBack(); 
  }
}