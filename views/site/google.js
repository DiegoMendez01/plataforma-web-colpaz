// TODO: Funcion para iniciar el proceso de inicio de sesion por Google
function startGoogleSignIn()
{
	// Obtener la instancia de autenticacion de Google
	const auth = gapi.auth2.getAuthInstance();
	
	// Iniciar Sesion con Google
	auth.signIn();
}

// TODO: 
function handleCredentialResponse(response)
{
	$.ajax({
		type: 'POST',
		url: '../../controllers/UserController.php?op=registerGoogle',
		contentType: 'application/json',
		headers: {
			"ContentType": "application/json"
		},
		data: JSON.stringify({
			request_type: 'user_auth',
			credential: response.credential
		}),
		success: function(data){
			data = JSON.parse(data);
			if(data.status){
				if(data.access == 0){
					window.location.href = '../../views/home'
				}else{
					window.location.href = '../../views/home'
				}
			}else{
				swal("Error", data.access, "error");
			}
		}
	})
	
	if(response && response.credential){
		const credentialToken = response.credential;
		
		const decodedToken = JSON.parse(atob(credentialToken.split('.')[1]));
	}
}