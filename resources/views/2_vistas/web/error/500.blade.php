<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="UTF-8">
		<title>Pago rechazado</title>
		<script>
			window.opener?.postMessage("pago_cancelado", "*");
			window.close(); // cierra la ventana automáticamente
		</script>
	</head>

	<body>
		<p>Redirigiendo…</p>
	</body>

</html>
