<nav id="menuApp" class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" data-modo="RIE" href="#">RIE</a>
    <button class="navbar-toggler ml-auto" type="button" data-bs-toggle="collapse" data-bs-target="#modoApp" aria-controls="modoApp" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="modoApp">
      <ul class="navbar-nav ml-auto mb-lg-0 ">
        <li class="nav-item">
          <a class="nav-link" href="index.php">RIE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="archivo.php">Archivo</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="encabezado">
  <span></span>
  <span></span>
</div>
<main>
</main>

<div id="ventana" style="display: none;">
  <div class="titulo">
    <span>NUEVO REGISTRO</span>
    <span id="Cerrar">
      <i class="fas fa-window-close"></i>
      <span>Cerrar</span>
    </span>
  </div>
  <form id="formularioRegistro">
    <h6>Tipo:</h6>
    <div id="seleccionTipo">
      <span>
        <label for="banco">
          Banco
        </label>
        <input type="radio" name="tipo" value="banco" id="banco">
      </span>
      <span>
        <label for="ingreso">
          Ingreso
        </label>
        <input type="radio" name="tipo" value="ingreso" id="ingreso" checked>
      </span>
      <span>
        <label for="egreso">
          Egreso
        </label>
        <input type="radio" name="tipo" value="egreso" id="egreso">
      </span>
      <span>
        <label for="saldo">
          Saldo
        </label>
        <input type="radio" name="tipo" value="saldo" id="saldo">
      </span>
    </div>
    <div id="camposRegistro">
      <div>
        <label for="fecha">
          Fecha:
        </label>
        <input type="date" name="fecha" id="fecha">
      </div>
      <div>
        <label for="monto">
          Monto:
        </label>
        <input type="number" name="monto" id="monto" placeholder="$$$">
      </div>  
      <div>
        <label for="descripcion">
          Descripcion:
        </label>
        <input type="text" name="descripcion" id="descripcion" placeholder="Descripción">
      </div>
      <div>
        <label for="referido">
          Referido:
        </label>
        <input type="text" name="referido" id="referido" placeholder="Cliente/Proveedor">
      </div>
    </div>
  </form>
  <div class="pie">
    <div></div>
    <span id="Guardar" data-regid="0">
      <i class="far fa-save"></i>
      <span>Guardar</span>
    </span>
    <span id="Cancelar">
      <i class="fas fa-window-close"></i>
      <span>Cancelar</span>
    </span>
  </div>
</div>

<footer>
  <div id="Eliminar">
    <i class="fas fa-trash-alt"></i>
    <span>Eliminar</span>
  </div>
  <div id="Duplicar">
    <i class="far fa-copy"></i>
    <span>Duplicar</span>
  </div>
  <div id="Ocultar">
    <i class="far fa-eye-slash"></i>
    <span>Ocultar</span>
  </div>
  <div id="Nuevo">
    <i class="fas fa-plus-square"></i>
    <span>Nuevo</span>
  </div>
</footer>