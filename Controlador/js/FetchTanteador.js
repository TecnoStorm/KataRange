
  var ciParticipante = localStorage.getItem('ciParticipante');
  var formData = new FormData();
  formData.append("ciParticipante", ciParticipante); 
  fetch('../../Controlador/Participante/Tanteador.php', {
    method: "POST",
    body: formData,
    })
  
    .then(response => response.text())
    .then(data => {
      const resultado = document.getElementById('php');
      resultado.innerHTML = data;
    })
    .catch(error => {
      console.error('Error:', error);
    });