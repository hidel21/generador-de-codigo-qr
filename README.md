# Generador de Código QR

Esta aplicación PHP permite a los usuarios generar códigos QR basados en la entrada de datos proporcionada por el usuario, utilizando la biblioteca `phpqrcode` y una API personalizada llamada `RapidPrestAPI`.

## Funcionalidades:

1. **Entrada de Datos**: Se aceptan tres campos de entrada del usuario:
   - `nombre`
   - `cantidad`
   - `telefono`
   
2. **Validación de Datos**: Antes de procesar la solicitud, el script valida que:
   - Todos los campos están completos.
   - El `nombre` no excede los 50 caracteres.
   - `cantidad` es un número positivo.
   - `telefono` contiene exactamente 10 dígitos.
   
3. **Generación de Código QR**: 
   - Se hace una solicitud a `RapidPrestAPI` para obtener los datos necesarios para el código QR.
   - Una vez obtenido el código, se utiliza la biblioteca `phpqrcode` para generar la imagen QR y se guarda en el directorio `temp/`.

4. **Mostrar Resultados**:
   - Si hay algún error en el proceso, se mostrará un mensaje de error.
   - Si todo sale bien, se mostrará la imagen generada del código QR con una opción para descargarla.
   
5. **Interfaz Web**:
   - La interfaz utiliza Bootstrap 4.5.2 para un diseño limpio y responsivo.
   - Los resultados se muestran dentro de una tarjeta con el título "Resultado QR".

## Requisitos:

1. Asegúrese de tener instalado y configurado un servidor web con soporte para PHP.
2. La biblioteca `phpqrcode` debe estar presente en el directorio.
3. La clase `RapidPrestAPI` debe estar disponible y configurada correctamente.
4. Se necesita permiso para escribir en el directorio de la aplicación para crear y guardar los códigos QR en la carpeta `temp/`.
5. Docker debe estar instalado y configurado en tu máquina.

## Uso de Docker:

Esta aplicación está diseñada para ejecutarse en un contenedor Docker. Aquí están los pasos para configurar y ejecutar la aplicación con Docker:

1. **Construir la Imagen**:

   ```bash
   docker build -t myapp-qr-generator .

   
2. **Ejecutar el contenedor**

  ```bash
  docker run -p 8080:80 myapp-qr-generator
```
3.Una vez que el contenedor esté en ejecución, puedes acceder a la aplicación en tu navegador en la dirección http://localhost:8080/.

4.Cuando hayas terminado, puedes detener el contenedor con Ctrl+C.
