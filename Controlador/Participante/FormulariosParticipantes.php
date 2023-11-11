<?php 
require_once ("../../Modelo/Participante/ParticipanteArray.php");
require_once ("../../Modelo/Escuela/EscuelaArray.php");
$torneos=new TorneoArray();
$escuelas=new EscuelaArray();
$nombresTorneo=$torneos->nombresTorneo();
$nombres=$escuelas->nombresEscuela();
echo "<section id='registrar'>
        <h2 class='Traducir'> Registrar Participantes</h2>
        <form id='registrarParticipante'>
        <section class='registrar-contenedor'>
          <section class='registrar1'>
            <input type='number'name='ci' placeholder='CI' id='ci' class='TraducirInput' required>
            <input type='text' name='nombre' placeholder='Nombre' id='nombre' class='TraducirInput'required>
            <input type='text' name='apellido' placeholder='Apellido' id='apellido' class='TraducirInput' required>
          </section>
        <section class='registrar1'>
          <select name='categoria' id='categoria'required> Categoria
              <option selected hidden class='Traducir'>Ingrese categoria</option>
              <option value='12/13'>12/13</option>
              <option value='14/15'>14/15</option>
              <option value='16/17'>16/17</option>
              <option value='mayores'class='Traducir'>Mayores</option>
          </select>
            <select name='sexo' id='sexo'required>
            <option selected hidden class='Traducir'>Ingrese sexo</option>
            <option value='Masculino'class='Traducir'>Masculino</option>
            <option value='Femenino' class='Traducir'>Femenino</option>
          </select>
          <select name='Condicion' id='Condicion'required>
            <option value='Ninguna' class='Traducir'>Ninguna</option>
            <option selected hidden class='Traducir'>Ingrese condicion</option>
            <option value='K10'> K10</option>
            <option value='K11'> K11</option>
            <option value='K12'> K12</option>
            <option value='K20'> K20</option>
            <option value='K21'> K21</option>
            <option value='K22'> K22</option>
            <option value='K23'> K23</option>
            <option value='K30'> K30</option>
            <option value='K40'> K40</option>
          </select>
        </section>

      <select name='nombreEscuela'required>
        <option selected class='Traducir' hidden>Ingrese escuela</option>";
          foreach($nombres as $nombre){
            echo "<option value='$nombre'> $nombre </option>";
          }
          echo "</select>
       
          <select name='nombreTorneo' id='torneo'>
          <option selected class='Traducir' hidden>Ingrese Torneo</option>";
          foreach($nombresTorneo as $nombre){
                echo "<option value='$nombre'> $nombre </option>";
          }
          echo "</select>
          <section class='boton-registrar'>
          <p id='mensajeError'></p>

          <input type='submit' name='registrar' value='Registrar' class='btnregistrar TraducirValue'>
          <h2 class='Traducir'>Mostrar participantes</h2>
          <a href='Mostrar.html' class='Traducir btnregistrar'> Mostrar</a>
          </section>
          </form>
          </section>
 <h2 class='Traducir'> Registrar escuela</h2>
 <form id='formularioEscuela'>
  <input type='text' name='nombreEscuela' id='nombreEscuela' placeholder='Nombre de la escuela' class='TraducirInput' required>
  <input type='text' name='tecnica' id='nombreEscuela' placeholder='Técnica que enseña' class='TraducirInput' required>
  <section class='boton-registrar'>
 <input type='submit' name='registrarEscuela' value='Registrar' class='btnregistrar TraducirValue'>
 </section>
 </form>
 <p id='mensajeSelect'></p>
 <p id='mensajeEscuela'></p>
   </section>
   </section>
 <h2 class='Traducir'> Torneos disponibles </h2>";
 echo "<section id='contenedorTabla'>";
 $torneos->mostrar();
 echo "</section>";
echo"<section id='borrar'>
   <h2 class='Traducir'>Borrar participante</h2>
   <form id='FormularioBorrar'>
   <input type='number' name='ciBorrar' placeholder='CI' id='ciBorrar' class='TraducirInput' required>
   <section class='boton-registrar'>
   <input type='submit' name='Borrar' value='Borrar' class='btnregistrar TraducirValue'>
   <p id='mensajeBorrar'></p>
   <p id='mensajeErrorBorrar'></p>
   </section>
   </form>
   </section>
   <section id='salir'>
   <a href='../../Vista/Tecnico/opcionesTecnico.html' class='Traducir btnvolver'> 
   <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
       <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z'/>
       <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z'/>
     </svg>
     Volver</a>
   </section>
 ";
?>