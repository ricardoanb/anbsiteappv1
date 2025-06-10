<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="UTF-8">
		<title>Pago completado</title>
		<script>
			window.opener?.postMessage("pago_exitoso", "*");
			window.close(); // cierra la ventana automáticamente
		</script>
	</head>

	<body>
		<p>Redirigiendo…</p>
	</body>

</html>
