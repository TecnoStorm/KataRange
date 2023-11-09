document.addEventListener("DOMContentLoaded", function () {
    var nombreTorneo = localStorage.getItem('nombreTorneo');
    var formData = new FormData();
    formData.append("nombreTorneo", nombreTorneo);

    var urlphp = '../../Controlador/Pool/CreadorPools.php';
    fetch(urlphp, {
        method: "POST",
        body: formData,
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("Hubo un problema con la solicitud");
        }
        return response.text();
    })
    .then(data 
    })
    .catch(error => {
        console.error('Error:', error);
    });
});